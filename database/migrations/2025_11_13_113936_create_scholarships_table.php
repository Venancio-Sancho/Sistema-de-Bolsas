<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Nome da bolsa
            $table->string('type');           // Tipo (Completa/Parcial)
            $table->text('description');      // Descrição
            $table->text('requirements');     // Requisitos
            $table->date('start_date');       // Data de início
            $table->date('end_date');         // Data de fim
            $table->enum('status', ['Disponível','Indisponível'])->default('Disponível'); // Status
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
