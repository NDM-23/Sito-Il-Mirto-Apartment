<?php

namespace App\Http\Controllers;

use App\Models\PageVisibility;
use Illuminate\Http\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [
            '',
            'appartamento',
            'galleria',
            'servizi',
            'promozioni',
            'esperienze',
            'dove-siamo',
            'contatti',
            'newsletter',
            'preventivo',
            'disponibilita',
            'privacy',
            'cookie-policy',
            'termini-prenotazione',
            'faq',
        ];

        if (PageVisibility::isVisible('reviews')) {
            $urls[] = 'recensioni';
        }
        if (PageVisibility::isVisible('blog')) {
            $urls[] = 'blog';
        }

        $locales = array_keys(LaravelLocalization::getSupportedLocales());
        $defaultLocale = config('app.locale');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        foreach ($urls as $path) {
            $suffix = $path === '' ? '/' : '/'.$path;
            $primary = LaravelLocalization::getLocalizedURL($defaultLocale, $suffix, [], true);
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.htmlspecialchars($primary, ENT_XML1).'</loc>'."\n";
            $xml .= '    <changefreq>weekly</changefreq>'."\n";
            $xml .= '    <priority>'.($path === '' ? '1.0' : '0.8').'</priority>'."\n";
            foreach ($locales as $alt) {
                $href = LaravelLocalization::getLocalizedURL($alt, $suffix, [], true);
                $xml .= '    <xhtml:link rel="alternate" hreflang="'.$alt.'" href="'.htmlspecialchars($href, ENT_XML1).'" />'."\n";
            }
            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
