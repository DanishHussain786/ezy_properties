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

      // $table->enum('other_charges', ['Yes','No'])->default('No');
      // $table->double('admin_charges')->nullable();
      // $table->double('security_charges')->nullable();
      $table->double('total_payable')->nullable();
      $table->double('total_paid')->nullable();
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
    Schema::dropIfExists('bookings');
  }
};
