<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('books', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('book');
            $table->string('abbreviation');
            $table->integer('chapters');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
