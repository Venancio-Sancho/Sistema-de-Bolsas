<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id('id_application');

            // FK para users e scholarships
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_scholarship')->constrained('scholarships')->onDelete('cascade');

            // Snapshot (informação do estudante no momento da candidatura)
            $table->string('snapshot_course')->nullable();
            $table->string('snapshot_year')->nullable();
            $table->string('snapshot_period')->nullable();

            // Data de candidatura e status
            $table->date('application_date');
            $table->enum('status', ['pending','approved','rejected'])->default('pending');

            // Paths dos uploads
            $table->string('bilhete_path')->nullable();
            $table->string('atestado_pobreza_path')->nullable();
            $table->string('declaracao_bairro_path')->nullable();
            $table->string('declaracao_agregado_path')->nullable();
            $table->string('declaracao_rendimento_path')->nullable();
            $table->string('aproveitamento_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
