<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UpdateController extends Controller
{
    public function update($v){
        set_time_limit(0);

        $updated = false;
        if($v == "1.0.0"){
            if(($msg = $this->migrateAndOptimize()) == true){
                $updated = true;
            }else{
                echo $msg;
            }
        }

        if($updated == true){
            echo "<br> Redirecting in 3 seconds ...";
        }
        $redirectTo = route('backend.dashboard');

       return "<script>setTimeout(function(){ window.location.href = '{$redirectTo}'; }, 3000);</script>";
    }

    private function dropColumn($table, $column){
        if (Schema::hasColumn($table, $column))
        {
            Schema::table($table, function (Blueprint $table) use($column)
            {
                $table->dropColumn($column);
                echo "Column ${column} dropped successfully. <br>";
            });
        }
    }

    private function migrateAndOptimize(){
        try {
            Artisan::call('migrate');
            echo nl2br(Artisan::output());

            Artisan::call('optimize:clear');
            echo nl2br(Artisan::output());
        } catch (\Exception $e) {
            return $e;
        }

        return true;
    }
}