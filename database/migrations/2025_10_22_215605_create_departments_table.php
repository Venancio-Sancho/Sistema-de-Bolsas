<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id_department');
            $table->string('department_name');
            $table->unsignedBigInteger('faculty_id');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('faculty_id')
                  ->references('id_faculty')
                  ->on('faculties')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};

