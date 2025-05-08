<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Clave foránea para el usuario
            $table->string('description');
            $table->decimal('amount', 10, 2); // Monto, ej: 12345678.90
            $table->enum('type', ['income', 'expense']); // Tipo: ingreso o gasto
            $table->date('date'); // Fecha de la transacción
            $table->string('category')->nullable(); // Categoría opcional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
