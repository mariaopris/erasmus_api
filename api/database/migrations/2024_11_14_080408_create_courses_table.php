<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('university_id');
            $table->integer('department_id');
            $table->integer('degree_id');
            $table->string('name');
            $table->string('language');
            $table->string('level');
            $table->string('year');
            $table->string('semester');
            $table->integer('no_credits')->default(0);
            $table->text('description');
            $table->string('tags')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
