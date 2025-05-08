<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'type',
        'date',
        'category',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date', // Asegura que el campo 'date' se maneje como un objeto Carbon/Date
        'amount' => 'decimal:2', // Para asegurar la precisión al castear
    ];

    /**
     * Obtener el usuario propietario de la transacción.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}