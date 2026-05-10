<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\PageVisibility;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MirtoPageController extends Controller
{
    public function home(): View
    {
        $promos = Promotion::query()->active()->orderBy('valid_to')->limit(3)->get();
        $gallery = GalleryImage::query()->where('is_active', true)->orderBy('sort_order')->limit(8)->get();
        $reviews = Review::query()->where('is_published', true)->orderBy('sort_order')->limit(6)->get();

        return view('site.home', compact('promos', 'gallery', 'reviews'));
    }

    public function apartment(): View
    {
        return view('site.apartment');
    }

    public function gallery(): View
    {
        $images = GalleryImage::query()->where('is_active', true)->orderBy('sort_order')->get();

        return view('site.gallery', compact('images'));
    }

    public function services(): View
    {
        return view('site.services');
    }

    public function promotions(): View
    {
        $promos = Promotion::query()->active()->orderByDesc('id')->get();

        return view('site.promotions', compact('promos'));
    }

    public function experiences(): View
    {
        return view('site.experiences');
    }

    public function location(): View
    {
        $mapUrl = SiteSetting::get('maps_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3020.0!2d9.5!3d40.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDU0JzAwLjAiTiA5wrAzMCcwMC4wIkU!5e0!3m2!1sit!2sit!4v1');

        return view('site.location', compact('mapUrl'));
    }

    public function reviews(): View
    {
        if (! PageVisibility::isVisible('reviews')) {
            abort(404);
        }
        $reviews = Review::query()->where('is_published', true)->orderBy('sort_order')->get();

        return view('site.reviews', compact('reviews'));
    }

    public function contacts(): View
    {
        return view('site.contacts');
    }

    public function newsletter(): View
    {
        return view('site.newsletter');
    }

    public function privacy(): View
    {
        return view('site.legal.privacy');
    }

    public function cookies(): View
    {
        return view('site.legal.cookies');
    }

    public function terms(): View
    {
        return view('site.legal.terms');
    }

    public function faq(): View
    {
        return view('site.faq');
    }

    public function preventivo(): View
    {
        return view('site.preventivo');
    }

    public function availability(): View
    {
        return view('site.availability');
    }

    public function blog(Request $request): View
    {
        if (! PageVisibility::isVisible('blog')) {
            abort(404);
        }

        return view('site.blog-stub');
    }
}
