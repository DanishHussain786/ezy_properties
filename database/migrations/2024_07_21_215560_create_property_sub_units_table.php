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
    Schema::create('property_sub_units', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('property_unit_id')->nullable();
      $table->foreign('property_unit_id')->references('id')->constrained()->on('property_units')->onUpdate('cascade')->onDelete('cascade');
      $table->string('title', 50)->nullable();
      $table->double('rent');
      $table->softDeletes('deleted_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('property_sub_units');
  }
};
