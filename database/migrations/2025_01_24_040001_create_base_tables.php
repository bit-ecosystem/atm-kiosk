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
        Schema::create('user_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type_name', ['Guest', 'Customer', 'Candidate', 'Supplier', 'Vendor Contractor', 'Employee', 'Admin'])->default(value: 'Guest');
            $table->string('description')->nullable();
            $table->enum('tag', ['New Joiner', 'Visitor', 'Candidate', 'SuperUser'])->nullable()->default(null);
            $table->enum('home', ['about', 'staff', 'admin', 'gate'])->nullable()->default('about');
            $table->timestamps();
        });
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('divisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('department');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Service Catalog cluster
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('system');
            $table->string('domain')->nullable();
            $table->timestamps();
        });
        Schema::create('service_catalogs', function (Blueprint $table) {
            $table->id();
            $table->enum('category', array_column(App\Enums\PageCategoryEnum::cases(), 'value')); // ->default(StatusEnum::Active->value);
            //   $table->string('url');
            $table->json('title');
            $table->json('description');
            $table->foreignId('domain_id')->nullable()->constrained('domains')->onDelete('cascade');
            $table->string('path')->nullable();
            $table->string('param')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('service_catalogs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
        Schema::dropIfExists('service_catalogs');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('divisions');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('user_types');
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('groups');
    }
};
