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
        Schema::create('prognoses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('free')->default(false);
            $table->text('analyse')->nullable();
            $table->decimal('total_odd')->nullable();
            $table->string('current_state')->nullable();
            $table->boolean('published')->default(true);
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
        Schema::dropIfExists('prognoses');
    }
};
