<?php

namespace App\Livewire\Admin;

use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class GalleryManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $uploads = [];

    public string $uploadSectionKey = '';

    public string $activeSection = '__all__';

    /** @var int|null */
    public $replacingId = null;

    public $replacementFile = null;

    public function updatedActiveSection(): void
    {
        $this->resetPage();
    }

    public function saveUploads(): void
    {
        $this->validate([
            'uploads.*' => 'image|max:10240',
        ]);

        $sort = (int) GalleryImage::query()->max('sort_order') + 1;
        $section = $this->uploadSectionKey !== '' ? $this->uploadSectionKey : null;

        foreach ($this->uploads as $file) {
            $path = $file->store('gallery', 'public');
            $full = Storage::disk('public')->path($path);
            try {
                $webpPath = preg_replace('/\.\w+$/', '.webp', $path);
                $webpFull = Storage::disk('public')->path($webpPath);
                Image::read($full)->scaleDown(width: 1600)->toWebp(82)->save($webpFull);
                @unlink($full);
                $path = $webpPath;
            } catch (\Throwable) {
                // keep original if conversion fails
            }

            GalleryImage::query()->create([
                'path' => '/storage/'.$path,
                'section_key' => $section,
                'alt' => ['it' => 'Galleria Il Mirto', 'en' => 'Il Mirto gallery'],
                'sort_order' => $sort++,
                'is_active' => true,
                'is_hero' => false,
            ]);
        }

        $this->uploads = [];
        $this->uploadSectionKey = '';
        session()->flash('flash_ok', 'Immagini caricate.');
        $this->resetPage();
    }

    public function updateSection(int $id, string $value): void
    {
        $v = trim($value) === '' ? null : $value;
        GalleryImage::query()->whereKey($id)->update(['section_key' => $v]);
        session()->flash('flash_ok', 'Sezione aggiornata.');
    }

    public function startReplace(int $id): void
    {
        $this->replacingId = $id;
        $this->replacementFile = null;
    }

    public function cancelReplace(): void
    {
        $this->replacingId = null;
        $this->replacementFile = null;
    }

    public function saveReplacement(): void
    {
        $this->validate([
            'replacementFile' => 'required|image|max:10240',
        ]);

        $img = GalleryImage::query()->findOrFail($this->replacingId);
        $this->deleteStoredFile($img->path);

        $path = $this->replacementFile->store('gallery', 'public');
        $full = Storage::disk('public')->path($path);
        try {
            $webpPath = preg_replace('/\.\w+$/', '.webp', $path);
            $webpFull = Storage::disk('public')->path($webpPath);
            Image::read($full)->scaleDown(width: 1600)->toWebp(82)->save($webpFull);
            @unlink($full);
            $path = $webpPath;
        } catch (\Throwable) {
            // keep original
        }

        $img->update(['path' => '/storage/'.$path]);
        $this->cancelReplace();
        session()->flash('flash_ok', 'Immagine sostituita.');
    }

    public function toggle(int $id, string $field): void
    {
        $img = GalleryImage::query()->findOrFail($id);
        $img->update([$field => ! $img->{$field}]);
    }

    public function remove(int $id): void
    {
        $img = GalleryImage::query()->findOrFail($id);
        $this->deleteStoredFile($img->path);
        $img->delete();
        if ($this->replacingId === $id) {
            $this->cancelReplace();
        }
        session()->flash('flash_ok', 'Immagine rimossa.');
    }

    private function deleteStoredFile(?string $publicPath): void
    {
        if (! $publicPath || ! str_starts_with($publicPath, '/storage/')) {
            return;
        }
        $rel = GalleryImage::diskPathFromPublic($publicPath);
        if ($rel) {
            @unlink(Storage::disk('public')->path($rel));
        }
    }

    public function render()
    {
        $sections = config('mirto.gallery_sections', []);

        $query = GalleryImage::query()->orderBy('sort_order')->orderBy('id');

        if ($this->activeSection === '__none__') {
            $query->whereNull('section_key');
        } elseif ($this->activeSection !== '__all__') {
            $query->where('section_key', $this->activeSection);
        }

        $counts = [];
        $counts['__all__'] = GalleryImage::query()->count();
        $counts['__none__'] = GalleryImage::query()->whereNull('section_key')->count();
        foreach (array_keys($sections) as $key) {
            if ($key !== '') {
                $counts[$key] = GalleryImage::query()->where('section_key', $key)->count();
            }
        }

        return view('livewire.admin.gallery-manager', [
            'images' => $query->paginate(16),
            'sections' => $sections,
            'counts' => $counts,
        ]);
    }
}
