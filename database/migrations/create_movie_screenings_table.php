<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Movie, Room};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movie_screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Movie::class);
            $table->foreignIdFor(Room::class);
            $table->dateTime('start');
            $table->integer('free_positions');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('movie_screenings');
    }
};