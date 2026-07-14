<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Quadra;
use App\Models\Reserva;
use App\Models\Pagamento;
use App\Models\SuperAdministrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // RF06 - Dashboard com dados reais
    public function dashboard()
    {
        $totalReservas = Reserva::whereIn('status', ['confirmada', 'concluida'])->count();
        $faturamento = Pagamento::where('status', 'confirmado')->sum('valor');
        $reservasHoje = Reserva::whereDate('data', today())->count();
        $quadrasAtivas = Quadra::where('ativa', true)->count();
        $usuariosAtivos = Usuario::where('ativo', true)->count();
        
        return response()->json([
            'total_reservas' => $totalReservas,
            'faturamento_total' => $faturamento,
            'reservas_hoje' => $reservasHoje,
            'quadras_ativas' => $quadrasAtivas,
            'usuarios_ativos' => $usuariosAtivos
        ], 200);
    }
    
    // RF07 - Gerenciar usuários
    public function usuarios(Request $request)
    {
        $query = Usuario::select('id', 'nome_completo', 'email', 'telefone', 'ativo', 'email_verificado', 'created_at');
        
        // Filtro por status
        if ($request->has('ativo')) {
            $query->where('ativo', $request->boolean('ativo'));
        }
        
        $usuarios = $query->with('superAdm')->orderBy('nome_completo')->get();
        
        return response()->json($usuarios, 200);
    }
    
    // RF07 - Promover usuário a Admin - cria registro em super_administradores
    public function promoverAdmin(Request $request, $id)
    {
        $request->validate([
            'cargo' => 'required|string',
            'permissoes' => 'nullable|array'
        ]);
        
        $usuario = Usuario::findOrFail($id);
        
        // Verifica se já é admin
        if ($usuario->superAdm) {
            return response()->json(['message' => 'Usuário já é administrador'], 400);
        }
        
        SuperAdministrador::create([
            'usuario_id' => $usuario->id,
            'cargo' => $request->cargo,
            'permissoes' => $request->permissoes ?? ['gerenciar_quadras', 'ver_relatorios'],
            'ativo' => true,
            'criado_por' => auth()->id()
        ]);
        
        return response()->json([
            'message' => 'Usuário promovido a administrador',
            'data' => $usuario->load('superAdm')
        ], 200);
    }
    
    // RF07 - Desativar/Ativar usuário
    public function toggleAtivo($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->update(['ativo' => !$usuario->ativo]);
        
        $status = $usuario->ativo ? 'ativado' : 'desativado';
        return response()->json(['message' => "Usuário {$status}"], 200);
    }
    
    // RF08 - CRUD Quadras com campos reais do Model
    public function listarQuadras()
    {
        $quadras = Quadra::with('empresa')->get();
        return response()->json($quadras, 200);
    }
    
    public function storeQuadra(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|string',
            'endereco' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string|size:2',
            'capacidade_jogadores' => 'required|integer|min:1',
            'coberta' => 'required|boolean',
            'preco_hora' => 'required|numeric|min:0',
            'ativa' => 'boolean'
        ]);
        
        $quadra = Quadra::create($request->all());
        return response()->json(['message' => 'Quadra criada', 'data' => $quadra], 201);
    }
    
    public function updateQuadra(Request $request, $id)
    {
        $quadra = Quadra::findOrFail($id);
        
        $request->validate([
            'nome' => 'sometimes|string|max:255',
            'preco_hora' => 'sometimes|numeric|min:0',
            'ativa' => 'sometimes|boolean',
            'coberta' => 'sometimes|boolean',
            'capacidade_jogadores' => 'sometimes|integer|min:1'
        ]);
        
        $quadra->update($request->all());
        return response()->json(['message' => 'Quadra atualizada', 'data' => $quadra], 200);
    }
    
    // RF09 - Relatório financeiro completo
    public function relatorioFinanceiro(Request $request)
    {
        $inicio = $request->data_inicio ?? now()->startOfMonth();
        $fim = $request->data_fim ?? now()->endOfMonth();
        
        $pagamentos = Pagamento::where('status', 'confirmado')
            ->whereBetween('pago_em', [$inicio, $fim])
            ->with(['reserva.quadra:id,nome,preco_hora', 'reserva.usuario:id,nome_completo'])
            ->get();
            
        $total = $pagamentos->sum('valor');
        $porQuadra = $pagamentos->groupBy('reserva.quadra.nome')
            ->map(fn($p) => [
                'total' => $p->sum('valor'),
                'qtd_reservas' => $p->count()
            ]);
        
        return response()->json([
            'periodo' => ['inicio' => $inicio, 'fim' => $fim],
            'total_geral' => $total,
            'qtd_pagamentos' => $pagamentos->count(),
            'faturamento_por_quadra' => $porQuadra,
            'pagamentos' => $pagamentos
        ], 200);
    }
    
    // RF10 - Todas as reservas com dados completos
    public function todasReservas(Request $request)
    {
        $query = Reserva::with([
            'usuario:id,nome_completo,email,telefone', 
            'quadra:id,nome,preco_hora,coberta', 
            'pagamento'
        ]);
        
        // Filtros opcionais
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->data_inicio) {
            $query->whereDate('data', '>=', $request->data_inicio);
        }
        
        $reservas = $query->orderBy('data', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->paginate(20);
            
        return response()->json($reservas, 200);
    }
}