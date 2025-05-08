<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    // No necesitamos el constructor aquí si aplicamos el middleware 'auth' en las rutas

    /**
     * Muestra el formulario para crear una nueva transacción.
     */
    public function create()
    {
        return view('web.transactions.create');
    }

    /**
     * Guarda una nueva transacción en la base de datos.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'date' => 'required|date_format:Y-m-d',
            'category' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->route('web.transactions.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $user->transactions()->create($request->all());

        return redirect()->route('dashboard')->with('success', 'Transacción añadida exitosamente.');
    }

    /**
     * Muestra el formulario para editar una transacción existente.
     */
    public function edit(Transaction $transaction)
    {
        // Verificar que el usuario autenticado es el dueño de la transacción
        if (Auth::id() !== $transaction->user_id) {
            return redirect()->route('dashboard')->with('error', 'No autorizado para editar esta transacción.');
        }

        return view('web.transactions.edit', compact('transaction'));
    }

    /**
     * Actualiza una transacción existente en la base de datos.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Verificar que el usuario autenticado es el dueño de la transacción
        if (Auth::id() !== $transaction->user_id) {
            return redirect()->route('dashboard')->with('error', 'No autorizado para actualizar esta transacción.');
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'date' => 'required|date_format:Y-m-d',
            'category' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->route('web.transactions.edit', $transaction->id) // Corregido para pasar el ID
                        ->withErrors($validator)
                        ->withInput();
        }

        $transaction->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Transacción actualizada exitosamente.');
    }

    /**
     * Elimina una transacción de la base de datos.
     */
    public function destroy(Transaction $transaction)
    {
        // Verificar que el usuario autenticado es el dueño de la transacción
        if (Auth::id() !== $transaction->user_id) {
            return redirect()->route('dashboard')->with('error', 'No autorizado para eliminar esta transacción.');
        }

        $transaction->delete();

        return redirect()->route('dashboard')->with('success', 'Transacción eliminada exitosamente.');
    }
}