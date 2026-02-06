<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('id_estudante');
            $table->string('nome_completo');
            $table->date('data_nascimento')->nullable();
            $table->enum('sexo', ['Masculino', 'Feminino'])->nullable();
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->string('endereco')->nullable();
            $table->string('senha');
            $table->unsignedBigInteger('id_curso')->nullable();
            $table->enum('tipo_estudante', ['interno', 'externo'])->default('externo');
            $table->timestamp('data_registo')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
