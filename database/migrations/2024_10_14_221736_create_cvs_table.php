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
        Schema::create('cvs', function (Blueprint $table) {

            // information
            $table->uuid("id")->primary();
            $table->foreignUuid("user_id")->constrained("users", "id")->onDelete("cascade")->onUpdate("cascade");
            $table->string("firstName");
            $table->string("lastName");
            $table->date("birth_date");
            $table->string("phone");
            $table->string("email");
            $table->string("country");
            $table->string("sexe");
            $table->text("picture");
            $table->text("profession");
            $table->text("cv");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
