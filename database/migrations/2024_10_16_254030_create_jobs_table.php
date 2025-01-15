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
        Schema::create('jobs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('enterprise_id')->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->foreignUuid('employer_id')->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId('domain_id')->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->text('poste');
            $table->text('type');
            $table->integer('salary');
            $table->text('missions');
            $table->integer('experience');
            $table->string('country');
            $table->integer('effective');
            $table->string('formation');
            $table->date('expired_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
