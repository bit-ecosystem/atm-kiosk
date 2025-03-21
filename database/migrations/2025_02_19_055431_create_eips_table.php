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
        Schema::create('eips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('empno');
            $table->string('name');
            $table->string('department');
            $table->string('ext');
            $table->string('date');
            $table->string('process');
            $table->string('others');
            $table->string('eiptype');
            $table->string('eipcategory');
            $table->string('location');
            $table->string('specificlocation');
            $table->string('current');
            $table->string('currentattachment');
            $table->string('webpath');
            $table->string('filesize');
            $table->string('proposal');
            $table->string('proposalattachment');
            $table->string('webpath1');
            $table->string('filesize1');
            $table->timestamp('createtime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eips');
    }
};
