<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use URL;

class InstallController extends Controller
{
    public function index(){
        abort_if(env('WEBSITE_INSTALLED', true) == true || config('app.debug', false) == false, 404);
        set_time_limit(0);
        try {
            Artisan::call('migrate:fresh --seed');
            echo Artisan::output() . " <br>";

            Artisan::call('optimize:clear');
            echo Artisan::output() . " <br>";

            Artisan::call('key:generate');
            echo Artisan::output() . " <br>";

            Cache::flush();
            echo "Cache Flushed Succuessfully <br>";

            echo "Redirecting in 3 seconds ...";
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $redirectTo = URL('/');
        return "<script>setTimeout(function(){ window.location.href = '{$redirectTo}'; }, 3000);</script>";
    }
}
