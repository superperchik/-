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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('fio')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->foreignId('id_childdata')->constrained('apartaments')->onUpdate('cascade')->onDelete('cascade');

            $table->date('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //$table->index('id_childdata')->unsigned();
        //            $table->foreign('id_childdata')->references('id')->on('apartaments');
    }
};
