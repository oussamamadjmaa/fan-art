<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

if(!function_exists('trans_')){
    function trans_($attr){
        $translation = __($attr);
        if($translation == $attr){
            $translation = (string) str(last(explode('.', $attr)))->replace(['_', '-'], ' ')->ucfirst();
            $translation = __($translation);
        }
        return $translation;
    }
}

if(!function_exists('translation_json')){
    function translation_json(){
        $data = [
            'validation' => __('validation'),
            'js_messages' => __('js_messages'),
        ];
        return json_encode($data , JSON_UNESCAPED_UNICODE);
    }
}

if(!function_exists('app_json_data')){
    function app_json_data(){
        $data = [
            "APP_URL" =>  URL('/'),
            "CSRF_TOKEN"=> csrf_token(),
            "LANG" => app()->getLocale(),
            "PAGE_URL" => request()->url(),
            "FULL_PAGE_URL" => request()->fullUrl(),
            "IS_RTL" => (config('app.direction') == "rtl") ? true : false,
            "PUSHER_APP_KEY" => env('broadcasting.connections.pusher.key'),
            "PUSHER_APP_CLUSTER" => env('PUSHER_APP_CLUSTER')
        ];
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

if(!function_exists('date_formated')){
    function date_formated($date, string $format = NULL){
        $format = $format ?: config('app.date_format');
        if($date instanceof Carbon) return $date->translatedFormat($format);
        else Carbon::parse($date)->translatedFormat($format);
    }
}

if(!function_exists('slugme')){
    function slugme($string = null, $separator = "-") {
        if (is_null($string)) {
            return "";
        }
        $string = trim($string);
        $string = mb_strtolower($string, "UTF-8");
        // '/' and/or '\' if found and not remoeved it will change the get request route
        $string = str_replace('/', $separator, $string);
        $string = str_replace('\\', $separator, $string);
        $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "",
        $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", $separator, $string);
        return $string;

        return $string;
    }
}

if(!function_exists('storage_url')){
    function storage_url($path){
        return Storage::disk('public')->url($path);
    }
}


if(!function_exists('countries_list')){
    function countries_list($get_location_data = false, $get_nationalities = false){
        $location_data = NULL;
        $countries = collect(countries());
        $countries = $countries->sortBy('name');

        if($get_location_data){
            $location_data = visitor_location();
        }

        if($get_nationalities){
            $nationalities = [];
            foreach ($countries as $countryCode => $country) {
                $country = country($countryCode);
                $nationality_ = __($country->getDemonym());
                if($nationality_ && $nationality_ != $country->getDemonym()){
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


if(!function_exists('visitor_location')){
    function visitor_location(){
        $ip = request()->ip();
        try {
            $location_data = Http::get('http://ip-api.com/json/'.$ip)->object();
            if($location_data?->status == "fail" ){
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

if(!function_exists('price_format')){
    function price_format($price, $multiplied_by_hundred = true){
        return number_format($price/100, 2, '.');
    }
}
