<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['sedan', 'hatchback'])->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('location')->nullable();
            $table->double('latitude')->default(0.00)->nullable();
            $table->double('longitude')->default(0.00)->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->integer('added_by')->unsigned()->nullable();
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
        Schema::dropIfExists('cars');
    }
}
