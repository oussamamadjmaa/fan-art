<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Mail;

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
        }else if($v == "1.0.01"){
            foreach (['description', 'materials_used', 'tools', 'covered_with_glass'] as $column) {
                $this->dropColumn('artworks', $column);
            }
            if(($msg = $this->migrateAndOptimize()) == true){
                $updated = true;
            }else{
                echo $msg;
            }
        }else if($v == "1.0.1"){
            if(!Schema::hasTable('jobs')) {
                Artisan::call('queue:table');
                echo nl2br(Artisan::output());
            }

            if(($msg = $this->migrateAndOptimize()) == true){
                $updated = true;
            }else{
                echo $msg;
            }

            $artists = User::role('artist')->whereNull('artist_type')->get(['id']);
            User::whereIn('id', $artists->pluck('id')->toArray())->update(['artist_type' => 'artist']);
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

    public function testEmail() {
        dd(Mail::raw('Test', function ($message) {
            $message->to('oussama@madjmaa.com');
         }));
    }
}
