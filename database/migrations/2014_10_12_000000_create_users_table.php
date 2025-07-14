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
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('first_name', 120);
      $table->string('last_name', 120);
      $table->enum('gender', ['Male','Female']);
      $table->enum('status', ['Active','Block']);
      $table->enum('role', ['Master','Manager','Agent','Staff','Guest']);
      $table->string('dob', 100)->nullable();
      $table->string('contact_no', 120)->nullable();
      $table->string('whatsapp_no', 120)->nullable();
      $table->string('profile_photo')->nullable();
      $table->string('home_address')->nullable();
      $table->string('email', 175)->unique();
      $table->string('emirates_id', 120)->nullable();
      $table->string('emirates_photo')->nullable();
      $table->string('passport_id', 120)->nullable();
      $table->string('passport_photo')->nullable();
      $table->string('password');
      $table->rememberToken();
      $table->timestamp('email_verified_at')->nullable();
      $table->softDeletes('deleted_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
