<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/criar-conta', function () {
    return view('auth.criar-conta');
});

Route::get('/recuperar-senha', function () {
    return view('auth.recuperar-senha');
});

Route::get('/painel', function () {
    return view('cliente.painel');
});

Route::get('/nova-reserva', function () {
    return view('cliente.nova-reserva');
});

Route::get('/minhas-reservas', function () {
    return view('cliente.minhas-reservas');
});

Route::get('/notificacoes', function () {
    return view('cliente.notificacoes');
});

Route::get('/perfil', function () {
    return view('cliente.perfil');
});

Route::get('/detalhes-quadra', function () {
    return view('detalhes-quadra');
});

Route::get('/arenas/{arena}/quadras', function ($arena) {
    $arenas = [
        'esportec-arena' => [
            'nome' => 'EsporTec Arena',
            'dono' => 'João Silva',
            'endereco' => 'Rua dos Esportes, 123 - São Paulo, SP',
            'telefone' => '(11) 9999-9999',
            'email' => 'contato@esportec.com.br',
            'dias_funcionamento' => 'Segunda a domingo',
            'funcionamento' => '07:00 - 23:00',
            'formas_pagamento' => ['PIX', 'Dinheiro', 'Cartão'],
            'infraestrutura' => ['Estacionamento', 'Vestiários', 'Iluminação LED', 'Atendimento presencial'],
            'descricao' => 'Unidade principal com quadras society e futsal, estacionamento e atendimento presencial.',
            'imagem' => 'https://images.unsplash.com/photo-1556056504-5c7696c4c28d?auto=format&fit=crop&w=1400&q=80',
            'quadras' => [
                [
                    'slug' => 'futsal-arena',
                    'nome' => 'Quadra Futsal Arena',
                    'tipo' => 'Futsal',
                    'preco' => 'R$ 120,00/hora',
                    'capacidade' => '10 jogadores',
                    'coberta' => 'Sim',
                    'descricao' => 'Quadra de futsal coberta com piso de madeira, ótima para competições e treinos.',
                    'imagem' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=800&q=80',
                ],
                [
                    'slug' => 'society-premium',
                    'nome' => 'Quadra Society Premium',
                    'tipo' => 'Society',
                    'preco' => 'R$ 150,00/hora',
                    'capacidade' => '14 jogadores',
                    'coberta' => 'Não',
                    'descricao' => 'Quadra society com grama sintética de última geração e iluminação LED.',
                    'imagem' => 'https://images.unsplash.com/photo-1551958219-acbc608c6377?auto=format&fit=crop&w=800&q=80',
                ],
                [
                    'slug' => 'society-descoberta',
                    'nome' => 'Quadra Society Descoberta',
                    'tipo' => 'Society',
                    'preco' => 'R$ 100,00/hora',
                    'capacidade' => '14 jogadores',
                    'coberta' => 'Não',
                    'descricao' => 'Quadra society ao ar livre com grama sintética e iluminação noturna.',
                    'imagem' => 'https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=800&q=80',
                ],
            ],
        ],
        'society-cameta' => [
            'nome' => 'Arena Society Cametá',
            'dono' => 'Maria Oliveira',
            'endereco' => 'Bairro Novo - Cametá, PA',
            'telefone' => '(91) 98888-4455',
            'email' => 'societycameta@esportec.com.br',
            'dias_funcionamento' => 'Segunda a sábado',
            'funcionamento' => '08:00 - 22:00',
            'formas_pagamento' => ['PIX', 'Dinheiro', 'Cartão'],
            'infraestrutura' => ['Arquibancada', 'Iluminação noturna', 'Bebedouro', 'Recepção'],
            'descricao' => 'Arena parceira preparada para jogos society, com agenda própria e pagamento presencial.',
            'imagem' => 'https://images.unsplash.com/photo-1526232761682-d26e03ac148e?auto=format&fit=crop&w=1400&q=80',
            'quadras' => [
                [
                    'slug' => 'campo-society-cameta',
                    'nome' => 'Campo Society Cametá',
                    'tipo' => 'Society',
                    'preco' => 'R$ 110,00/hora',
                    'capacidade' => '14 jogadores',
                    'coberta' => 'Não',
                    'descricao' => 'Campo society com iluminação noturna e agenda própria da unidade.',
                    'imagem' => 'https://images.unsplash.com/photo-1526232761682-d26e03ac148e?auto=format&fit=crop&w=800&q=80',
                ],
            ],
        ],
        'zona-norte' => [
            'nome' => 'Unidade Zona Norte',
            'dono' => 'Carlos Mendes',
            'endereco' => 'Zona Norte - São Paulo, SP',
            'telefone' => '(11) 97777-2211',
            'email' => 'zonanorte@esportec.com.br',
            'dias_funcionamento' => 'Segunda a domingo',
            'funcionamento' => '07:00 - 21:00',
            'formas_pagamento' => ['PIX', 'Dinheiro'],
            'infraestrutura' => ['Quadra coberta', 'Iluminação LED', 'Área de espera', 'Banheiros'],
            'descricao' => 'Espaço compacto para reservas rápidas, ideal para treinos, amistosos e jogos recorrentes.',
            'imagem' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=1400&q=80',
            'quadras' => [
                [
                    'slug' => 'quadra-zona-norte',
                    'nome' => 'Quadra Zona Norte',
                    'tipo' => 'Society',
                    'preco' => 'R$ 95,00/hora',
                    'capacidade' => '12 jogadores',
                    'coberta' => 'Sim',
                    'descricao' => 'Quadra society para reservas rápidas, treinos e jogos recorrentes.',
                    'imagem' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=800&q=80',
                ],
            ],
        ],
    ];

    abort_unless(isset($arenas[$arena]), 404);

    $arenasMenu = [];
    foreach ($arenas as $arenaSlug => $arenaData) {
        $arenasMenu[] = [
            'slug' => $arenaSlug,
            'nome' => $arenaData['nome'],
            'quadras' => count($arenaData['quadras']),
        ];
    }

    return view('arena-quadras', [
        'slug' => $arena,
        'arena' => $arenas[$arena],
        'arenasMenu' => $arenasMenu,
    ]);
});

Route::get('/painel-funcionario', function () {
    return view('funcionario.painel');
});

Route::get('/funcionario/agenda', function () {
    return view('funcionario.agenda');
});

Route::get('/funcionario/perfil', function () {
    return view('funcionario.perfil');
});

Route::get('/funcionario/notificacoes', function () {
    return view('funcionario.notificacoes');
});

Route::get('/admin/agendamentos', function () {
    return view('admin.agendamentos');
});

Route::get('/admin/financeiro', function () {
    return view('admin.financeiro');
});


Route::get('/admin/clientes', function () {
    return view('admin.clientes');
});

Route::get('/admin/quadras', function () {
    return view('admin.quadras');
});

Route::get('/admin/equipe', function () {
    return view('admin.equipe');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/configuracoes', function () {
    return view('admin.configuracoes');
});

Route::get('/admin/logs', function () {
    return view('admin.logs');
});

Route::get('/admin/notificacoes', function () {
    return view('admin.notificacoes');
});

Route::get('/super-admin/dashboard', function () {
     return view('super-admin.dashboard'); });

Route::get('/teste', function () {
    return view('teste-navegacao');
});

Route::get('/cadastrar-arena', function () {
    return view('cadastrar-arena');
});

Route::get('/partida/{codigo?}', function () {
    return view('partida');
});
