<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id('tag_id'); 
            $table->foreignId('page_id')->constrained('pages', 'page_id')->onDelete('cascade');
            $table->string('label')->nullable(); 
            $table->float('position_x');
            $table->float('position_y');
            $table->float('width'); 
            $table->float('height'); 
            $table->string('translated_label')->nullable(); 
            $table->string('translated_language')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
