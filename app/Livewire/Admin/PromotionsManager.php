<?php

namespace App\Livewire\Admin;

use App\Models\Promotion;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class PromotionsManager extends Component
{
    use WithPagination;

    public string $code = '';

    public string $name = '';

    public string $discount_type = 'percent';

    public string $discount_input = '10';

    public ?string $valid_from = null;

    public ?string $valid_to = null;

    public int $min_nights = 1;

    public bool $active = true;

    public bool $stackable = false;

    public string $description = '';

    public ?int $editingId = null;

    protected function rules(): array
    {
        return [
            'code' => [
                'required', 'string', 'max:32', 'regex:/^[A-Za-z0-9_-]+$/',
                Rule::unique('promotions', 'code')->ignore($this->editingId),
            ],
            'name' => 'required|string|max:120',
            'discount_type' => 'required|in:percent,fixed',
            'discount_input' => 'required|string',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'min_nights' => 'required|integer|min:1|max:60',
            'active' => 'boolean',
            'stackable' => 'boolean',
            'description' => 'nullable|string|max:2000',
        ];
    }

    public function edit(int $id): void
    {
        $p = Promotion::query()->findOrFail($id);
        $this->editingId = $p->id;
        $this->code = $p->code;
        $this->name = $p->name;
        $this->discount_type = $p->discount_type === 'fixed' ? 'fixed' : 'percent';
        if ($this->discount_type === 'percent') {
            $this->discount_input = (string) $p->discount_value;
        } else {
            $this->discount_input = (string) ($p->discount_value / 100);
        }
        $this->valid_from = $p->valid_from?->toDateString();
        $this->valid_to = $p->valid_to?->toDateString();
        $this->min_nights = (int) $p->min_nights;
        $this->active = $p->active;
        $this->stackable = $p->stackable;
        $this->description = (string) ($p->description ?? '');
    }

    public function resetForm(): void
    {
        $this->reset(['code', 'name', 'discount_type', 'discount_input', 'valid_from', 'valid_to', 'description', 'editingId']);
        $this->discount_type = 'percent';
        $this->discount_input = '10';
        $this->min_nights = 1;
        $this->active = true;
        $this->stackable = false;
    }

    public function save(): void
    {
        $this->code = strtoupper(trim($this->code));
        $this->validate();

        $discountValue = 0;
        if ($this->discount_type === 'percent') {
            $p = (float) str_replace(',', '.', $this->discount_input);
            if ($p < 1 || $p > 100) {
                $this->addError('discount_input', 'La percentuale deve essere tra 1 e 100.');

                return;
            }
            $discountValue = (int) round($p);
        } else {
            $eur = (float) str_replace(',', '.', $this->discount_input);
            if ($eur <= 0) {
                $this->addError('discount_input', 'Importo fisso non valido.');

                return;
            }
            $discountValue = (int) round($eur * 100);
        }

        $payload = [
            'code' => $this->code,
            'name' => $this->name,
            'discount_type' => $this->discount_type === 'fixed' ? 'fixed' : 'percent',
            'discount_value' => $discountValue,
            'valid_from' => $this->valid_from ?: null,
            'valid_to' => $this->valid_to ?: null,
            'min_nights' => $this->min_nights,
            'active' => $this->active,
            'stackable' => $this->stackable,
            'description' => $this->description ?: null,
        ];

        if ($this->editingId) {
            Promotion::query()->whereKey($this->editingId)->update($payload);
            session()->flash('flash_ok', 'Offerta aggiornata.');
        } else {
            Promotion::query()->create($payload);
            session()->flash('flash_ok', 'Offerta creata.');
        }

        $this->resetForm();
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Promotion::query()->whereKey($id)->delete();
        session()->flash('flash_ok', 'Offerta eliminata.');
        if ($this->editingId === $id) {
            $this->resetForm();
        }
    }

    public function render()
    {
        return view('livewire.admin.promotions-manager', [
            'promotions' => Promotion::query()->orderByDesc('id')->paginate(10),
        ]);
    }
}
