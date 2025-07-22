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
    Schema::create('property_units', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('property_id')->nullable();
      $table->foreign('property_id')->references('id')->constrained()->on('property')->onUpdate('cascade')->onDelete('cascade');
      $table->enum('unit_type', ['Villa','Studio','Room']);
      $table->enum('unit_scope', ['Single','Shared'])->default('Single');
      $table->string('unit_number', 50)->nullable();
      $table->string('unit_floor', 50)->nullable();
      $table->double('unit_rent')->nullable();
      // $table->enum('other_charges', ['No','Yes'])->default('No');
      // $table->double('dewa_charges')->nullable();
      // $table->double('wifi_charges')->nullable();
      // $table->double('misc_charges')->nullable();
      // $table->double('prop_net_rent')->nullable();
      // $table->longText('prop_address')->nullable();
      $table->enum('prop_status', ['Available','Pre-Reserve','Reserved','Checked-In','Checked-Out','Maintenance','Over-Stay'])->default('Available');
      $table->softDeletes('deleted_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('property_units');
  }
};
