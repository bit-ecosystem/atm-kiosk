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
        Schema::create('bom_pcf_tiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('level');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('bom_pcfs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('definition');
            $table->string('hierarchy_code');
            $table->foreignId('pcf_tier_id')->constrained('pcf_tiers')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('bom_pcf_exts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('apqc');
            $table->string('shortcode');
            $table->foreignId('pcf_id')->constrained('pcfs')->onDelete('cascade');
            $table->foreignId('accountable')->nullable()->constrained('org_job_positions')->onDelete('cascade');
            $table->foreignId('responsible')->nullable()->constrained('org_job_roles')->onDelete('cascade');
            $table->timestamps();
        });
        // Process Cluster
        Schema::create('bom_processes', function (Blueprint $table) {
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

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('bom_processes');
        Schema::dropIfExists('bom_pcf_ext');
        Schema::dropIfExists('bom_pcf');
        Schema::dropIfExists('bom_pcf_tier');
    }
};
