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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->integer('price');
            $table->string('image');
            //$table->text('materials_used')->nullable();
            //$table->text('tools')->nullable();
            $table->boolean('outer_frame')->default(0);
            $table->string('dimensions')->nullable();
            //$table->boolean('covered_with_glass')->default(0);
            $table->text('location')->nullable();
            //$table->longText('description')->nullable();
            $table->boolean('status')->default(1);
            $table->tinyText('url')->nullable();
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
        Schema::dropIfExists('artworks');
    }
};
