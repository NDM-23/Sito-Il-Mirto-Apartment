<?php

namespace App\Livewire\Public;

use App\Models\QuoteRequest;
use App\Models\SiteSetting;
use App\Services\BookingQuoteService;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;

class QuoteWizard extends Component
{
    public string $check_in = '';

    public string $check_out = '';

    #[Validate('required|integer|min:1|max:20')]
    public int $adults = 2;

    #[Validate('required|integer|min:0|max:10')]
    public int $children = 0;

    public string $promo_code = '';

    public bool $linen = false;

    public bool $show_result = false;

    /** @var array<string,mixed> */
    public array $result = [];

    public function mount(): void
    {
        $lead = (int) SiteSetting::get('min_booking_lead_days', 1);
        $this->check_in = now()->addDays($lead)->toDateString();
        $this->check_out = now()->addDays($lead + 3)->toDateString();
    }

    protected function rules(): array
    {
        return [
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1', 'max:20'],
            'children' => ['required', 'integer', 'min:0', 'max:10'],
        ];
    }

    public function calculate(BookingQuoteService $svc): void
    {
        $this->validate();
        $this->resetErrorBag();

        $in = Carbon::parse($this->check_in)->startOfDay();
        $out = Carbon::parse($this->check_out)->startOfDay();

        $extras = [
            'linen' => $this->linen,
        ];

        $quote = $svc->quote($in, $out, $this->adults, $this->children, $this->promo_code ?: null);

        if ($this->linen) {
            $linenCents = (int) SiteSetting::get('extra_linen_cents', 2500);
            $quote['subtotal_cents'] += $linenCents;
            $quote['total_cents'] += $linenCents;
            $quote['extras_line_cents'] = $linenCents;
        }

        $this->result = $quote;
        $this->show_result = true;

        QuoteRequest::query()->create([
            'check_in' => $in->toDateString(),
            'check_out' => $out->toDateString(),
            'adults' => $this->adults,
            'children' => $this->children,
            'extras' => $extras,
            'promo_code' => $this->promo_code ?: null,
            'calculation' => $quote,
            'locale' => app()->getLocale(),
            'status' => 'calculated',
        ]);
    }

    public function render()
    {
        return view('livewire.public.quote-wizard');
    }
}
