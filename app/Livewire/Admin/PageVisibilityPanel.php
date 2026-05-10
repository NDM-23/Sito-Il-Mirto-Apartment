<?php

namespace App\Livewire\Admin;

use App\Models\PageVisibility;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PageVisibilityPanel extends Component
{
    /** @var array<string,bool> */
    public array $pages = [];

    public function mount(): void
    {
        $this->pages = PageVisibility::query()->pluck('is_visible', 'slug')->all();
        if (! isset($this->pages['reviews'])) {
            $this->pages['reviews'] = true;
        }
        if (! isset($this->pages['blog'])) {
            $this->pages['blog'] = false;
        }
    }

    public function save(): void
    {
        foreach ($this->pages as $slug => $vis) {
            PageVisibility::query()->updateOrCreate(
                ['slug' => $slug],
                ['is_visible' => (bool) $vis, 'sort_order' => 0]
            );
        }
        session()->flash('flash_ok', 'Visibilità pagine aggiornata.');
    }

    public function render()
    {
        return view('livewire.admin.page-visibility-panel');
    }
}
