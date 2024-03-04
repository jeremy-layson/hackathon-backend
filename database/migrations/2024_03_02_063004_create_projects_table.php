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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('status');
            $table->string('url');
            $table->string('company_slug');
            $table->string('project');
            $table->string('project_type');
            $table->text('key_notes');
            $table->text('description');
            $table->text('short_description');
            $table->string('date_started');
            $table->string('date_completed');
            $table->string('country');
            $table->string('location');
            $table->string('industry');
            $table->string('sub_industry');
            $table->text('tech_stack');
            $table->text('problem_statement');
            $table->text('solution_summary');
            $table->text('feedback');
            $table->text('team_info');
            $table->text('blurb');
            $table->json('raw_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
