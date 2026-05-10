<?php

namespace App\Services;

use App\Models\CalendarDay;
use App\Models\Promotion;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BookingQuoteService
{
    /**
     * @return array{nights:int,lines:array<int,array>,subtotal_cents:int,discount_cents:int,cleaning_cents:int,tax_cents:int,total_cents:int,promo:?Promotion,errors:array}
     */
    public function quote(Carbon $checkIn, Carbon $checkOut, int $adults, int $children, ?string $promoCode = null): array
    {
        $errors = [];
        if ($checkOut->lte($checkIn)) {
            $errors[] = 'invalid_dates';

            return $this->emptyResult($errors);
        }

        $nights = $checkIn->diffInDays($checkOut);
        if ($nights < 1) {
            $errors[] = 'min_nights';

            return $this->emptyResult($errors);
        }

        $defaultPrice = (int) SiteSetting::get('default_night_price_cents', 15000);
        $globalMin = (int) SiteSetting::get('global_min_nights', 2);
        $maxAdults = (int) SiteSetting::get('max_guests_adults', 4);
        $maxChildren = (int) SiteSetting::get('max_guests_children', 2);
        $horizon = (int) SiteSetting::get('booking_horizon_days', 540);
        $minOffset = (int) SiteSetting::get('min_booking_lead_days', 1);

        if ($adults + $children > $maxAdults + $maxChildren) {
            $errors[] = 'guest_limit';
        }
        if ($adults < 1) {
            $errors[] = 'adults_required';
        }
        if ($checkIn->lt(now()->startOfDay()->addDays($minOffset))) {
            $errors[] = 'lead_time';
        }
        if ($checkIn->gt(now()->addDays($horizon))) {
            $errors[] = 'horizon';
        }

        $lines = [];
        $period = CarbonPeriod::create($checkIn, $checkOut->copy()->subDay());
        $maxMinNights = $globalMin;
        $blocked = false;

        foreach ($period as $date) {
            /** @var Carbon $date */
            $d = $date->toDateString();
            $row = CalendarDay::query()->where('day', $d)->first();
            $price = $row && $row->price_cents !== null ? (int) $row->price_cents : $defaultPrice;
            $minN = $row && $row->min_nights !== null ? (int) $row->min_nights : $globalMin;
            $maxMinNights = max($maxMinNights, $minN);

            if ($row && ($row->is_blocked || $row->is_booked)) {
                $blocked = true;
            }

            $lines[] = [
                'date' => $d,
                'price_cents' => $price,
                'blocked' => $row && ($row->is_blocked || $row->is_booked),
                'label' => $row?->promo_label,
            ];
        }

        if ($blocked) {
            $errors[] = 'unavailable';
        }
        if ($nights < $maxMinNights) {
            $errors[] = 'min_nights_not_met';
        }

        $subtotal = (int) collect($lines)->sum('price_cents');

        $promo = null;
        $discount = 0;
        if ($promoCode) {
            $promo = Promotion::query()->whereRaw('UPPER(code) = ?', [mb_strtoupper($promoCode)])->active()->first();
            if (! $promo) {
                $errors[] = 'promo_invalid';
            } elseif ($nights < $promo->min_nights) {
                $errors[] = 'promo_min_nights';
            } else {
                $discount = $this->applyPromo($subtotal, $promo);
            }
        }

        $cleaning = (int) SiteSetting::get('cleaning_fee_cents', 8000);
        $taxEnabled = (bool) SiteSetting::get('tourist_tax_enabled', true);
        $taxPerPersonNight = (int) SiteSetting::get('tourist_tax_per_person_per_night_cents', 150);
        $guests = $adults + $children;
        $tax = $taxEnabled ? $guests * $nights * $taxPerPersonNight : 0;

        $total = max(0, $subtotal - $discount + $cleaning + $tax);

        return [
            'nights' => $nights,
            'lines' => $lines,
            'subtotal_cents' => $subtotal,
            'discount_cents' => $discount,
            'cleaning_cents' => $cleaning,
            'tax_cents' => $tax,
            'total_cents' => $total,
            'promo' => $promo,
            'errors' => array_values(array_unique($errors)),
        ];
    }

    private function applyPromo(int $subtotalCents, Promotion $promo): int
    {
        if ($promo->discount_type === 'percent') {
            return (int) floor($subtotalCents * min(100, $promo->discount_value) / 100);
        }

        return min($subtotalCents, (int) $promo->discount_value);
    }

    private function emptyResult(array $errors): array
    {
        return [
            'nights' => 0,
            'lines' => [],
            'subtotal_cents' => 0,
            'discount_cents' => 0,
            'cleaning_cents' => 0,
            'tax_cents' => 0,
            'total_cents' => 0,
            'promo' => null,
            'errors' => $errors,
        ];
    }

    public function formatMoney(int $cents, string $locale = 'it'): string
    {
        $amount = $cents / 100;

        return number_format($amount, 2, ',', ' ').' €';
    }
}
