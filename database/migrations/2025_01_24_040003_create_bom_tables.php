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
        // Process Classification Framework
        Schema::create('pcf_tiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('level');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('pcfs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('definition');
            $table->string('hierarchy_code');
            $table->foreignId('pcf_tier_id')->constrained('pcf_tiers')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('pcf_exts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('apqc');
            $table->string('shortcode');
            $table->foreignId('pcf_id')->constrained('pcfs')->onDelete('cascade');
            $table->foreignId('accountable')->nullable()->constrained('org_job_positions')->onDelete('cascade');
            $table->foreignId('responsible')->nullable()->constrained('org_job_roles')->onDelete('cascade');
            $table->timestamps();
        });
        // Process Cluster
        Schema::create('processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('inputs');
            $table->text('outputs');
            $table->text('suppliers');
            $table->text('customers');
            $table->text('resources');
            $table->text('controls');
            $table->text('description');
            $table->foreignId('pcf_id')->constrained('pcfs')->onDelete('cascade');
            $table->timestamps();
        });
        // Task Cluster
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('type', ['project', 'request', 'BPM']);
            $table->string('description');
            $table->enum('status', ['Open', 'In Progress', 'On Hold', 'Completed'])->default('Open');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('processes');
        Schema::dropIfExists('pcf_ext');
        Schema::dropIfExists('pcf');
        Schema::dropIfExists('pcf_tier');
    }
};
