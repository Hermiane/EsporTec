<?php

namespace App\Http\Controllers;

use App\Models\Arena;
use App\Models\Quadra;

class PublicoController extends Controller
{
    public function arenas()
    {
        return response()->json(
            Arena::where('ativo', true)
                ->where('status_aprovacao', 'aprovada')
                ->with(['quadras' => fn ($q) => $q->where('ativo', true)])
                ->get(),
        );
    }

    public function arena($id)
    {
        return response()->json(
            Arena::where('ativo', true)
                ->where('status_aprovacao', 'aprovada')
                ->with(['quadras' => fn ($q) => $q->where('ativo', true)])
                ->findOrFail($id),
        );
    }

    public function quadra($id)
    {
        return response()->json(
            Quadra::where('ativo', true)
                ->whereHas('arena', fn ($arena) => $arena->where('ativo', true)->where('status_aprovacao', 'aprovada'))
                ->with(['arena', 'horariosFuncionamento' => fn ($q) => $q->where('ativo', true)])
                ->findOrFail($id),
        );
    }
}
