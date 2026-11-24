<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('type'); // anime, drama, manga, light_novel
            $table->string('genre');
            $table->unsignedSmallInteger('year');
            $table->string('creator')->nullable(); // studio atau penulis
            $table->unsignedInteger('episodes')->nullable(); // jumlah episode / chapter / volume
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
