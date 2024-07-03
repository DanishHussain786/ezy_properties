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
      $table->string('booked_id', 50);
      $table->unsignedBigInteger('booked_by')->nullable();
      $table->foreign('booked_by')->references('id')->constrained()->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('booked_for')->nullable();
      $table->foreign('booked_for')->references('id')->constrained()->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('property_id')->nullable();
      $table->foreign('property_id')->references('id')->constrained()->on('properties')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('service_id')->nullable();
      $table->foreign('service_id')->references('id')->constrained()->on('services')->onUpdate('cascade')->onDelete('cascade');
      $table->date('checkin_date');
      $table->date('checkout_date');
      $table->integer('for_days')->nullable();
      $table->integer('for_months')->nullable();
      $table->double('rent')->nullable();
      $table->double('disc_rent')->nullable();
      $table->double('charge_rent')->nullable();
      $table->double('markup_rent')->nullable();
      $table->double('exempt_rent')->nullable();
      $table->enum('other_charges', ['Yes','No'])->default('No');
      $table->double('admin_charges')->nullable();
      $table->double('security_charges')->nullable();
      $table->double('balance')->nullable();
      $table->double('total_payable')->nullable();
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
