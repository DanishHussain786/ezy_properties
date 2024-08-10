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
    Schema::create('bookings', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('booked_by')->nullable();
      $table->foreign('booked_by')->references('id')->constrained()->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('booked_for')->nullable();
      $table->foreign('booked_for')->references('id')->constrained()->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('property_id')->nullable();
      $table->foreign('property_id')->references('id')->constrained()->on('properties')->onUpdate('cascade')->onDelete('cascade');
      $table->date('checkin_date');
      $table->date('checkout_date');
      $table->integer('for_days')->nullable();
      $table->integer('for_months')->nullable();
      $table->double('rent')->nullable();
      $table->double('adjust_rent')->nullable();
      $table->double('grace_rent')->nullable();
      $table->enum('other_charges', ['No','Yes'])->default('No');
      $table->double('dewa_charges')->nullable();
      $table->double('wifi_charges')->nullable();
      $table->double('admin_charges')->nullable();
      $table->double('security_charges')->nullable();
      $table->double('initial_deposit')->nullable();
      $table->double('net_total')->nullable();
      $table->softDeletes('deleted_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('bookings');
  }
};
