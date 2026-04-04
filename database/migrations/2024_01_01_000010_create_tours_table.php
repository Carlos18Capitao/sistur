<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description');
            $table->string('city');
            $table->string('province');
            $table->string('location')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('duration_days');
            $table->integer('max_participants');
            $table->integer('available_spots');
            $table->enum('category', ['aventura', 'cultural', 'natureza', 'gastronomia', 'praia', 'safari', 'historico'])->default('cultural');
            $table->enum('difficulty', ['facil', 'moderado', 'dificil'])->default('facil');
            $table->string('cover_image')->nullable();
            $table->json('images')->nullable();
            $table->json('includes')->nullable();
            $table->json('excludes')->nullable();
            $table->json('highlights')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->date('available_from')->nullable();
            $table->date('available_until')->nullable();
            $table->decimal('rating_average', 3, 2)->default(0.00);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
