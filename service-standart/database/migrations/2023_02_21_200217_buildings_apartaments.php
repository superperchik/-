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
        Schema::create('buildingsApartaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_building')->constrained('buildings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_apartment')->constrained('apartaments')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
