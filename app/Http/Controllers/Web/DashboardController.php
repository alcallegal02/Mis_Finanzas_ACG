<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Si por alguna razón $user fuera null (no debería pasar si el middleware 'auth' funciona)
        if (!$user) {
            // Puedes redirigir al login o mostrar un error
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver el dashboard.');
        }

        $transactions = Transaction::where('user_id', $user->id)
                                    ->orderBy('date', 'desc')
                                    ->paginate(10);

        $totalIncome = Transaction::where('user_id', $user->id)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $user->id)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Verifica esta línea, especialmente la clave 'userName'
        $viewData = [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'userName' => $user->name, // <-- AQUÍ ES DONDE SE DEFINE
        ];

        // Para depurar, podrías descomentar la siguiente línea temporalmente:
        // dd($viewData);

        return view('dashboard', $viewData);
    }
}