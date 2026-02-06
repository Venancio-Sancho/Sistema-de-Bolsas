<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('courses', function (Blueprint $table) {
    $table->id('id_course'); // PK
    $table->string('course_name');
    $table->text('description')->nullable();
    $table->unsignedBigInteger('department_id');
    $table->unsignedBigInteger('faculty_id');
    $table->timestamps();

    $table->foreign('department_id')
          ->references('id_department')->on('departments')
          ->onDelete('cascade');

    $table->foreign('faculty_id')
          ->references('id_faculty')->on('faculties')
          ->onDelete('cascade');
});


    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
