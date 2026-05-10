<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        Schema::create('page_visibilities', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->boolean('is_visible')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('calendar_days', function (Blueprint $table) {
            $table->id();
            $table->date('day')->unique();
            $table->unsignedInteger('price_cents')->nullable();
            $table->unsignedTinyInteger('min_nights')->nullable();
            $table->boolean('is_booked')->default(false);
            $table->boolean('is_blocked')->default(false);
            $table->string('promo_label')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('discount_type');
            $table->unsignedInteger('discount_value');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->unsignedTinyInteger('min_nights')->default(1);
            $table->boolean('active')->default(true);
            $table->boolean('stackable')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('locale', 8)->default('it');
            $table->string('confirmation_token')->nullable()->index();
            $table->timestamp('confirmed_at')->nullable();
            $table->boolean('marketing_consent')->default(false);
            $table->timestamp('privacy_accepted_at')->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('brevo_contact_id')->nullable();
            $table->timestamps();
        });

        Schema::create('consent_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('action');
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });

        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedTinyInteger('adults')->default(2);
            $table->unsignedTinyInteger('children')->default(0);
            $table->json('extras')->nullable();
            $table->string('promo_code')->nullable();
            $table->json('calculation')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            $table->string('locale', 8)->default('it');
            $table->string('status')->default('new');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->json('alt')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_hero')->default(false);
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author_name');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('body');
            $table->string('locale', 8)->default('it');
            $table->boolean('is_published')->default(false);
            $table->string('source')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('slug')->unique();
            $table->json('excerpt')->nullable();
            $table->json('body')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('site_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('day')->unique();
            $table->unsignedInteger('page_views')->default(0);
            $table->unsignedInteger('quote_views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_statistics');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('quote_requests');
        Schema::dropIfExists('consent_logs');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('calendar_days');
        Schema::dropIfExists('page_visibilities');
        Schema::dropIfExists('site_settings');
    }
};
