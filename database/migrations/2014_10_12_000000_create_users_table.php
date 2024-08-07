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
            $table->string('username')->nullable();
            $table->string('uid');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->nullable();
            $table->integer('level')->comment('1=admin, 2=adminOT, 3=normal');
            $table->string('password')->nullable();
            $table->integer('level')->comment('0=ทั้งหมด, 1=เฉพาะ OT');
            $table->string('created_by');
            $table->rememberToken();
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
