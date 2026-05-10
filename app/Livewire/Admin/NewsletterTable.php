<?php

namespace App\Livewire\Admin;

use App\Models\NewsletterSubscriber;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class NewsletterTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.newsletter-table', [
            'rows' => NewsletterSubscriber::query()->orderByDesc('id')->paginate(30),
        ]);
    }
}
