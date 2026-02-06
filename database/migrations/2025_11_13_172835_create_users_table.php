<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->unsignedBigInteger('id_course')->nullable();
            $table->integer('level')->nullable();
            $table->string('period')->nullable(); // Semilaboral ou Pos-laboral

            $table->string('role')->default('student');
            $table->timestamp('registration_date')->useCurrent();

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_course')
                  ->references('id_course') // antes era 'id'
                  ->on('courses')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
