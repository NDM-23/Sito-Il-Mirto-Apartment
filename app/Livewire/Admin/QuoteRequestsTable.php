<?php

namespace App\Livewire\Admin;

use App\Models\QuoteRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class QuoteRequestsTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.quote-requests-table', [
            'rows' => QuoteRequest::query()->orderByDesc('id')->paginate(20),
        ]);
    }
}
