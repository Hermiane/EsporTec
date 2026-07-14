<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Arena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArenaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lista só as arenas que o dono administra
        $arenas = Arena::whereIn('id', function($query) {
            $query->select('arenas_id')
                  ->from('admin_arenas')
                  ->where('usuarios_id', auth()->id());
        })->get();

        return view('painel', compact('arenas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('arenas.create'); // view do form
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Valida os campos - ajusta conforme teu form
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string|max:2',
            'telefone' => 'nullable|string',
        ]);

        // 2. Cria a arena
        $arena = Arena::create($validated);

        // 3. Vincula o usuário logado como admin dessa arena
        DB::table('admin_arenas')->insert([
            'arenas_id' => $arena->id,
            'usuarios_id' => auth()->id(),
        ]);

        return redirect()->route('painel')->with('success', 'Arena cadastrada!');
    }
}