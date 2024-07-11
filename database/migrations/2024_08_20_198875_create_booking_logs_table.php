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
      $table->double('amount');
      $table->enum('purpose', ['Rent Charges','Admin Fee', 'Security Deposit', 'Maintenance Charges', 'Panelty Charges', 'Final Adjustments'])->default('Rent Charges');
      $table->enum('status', ['Unpaid','Paid','Refunded'])->default('Unpaid');
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
