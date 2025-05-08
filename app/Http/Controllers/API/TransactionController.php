<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // Importar Validator

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); // Proteger todas las rutas de este controlador
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $transactions = $user->transactions()
                            ->orderBy('date', 'desc') // Ordenar por fecha descendente
                            ->orderBy('created_at', 'desc');

        // Filtrado opcional por tipo (income/expense)
        if ($request->has('type') && in_array($request->type, ['income', 'expense'])) {
            $transactions->where('type', $request->type);
        }

        // Filtrado opcional por rango de fechas
        if ($request->has('start_date') && $request->has('end_date')) {
            $transactions->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        return response()->json($transactions->paginate(15)); // Paginado
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01', // Asegurar que el monto sea positivo
            'type' => 'required|in:income,expense',
            'date' => 'required|date_format:Y-m-d', // Formato de fecha AAAA-MM-DD
            'category' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction = $user->transactions()->create($request->all());

        return response()->json([
            'message' => 'Transacción creada exitosamente',
            'transaction' => $transaction
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Verificar que la transacción pertenece al usuario autenticado
        if (Auth::id() !== $transaction->user_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Verificar que la transacción pertenece al usuario autenticado
        if (Auth::id() !== $transaction->user_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0.01',
            'type' => 'sometimes|required|in:income,expense',
            'date' => 'sometimes|required|date_format:Y-m-d',
            'category' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction->update($request->all());

        return response()->json([
            'message' => 'Transacción actualizada exitosamente',
            'transaction' => $transaction
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Verificar que la transacción pertenece al usuario autenticado
        if (Auth::id() !== $transaction->user_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $transaction->delete();
        return response()->json(['message' => 'Transacción eliminada exitosamente'], 200);
    }
}