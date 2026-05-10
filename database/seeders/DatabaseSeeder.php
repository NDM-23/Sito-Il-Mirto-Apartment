<?php

namespace Database\Seeders;

use App\Models\CalendarDay;
use App\Models\GalleryImage;
use App\Models\PageVisibility;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\SiteSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Role::query()->firstOrCreate(['name' => 'admin']);
        Role::query()->firstOrCreate(['name' => 'editor']);

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@ilmirtoapartment.it'],
            [
                'name' => 'Amministratore',
                'password' => Hash::make('MirtoAdmin!2026'),
            ]
        );
        $admin->assignRole('admin');

        $settings = [
            'default_night_price_cents' => 16500,
            'cleaning_fee_cents' => 8500,
            'tourist_tax_enabled' => true,
            'tourist_tax_per_person_per_night_cents' => 150,
            'global_min_nights' => 2,
            'max_guests_adults' => 4,
            'max_guests_children' => 2,
            'booking_horizon_days' => 540,
            'min_booking_lead_days' => 1,
            'extra_linen_cents' => 2500,
            'whatsapp_e164' => '393331234567',
            'email_contact' => 'info@ilmirtoapartment.it',
            'phone_display' => '+39 333 123 4567',
            'maps_embed_url' => 'https://www.google.com/maps?q=Via+Giovanni+Gentile+1+Olbia&output=embed',
            'exit_promo_percent' => 5,
            'promo_countdown_end' => now()->addDays(14)->toIso8601String(),
        ];

        foreach ($settings as $k => $v) {
            SiteSetting::set($k, $v);
        }

        foreach (['reviews' => true, 'blog' => false] as $slug => $vis) {
            PageVisibility::query()->updateOrInsert(
                ['slug' => $slug],
                ['is_visible' => $vis, 'sort_order' => 0, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        Promotion::query()->updateOrCreate(
            ['code' => 'EARLY2026'],
            [
                'name' => 'Early booking 2026',
                'discount_type' => 'percent',
                'discount_value' => 10,
                'valid_from' => now()->toDateString(),
                'valid_to' => now()->addMonths(6)->toDateString(),
                'min_nights' => 5,
                'active' => true,
                'stackable' => false,
                'description' => 'Prenota con anticipo',
            ]
        );

        Promotion::query()->updateOrCreate(
            ['code' => 'LASTMIN7'],
            [
                'name' => 'Last minute 7 giorni',
                'discount_type' => 'percent',
                'discount_value' => 12,
                'valid_from' => now()->toDateString(),
                'valid_to' => now()->addDays(21)->toDateString(),
                'min_nights' => 3,
                'active' => true,
                'stackable' => false,
                'description' => 'Partenza nei prossimi 21 giorni',
            ]
        );

        $sections = [
            'home.hero', 'home.pool', 'home.comfort', 'apartment.living', 'apartment.kitchen',
            'apartment.bedrooms', 'gallery.public', 'gallery.public', 'gallery.public', 'gallery.public',
            'location.map', 'promotions.header',
        ];
        for ($i = 0; $i < 12; $i++) {
            $path = 'https://picsum.photos/seed/mirto'.$i.'/1600/1000';
            GalleryImage::query()->create([
                'path' => $path,
                'section_key' => $sections[$i] ?? 'gallery.public',
                'alt' => [
                    'it' => 'Appartamento Il Mirto — foto '.($i + 1),
                    'en' => 'Il Mirto apartment — photo '.($i + 1),
                ],
                'sort_order' => $i,
                'is_active' => true,
                'is_hero' => $i === 0,
            ]);
        }

        $reviews = [
            ['author_name' => 'Marco & Elena', 'rating' => 5, 'body' => 'Arredamento curato, piscina comoda dopo le giornate in spiaggia. Olbia comoda per uscite verso Costa Smeralda.', 'locale' => 'it'],
            ['author_name' => 'Sophie', 'rating' => 5, 'body' => 'Calm, elegant and well placed for the airport and the north-east coast.', 'locale' => 'en'],
        ];
        foreach ($reviews as $r) {
            Review::query()->create([
                'author_name' => $r['author_name'],
                'rating' => $r['rating'],
                'body' => $r['body'],
                'locale' => $r['locale'],
                'is_published' => true,
                'source' => 'direct',
                'sort_order' => 0,
            ]);
        }

        $start = Carbon::today();
        for ($d = 0; $d < 120; $d++) {
            $day = $start->copy()->addDays($d);
            CalendarDay::query()->updateOrInsert(
                ['day' => $day->toDateString()],
                [
                    'price_cents' => $day->isWeekend() ? 18500 : 16500,
                    'min_nights' => $day->month === 8 ? 5 : 2,
                    'is_booked' => $d % 17 === 0,
                    'is_blocked' => false,
                    'promo_label' => null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
