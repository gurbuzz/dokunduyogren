<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // 'id' sütunu varsayılan olarak oluşturulur
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('author')->nullable();
            $table->date('published_date')->nullable();
            $table->string('isbn')->nullable();
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
};
