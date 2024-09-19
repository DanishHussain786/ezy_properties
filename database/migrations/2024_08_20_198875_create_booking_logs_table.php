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
    Schema::create('booking_logs', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('booking_id')->nullable();
      $table->foreign('booking_id')->references('id')->constrained()->on('bookings')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('property_id')->nullable();
      $table->foreign('property_id')->references('id')->constrained()->on('properties')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('service_id')->nullable();
      $table->foreign('service_id')->references('id')->constrained()->on('services')->onUpdate('cascade')->onDelete('cascade');
      $table->date('checkin_date');
      $table->date('checkout_date');
      $table->integer('for_days')->nullable();
      $table->integer('for_months')->nullable();
      $table->double('rent');
      $table->double('disc_rent')->nullable();
      $table->double('markup_rent')->nullable();
      $table->double('charge_rent')->nullable();
      $table->enum('purpose', ['Rent-Charges','Admin-Fee', 'Security-Deposit', 'Maintenance-Charges', 'Panelty-Charges', 'Final-Adjustments', 'Others'])->default('Rent-Charges');
      $table->enum('status', ['Unpaid','Paid','Refunded','Cancelled'])->default('Unpaid');
      $table->softDeletes('deleted_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('booking_logs');
  }
};
