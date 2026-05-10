<?php

namespace App\Livewire\Public;

use App\Models\SiteSetting;
use Carbon\Carbon;
use Livewire\Component;

class PromoCountdown extends Component
{
    public function render()
    {
        $end = SiteSetting::get('promo_countdown_end');
        $target = $end ? Carbon::parse($end) : now()->addDays(7);

        return view('livewire.public.promo-countdown', [
            'until' => $target,
        ]);
    }
}
