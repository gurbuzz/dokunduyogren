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
            $table->string('label');
            $table->float('position_x');
            $table->float('position_y');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
