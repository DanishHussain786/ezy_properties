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
      $table->enum('deposit_by', ['Guest','Other'])->default('Guest');
      $table->string('dep_name', 180)->nullable();
      $table->string('dep_email', 180)->nullable();
      $table->string('dep_contact', 180)->nullable();
      $table->enum('dep_method', ['Cash','Credit-Card','Online','Bank-Transfer','Bank-Cheque'])->default('Cash');      
      $table->double('sub_tot')->nullable();
      $table->double('vat_amt')->nullable();
      $table->double('discount')->nullable();
      $table->double('paid_amount');
      $table->double('balance');
      $table->double('grand_tot');
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
