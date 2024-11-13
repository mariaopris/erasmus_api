<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('university_id')->nullable();
            $table->string('status');
            $table->float('selection_score')->default(0);
            $table->text('feedback_comments')->nullable();
            $table->integer('feedback_admin_id')->default(0);
            $table->string('academic_year');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('date_of_birth');
            $table->string('phone');
            $table->text('id_number');
            $table->text('faculty');
            $table->string('study_cycle');
            $table->string('current_study_year');
            $table->string('education_field');
            $table->float('gpa');
            $table->text('summary')->nullable();
            $table->string('mobility_program');
            $table->string('period_of_mobility')->nullable();
            $table->string('mobility_start_date')->nullable();
            $table->string('mobility_end_date')->nullable();
            $table->string('destination_type')->nullable();
            $table->string('destination_1')->nullable();
            $table->string('destination_2')->nullable();
            $table->string('destination_3')->nullable();
            $table->string('placement_country')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
