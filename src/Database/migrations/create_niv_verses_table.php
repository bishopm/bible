<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('niv_verses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('book_id');
            $table->integer('chapter')->nullable();
            $table->integer('verse')->nullable();
            $table->text('words')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('niv_verses');
    }
};
