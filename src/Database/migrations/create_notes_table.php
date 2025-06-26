<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->string('visibility');
            $table->integer('book_id');
            $table->integer('start_chapter');
            $table->integer('end_chapter')->nullable();
            $table->integer('start_verse');
            $table->integer('end_verse')->nullable();
            $table->text('note')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('notes');
    }
};
