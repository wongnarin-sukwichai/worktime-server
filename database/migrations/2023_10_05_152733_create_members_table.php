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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->integer('uid');
            $table->string('pic')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->integer('sex')->nullable();
            $table->integer('dep')->comment('กลุ่มงาน');
            $table->integer('pos')->nullable()->comment('นักคอม, บรรณาลักษณ์');
            $table->integer('rank')->nullable()->comment('ปฏิบัติการ, ชำนาญการ');
            $table->string('type')->nullable()->comment('พนักงาน, ลูกจ้าง');
            $table->integer('stat')->nullable()->comment('ทำงาน, ออก');
            $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->date('work_day')->nullable()->comment('วันเริ่มทำงาน');
            $table->integer('overtime')->nullable()->comment('1=มีชื่อลง ot');
            $table->integer('level');
            $table->string('password')->nullable();
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
        Schema::dropIfExists('members');
    }
};
