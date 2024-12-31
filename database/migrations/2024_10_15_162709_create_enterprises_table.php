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
        Schema::create('enterprises', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("employer_id")->constrained();
            $table->string("name")->unique();
            $table->string("company_name")->unique();
            $table->string("phone")->unique();
            $table->string("address")->unique();
            $table->string('country');
            $table->string('region');
            $table->string("type");
            $table->string("email")->unique();
            $table->string("facebook")->unique()->nullable();
            $table->string("linkedin")->unique()->nullable();
            $table->string("twitter")->unique()->nullable();
            $table->string("postal")->unique()->nullable();
            $table->string("site")->unique()->nullable();
            $table->string('logo')->unique()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprises');
    }
};
