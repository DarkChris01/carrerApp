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
        Schema::create('entretiens', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignId("candidacy_id")->constrained("candidacies");
            $table->foreignUuid("job_id")->constrained("jobs");
            $table->unique(["candidacy_id", "job_id"], "unique_candidacy_job");
            $table->date("date");
            $table->time("time");
            $table->string("lieu");
            $table->string("status")->default("pending");     //pending, accepted or rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entretiens');
    }
};
