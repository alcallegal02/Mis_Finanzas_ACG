<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    public function index()
    {
        $ingresos = Ingreso::all(); // Obtener todos los ingresos
        return view('ingresos', compact('ingresos'));
    }
}