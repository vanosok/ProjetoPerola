<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculadoraController extends Controller
{
    public function index()
    {
        return view('calculadora');
    }

    public function calcular(Request $request)
    {
        // Validação dos dados de entrada (opcional)
        $request->validate([
            'valor' => 'required|numeric',
        ]);

        // Obtém o valor digitado pelo usuário
        $valor = $request->input('valor');

        // Realiza o cálculo (por exemplo, dobrar o valor)
        $resultado = $valor * 2;

        // Retorna o resultado para uma nova visualização
        return view('resultado', ['resultado' => $resultado]);
    }
}
