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
    Schema::create('transactions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('property_id')->nullable();
      $table->foreign('property_id')->references('id')->constrained()->on('properties')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('booking_id')->nullable();
      $table->foreign('booking_id')->references('id')->constrained()->on('bookings')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('service_id')->nullable();
      $table->foreign('service_id')->references('id')->constrained()->on('services')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('paid_by')->nullable();
      $table->foreign('paid_by')->references('id')->constrained()->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->double('amount')->nullable();
      $table->double('balance')->nullable();
      $table->enum('paid_for', ['Property','Service'])->default('Property');
      $table->enum('type', ['Rent','Initial-Deposit'])->default('Rent');
      $table->softDeletes('deleted_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('transactions');
  }
};
