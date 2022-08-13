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
        Schema::create('exhibitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('sponsor_id')->references('id')->on('sponsors')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('name');
            $table->date('from_date');
            $table->date('to_date');
            $table->char('country', 2)->default('sa');
            $table->string('city')->nullable();
            $table->string('registration_url')->nullable();
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
        Schema::dropIfExists('exhibitions');
    }
};
