<?php

namespace App\Livewire\Admin;

use App\Models\SiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SiteSettingsPanel extends Component
{
    public string $default_night_price_eur = '';

    public string $cleaning_fee_eur = '';

    public string $tourist_tax_per_person_night_eur = '';

    public bool $tourist_tax_enabled = true;

    public int $global_min_nights = 2;

    public int $max_guests_adults = 4;

    public int $max_guests_children = 2;

    public int $booking_horizon_days = 540;

    public int $min_booking_lead_days = 1;

    public string $whatsapp_e164 = '';

    public string $email_contact = '';

    public string $phone_display = '';

    public string $maps_embed_url = '';

    public string $address_display = '';

    public string $booking_ical_url = '';

    public string $airbnb_ical_url = '';

    public function mount(): void
    {
        $this->default_night_price_eur = (string) ((int) SiteSetting::get('default_night_price_cents', 16500) / 100);
        $this->cleaning_fee_eur = (string) ((int) SiteSetting::get('cleaning_fee_cents', 8500) / 100);
        $this->tourist_tax_per_person_night_eur = (string) ((int) SiteSetting::get('tourist_tax_per_person_per_night_cents', 150) / 100);
        $this->tourist_tax_enabled = (bool) SiteSetting::get('tourist_tax_enabled', true);
        $this->global_min_nights = (int) SiteSetting::get('global_min_nights', 2);
        $this->max_guests_adults = (int) SiteSetting::get('max_guests_adults', 4);
        $this->max_guests_children = (int) SiteSetting::get('max_guests_children', 2);
        $this->booking_horizon_days = (int) SiteSetting::get('booking_horizon_days', 540);
        $this->min_booking_lead_days = (int) SiteSetting::get('min_booking_lead_days', 1);
        $this->whatsapp_e164 = (string) SiteSetting::get('whatsapp_e164', '');
        $this->email_contact = (string) SiteSetting::get('email_contact', '');
        $this->phone_display = (string) SiteSetting::get('phone_display', '');
        $this->maps_embed_url = (string) SiteSetting::get('maps_embed_url', '');
        $this->address_display = (string) SiteSetting::get('address_display', 'Via Giovanni Gentile 1, 07026 Olbia (SS), Sardegna');
        $this->booking_ical_url = (string) SiteSetting::get('booking_ical_url', '');
        $this->airbnb_ical_url = (string) SiteSetting::get('airbnb_ical_url', '');
    }

    public function save(): void
    {
        SiteSetting::set('default_night_price_cents', (int) round(((float) str_replace(',', '.', $this->default_night_price_eur)) * 100));
        SiteSetting::set('cleaning_fee_cents', (int) round(((float) str_replace(',', '.', $this->cleaning_fee_eur)) * 100));
        SiteSetting::set('tourist_tax_per_person_per_night_cents', (int) round(((float) str_replace(',', '.', $this->tourist_tax_per_person_night_eur)) * 100));
        SiteSetting::set('tourist_tax_enabled', $this->tourist_tax_enabled);
        SiteSetting::set('global_min_nights', $this->global_min_nights);
        SiteSetting::set('max_guests_adults', $this->max_guests_adults);
        SiteSetting::set('max_guests_children', $this->max_guests_children);
        SiteSetting::set('booking_horizon_days', $this->booking_horizon_days);
        SiteSetting::set('min_booking_lead_days', $this->min_booking_lead_days);
        SiteSetting::set('whatsapp_e164', trim($this->whatsapp_e164));
        SiteSetting::set('email_contact', trim($this->email_contact));
        SiteSetting::set('phone_display', trim($this->phone_display));
        SiteSetting::set('maps_embed_url', trim($this->maps_embed_url));
        SiteSetting::set('address_display', trim($this->address_display));
        SiteSetting::set('booking_ical_url', trim($this->booking_ical_url));
        SiteSetting::set('airbnb_ical_url', trim($this->airbnb_ical_url));

        session()->flash('flash_ok', 'Impostazioni salvate.');
    }

    public function runIcalImport(): void
    {
        \Artisan::call('ical:import');
        $output = trim(\Artisan::output());
        session()->flash('ical_result', $output ?: 'Sincronizzazione completata.');
    }

    public function render()
    {
        return view('livewire.admin.site-settings-panel');
    }
}
