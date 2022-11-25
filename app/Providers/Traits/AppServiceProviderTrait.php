<?php

namespace App\Providers\Traits;

// use App\Models\Config;

use App\Models\SiteConfig;
use DateTime;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;

trait AppServiceProviderTrait{
    public function setConfig(){
        //Set configs
        $configs =  $db_config = [];
        $default_config = config('configs', []);

        try {
            if(Schema::hasTable('site_configs')){
                $db_config = Cache::rememberForever('db_config', function(){ return SiteConfig::get(['key', 'value'])->pluck('value', 'key')->toArray(); });
            }
        } catch (\Exception $e) {}

        $configs = array_merge($default_config, $db_config);

        foreach ($configs as $key => $value) {
            $existsing_configs = config($key);

            if(is_array($value) && is_array($existsing_configs)){
                $value = array_merge($existsing_configs, $value);

                // if($key == "app" && !Cookie::get('locale', false)){
                //     date_default_timezone_set($value['timezone']);
                // }
            }
           config()->set($key, $value);
        }

        if (in_array($locale = Cookie::get('locale', app()->getLocale()), ['ar', 'en'])) {
            app()->setLocale($locale);
        }
        config()->set('app.direction', app()->getLocale() == "ar" ? 'rtl' : 'ltr');
    }
}
