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
    Schema::create('informations', function (Blueprint $table) {
      $table->id();
      $table->string('c_name', 150)->nullable();
      $table->string('c_email', 150)->nullable();
      $table->string('c_office_ph', 100)->nullable();
      $table->string('c_mobile_ph', 100)->nullable();
      $table->string('c_address', 220)->nullable();
      $table->string('c_logo')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('informations');
  }
};
