<?php

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('trans_')) {
    function trans_($attr)
    {
        $translation = __($attr);
        if ($translation == $attr) {
            $translation = (string) str(last(explode('.', $attr)))->replace(['_', '-'], ' ')->ucfirst();
            $translation = __($translation);
        }
        return $translation;
    }
}

if (!function_exists('translation_json')) {
    function translation_json()
    {
        $data = [
            'validation' => __('validation'),
            'js_messages' => __('js_messages'),
        ];
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('app_json_data')) {
    function app_json_data()
    {
        $data = [
            "APP_URL" =>  URL('/'),
            "STORAGE_URL" => storage_url('/'),
            "CSRF_TOKEN" => csrf_token(),
            "LANG" => app()->getLocale(),
            "PAGE_URL" => request()->url(),
            "FULL_PAGE_URL" => request()->fullUrl(),
            "IS_RTL" => (config('app.direction') == "rtl") ? true : false,
            "userId" => auth()->check() ? auth()->id() : NULL,
            "PUSHER_APP_KEY" => config('broadcasting.connections.pusher.key'),
            "PUSHER_HOST" => env('PUSHER_HOST'),
            "PUSHER_APP_CLUSTER" => config('broadcasting.connections.pusher.options.cluster'),
            "PUSHER_PORT" => config('broadcasting.connections.pusher.options.port'),
            "PUSHER_SCHEME" => config('broadcasting.connections.pusher.options.scheme'),
        ];
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('date_formated')) {
    function date_formated($date, string $format = NULL)
    {
        $format = $format ?: config('app.date_format');
        if ($date instanceof Carbon) return $date->translatedFormat($format);
        else return Carbon::parse($date)->translatedFormat($format);
    }
}

if (!function_exists('slugme')) {
    function slugme($string, $separator = '-')
    {
        return Str::slug($string, '-', Null);
    }
}

if (!function_exists('storage_url')) {
    function storage_url($path)
    {
        return Storage::disk('public')->url($path);
    }
}


if (!function_exists('countries_list')) {
    function countries_list($get_location_data = false, $get_nationalities = false)
    {
        $location_data = NULL;
        $countries = collect(countries());
        $countries = $countries->sortBy('name');

        if ($get_location_data) {
            $location_data = visitor_location();
        }

        $nationalities = [];
        if ($get_nationalities) {
            foreach ($countries as $countryCode => $country) {
                $country = country($countryCode);
                $nationality_ = __($country->getDemonym());
                if ($nationality_ && $nationality_ != $country->getDemonym()) {
                    $nationalities[$countryCode] = ['code' => $countryCode, 'demonym' => $nationality_];
                }
            }
            $nationalities = collect($nationalities)->sortBy('demonym')->pluck('demonym', 'code');
        }

        $data = [
            'countries' => $countries,
            'nationalities' => $nationalities,
            'location_data' => $location_data,
        ];
        view()->share($data);

        return $countries;
    }
}


if (!function_exists('visitor_location')) {
    function visitor_location()
    {
        $ip = request()->ip();
        try {
            $location_data = Http::get('http://ip-api.com/json/' . $ip)->object();
            if ($location_data?->status == "fail") {
                $location_data = Http::get('http://ip-api.com/json/')->object();
            }
        } catch (\Exception $e) {
            $location_data = (object)[
                "country" => NULL,
                "countryCode" => NULL,
                "region" => NULL,
                "regionName" => NULL,
                "city" => NULL,
                "zip" => NULL,
                "lat" => '',
                "lon" => '',
                "timezone" => NULL,
                "isp" => NULL,
                "org" => NULL,
                "as" => NULL,
                "query" => NULL
            ];
        }
        return $location_data;
    }
}

if (!function_exists('price_format')) {
    function price_format($price, $multiplied_by_hundred = true)
    {
        return number_format($price / 100, 2, '.');
    }
}

if (!function_exists('cleanHtml')) {
    function cleanHtml($body)
    {
        $body = strip_tags($body, config('app.allowed_html_tags'));
        //$cleanBody = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/si",'<$1$2>', $body);
        $dom = new DOMDocument;                 // init new DOMDocument
        $dom->loadHTML(mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8')); // load the HTML
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('//@*');
        foreach ($nodes as $node) {
            if(!in_array($node->nodeName, ['style', 'href', 'target'])){
                $node->parentNode->removeAttribute($node->nodeName);
            }
        }

        return $dom->saveHTML();
    }
}

if (!function_exists('footer_pages')) {
    function footer_pages()
    {
        return Cache::rememberForever('footer_pages', function () {
            return Page::active()->get();
        });
    }
}
