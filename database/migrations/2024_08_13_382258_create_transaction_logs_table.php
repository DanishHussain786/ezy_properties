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
    Schema::create('transaction_logs', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('transaction_id')->nullable();
      $table->foreign('transaction_id')->references('id')->constrained()->on('transactions')->onUpdate('cascade')->onDelete('cascade');
      $table->enum('pay_with', ['Cash','Credit-Card','Online','Bank-Transfer','Bank-Cheque'])->default('Cash');
      $table->double('sub_tot')->nullable();
      $table->double('vat_amt')->nullable();
      $table->double('discount')->nullable();
      $table->double('grand_tot');
      $table->double('paid_amount');
      $table->double('balance');
      $table->softDeletes('deleted_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('transaction_logs');
  }
};
