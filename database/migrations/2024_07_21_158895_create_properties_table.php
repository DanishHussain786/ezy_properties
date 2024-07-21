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
    Schema::create('properties', function (Blueprint $table) {
      $table->id();
      $table->enum('prop_type', ['Villa','Appartment','Studio','Room','Bed Space']);
      $table->string('prop_number', 30)->nullable();
      $table->string('prop_floor', 30)->nullable();
      $table->double('prop_rent');
      $table->longText('prop_address')->nullable();
      $table->softDeletes('deleted_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('properties');
  }
};
