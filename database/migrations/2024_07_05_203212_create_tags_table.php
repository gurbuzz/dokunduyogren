<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id('tag_id'); // 'id' yerine 'tag_id' kullanılıyor
            $table->foreignId('page_id')->constrained('pages', 'page_id')->onDelete('cascade');
            $table->string('label')->nullable(); // Boş olabilir olarak ayarladık
            $table->float('position_x');
            $table->float('position_y');
            $table->float('width'); // Genişlik alanı
            $table->float('height'); // Yükseklik alanı
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
