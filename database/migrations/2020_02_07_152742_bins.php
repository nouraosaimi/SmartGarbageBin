<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bins extends Migrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('Bins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('BinName');
            $table->string('Locaton');
            $table->string('BinID');
            $table->Integer('BinStatus');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('Bins');
    }
}
