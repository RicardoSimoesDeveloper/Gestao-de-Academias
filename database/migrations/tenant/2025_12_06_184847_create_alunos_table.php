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
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->string('cpf', 11)->unique()->nullable();
            $table->string('email', 50)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('status')->default('ativo');
            $table->unsignedBigInteger('plano_id')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('plano_id')->references('id')->on('planos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
