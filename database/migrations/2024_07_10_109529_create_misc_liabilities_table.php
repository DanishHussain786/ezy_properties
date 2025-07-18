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
    Schema::create('misc_liabilities', function (Blueprint $table) {
      $table->id();
      $table->string('title', 100)->nullable();
      $table->string('description', 150)->nullable();
      $table->enum('type', ['Facility','Service'])->nullable();
      $table->enum('validity_type', ['One-Time','Monthly','Yearly']);
      $table->double('amount');
      $table->softDeletes('deleted_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('misc_liabilities');
  }
};
