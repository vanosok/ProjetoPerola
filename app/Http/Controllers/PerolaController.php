<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerolaController extends Controller
{
    public function index()
    {
        $perolas = [
            1 => 0,
            2 => 0, 
            3 => 0,
            4 => 0, 
            5 => 0,
            6 => 0, 
            7 => 0, 
            8 => 0, 
            9 => 0, 
        ];

        return view('perolas', compact('perolas'));
    }

    public function atualizarPerola(Request $request)
    {
        $perolaId = $request->input('perola_id');
        $quantidade = $request->input('quantidade', 0);

        $guiaForja = $this->calcularGuiaForja($perolaId, $quantidade);

        return response()->json([
            'quantidade' => $quantidade,
            'guia_forja' => $guiaForja
        ]);
    }

    protected function calcularGuiaForja($perolaId, $quantidadeDesejada)
    {
        $relacaoPerolas = [
            'perola2' => ['perola1' => 4],
            'perola3' => ['perola1' => 2, 'perola2' => 2],
            'perola4' => ['perola1' => 1, 'perola2' => 1, 'perola3' => 2],
            'perola5' => ['perola3' => 1, 'perola4' => 2],
            'perola6' => ['perola3' => 1, 'perola5' => 2],
            'perola7' => ['perola4' => 1, 'perola5' => 1, 'perola6' => 1],
            'perola8' => ['perola5' => 1, 'perola6' => 1, 'perola7' => 1],
            'perola9' => ['perola6' => 1, 'perola7' => 1, 'perola8' => 1],
        ];

        $guiaForja = [];

        function calcularForja($id, $quantidade, $relacaoPerolas, &$guiaForja) {
            if (!isset($relacaoPerolas[$id])) {
                return;
            }

            foreach ($relacaoPerolas[$id] as $depId => $depQuantidade) {
                $quantidadeTotal = $quantidade * $depQuantidade;

                if (!isset($guiaForja[$depId])) {
                    $guiaForja[$depId] = 0;
                }
                $guiaForja[$depId] += $quantidadeTotal;

                calcularForja($depId, $quantidadeTotal, $relacaoPerolas, $guiaForja);
            }
        }

        calcularForja($perolaId, $quantidadeDesejada, $relacaoPerolas, $guiaForja);

        ksort($guiaForja);

        return array_reverse($guiaForja, true);
    }
}
