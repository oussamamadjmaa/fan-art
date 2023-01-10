<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_artworks_orders', function (Blueprint $table) {
            $table->id();
            $table->string('facility_name')->nullable();
            $table->string('city');
            $table->string('responsible_person');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('quantity');
            $table->string('sizes');
            $table->longText('idea')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_artworks_orders');
    }
};
