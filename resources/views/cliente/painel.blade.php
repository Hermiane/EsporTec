<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Cliente - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2D815D;
            --dark: #1F5C42;
            --light: #E8F5EE;
            --bg: #F8FAFC;
            --text: #334155;
            --gray: #64748B;
        }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--text); margin: 0; }

        /* Layout */
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: white; padding: 1.5rem; box-shadow: 2px 0 18px rgba(15,23,42,0.12); display: flex; flex-direction: column; position: fixed; inset: 0 auto 0 0; z-index: 1100; transform: translateX(-105%); transition: transform 0.25s ease; }
        .sidebar.open { transform: translateX(0); }
        .sidebar-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.35); z-index: 1090; opacity: 0; pointer-events: none; transition: opacity 0.2s ease; }
        .sidebar-overlay.show { opacity: 1; pointer-events: auto; }
        .sidebar-brand { font-size: 1.6rem; font-weight: 700; color: var(--primary); text-decoration: none; margin-bottom: 2rem; display: block; }
        .header-start { gap: 1.35rem !important; }
        .menu-toggle { width: 42px; height: 42px; flex: 0 0 42px; border-radius: 10px; border: 1px solid rgba(45,129,93,0.25); background: white; color: var(--primary); display: inline-flex; align-items: center; justify-content: center; font-size: 1.3rem; box-shadow: 0 4px 12px rgba(45,129,93,0.12); }
        .menu-toggle:hover { background: var(--primary); color: white; }
        .account-button { border: 1px solid rgba(45,129,93,0.22); background: white; color: var(--text); border-radius: 999px; padding: 0.35rem 0.45rem 0.35rem 0.4rem; display: inline-flex; align-items: center; gap: 0.55rem; box-shadow: 0 4px 14px rgba(15,23,42,0.06); transition: all 0.2s ease; }
        .account-button:hover, .account-button.active { border-color: var(--primary); background: var(--light); color: var(--primary); box-shadow: 0 6px 18px rgba(45,129,93,0.14); }
        .account-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--primary); color: white; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.82rem; }
        .account-name { font-weight: 600; font-size: 0.92rem; line-height: 1; }
        .account-button .bi-chevron-down { font-size: 0.85rem; transition: transform 0.2s ease; }
        .account-button.active .bi-chevron-down { transform: rotate(180deg); }
        .nav-item { margin-bottom: 0.5rem; }
        .nav-link { color: var(--gray); font-weight: 500; padding: 0.8rem 1rem; border-radius: 10px; display: flex; align-items: center; gap: 0.8rem; transition: all 0.2s; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: var(--light); color: var(--primary); }
        .nav-link i { font-size: 1.2rem; }
        .logout { color: #EF4444; margin-top: auto; }
        .logout:hover { background: rgba(239,68,68,0.1); color: #EF4444; }

        .main { flex: 1; padding: 2rem; overflow-y: auto; width: 100%; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .header h1 { font-size: 1.8rem; font-weight: 700; margin: 0; }
        .header p { color: var(--gray); margin: 0; }
        .top-panel { background: white; border-radius: 12px; padding: 1rem; margin-top: -1rem; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); }
        .profile-menu { max-width: 420px; margin-left: auto; border: 1px solid rgba(45,129,93,0.12); }
        .profile-menu-header { display: flex; align-items: center; gap: 0.85rem; padding-bottom: 0.9rem; border-bottom: 1px solid #E2E8F0; margin-bottom: 0.85rem; }
        .profile-menu-avatar { width: 48px; height: 48px; border-radius: 50%; background: var(--primary); color: white; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; }
        .profile-actions { display: grid; gap: 0.5rem; }
        .profile-action { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 0.8rem 0.9rem; border-radius: 10px; text-decoration: none; color: var(--text); border: 1px solid #E2E8F0; background: white; font-weight: 600; transition: all 0.2s ease; }
        .profile-action:hover { background: var(--light); border-color: rgba(45,129,93,0.25); color: var(--primary); }
        .profile-action.danger { color: #D32F2F; }
        .profile-action.danger:hover { background: rgba(211,47,47,0.08); border-color: rgba(211,47,47,0.25); color: #D32F2F; }

        /* Cards */
        .card-custom { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.04); padding: 1.5rem; margin-bottom: 1.5rem; }
        .highlight-card { background: linear-gradient(135deg, var(--primary), var(--dark)); color: white; border-radius: 16px; padding: 2rem; position: relative; overflow: hidden; margin-bottom: 2rem; }
        .highlight-card::after { content: '⚽'; position: absolute; right: -10px; bottom: -20px; font-size: 7rem; opacity: 0.1; transform: rotate(-15deg); }

        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .quick-btn { background: white; border-radius: 12px; padding: 1.5rem 1rem; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.04); cursor: pointer; transition: all 0.2s; text-decoration: none; color: inherit; display: block; }
        .quick-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(45,129,93,0.15); }
        .quick-btn i { font-size: 1.8rem; color: var(--primary); margin-bottom: 0.5rem; display: block; }
        .quick-btn span { font-weight: 600; font-size: 0.9rem; }

        .quadras-grid { margin-bottom: 2rem; }
        .arena-selector { background: white; border-radius: 14px; padding: 1.2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .arena-options { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 0.85rem; }
        .arena-option { border: 1px solid #E2E8F0; border-radius: 12px; padding: 1rem; background: #FFFFFF; cursor: pointer; text-align: left; transition: all 0.2s ease; }
        .arena-option:hover, .arena-option.active { border-color: var(--primary); background: var(--light); box-shadow: 0 6px 16px rgba(45,129,93,0.12); }
        .arena-option strong { display: block; color: var(--text); margin-bottom: 0.2rem; }
        .arena-option small { color: var(--gray); }
        .arena-badge { display: inline-flex; align-items: center; gap: 0.35rem; background: var(--light); color: var(--primary); border-radius: 999px; padding: 0.25rem 0.6rem; font-size: 0.75rem; font-weight: 700; margin-bottom: 0.75rem; }
        .quadra-card { height: 100%; overflow: hidden; border: none; border-radius: 12px; background: white; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
        .quadra-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
        .quadra-img { width: 100%; height: 220px; object-fit: cover; }
        .quadra-content { padding: 1.5rem; }
        .quadra-title { font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem; }
        .rating { color: #FFC107; margin-bottom: 1rem; }
        .quadra-info { margin: 0.45rem 0; color: #666; }
        .quadra-info strong { color: var(--text); }
        .price { font-size: 1.5rem; font-weight: 700; color: var(--primary); margin: 1rem 0; }
        .btn-select-quadra { width: 100%; padding: 0.8rem; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; justify-content: center; align-items: center; gap: 0.4rem; transition: all 0.3s; }
        .btn-select-quadra:hover { background: var(--dark); color: white; }
        .empty-search { background: white; border: 1px dashed rgba(45,129,93,0.35); border-radius: 12px; padding: 2rem; text-align: center; color: var(--gray); box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 2rem; }
        .empty-search i { width: 56px; height: 56px; border-radius: 50%; background: var(--light); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; font-size: 1.7rem; margin-bottom: 1rem; }
        .empty-search strong { display: block; color: var(--text); font-size: 1.1rem; margin-bottom: 0.35rem; }

        
        .badge-status {
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            border: 1px solid;
            background: transparent; 
        }
        .badge-confirmada {
            color: var(--primary);
            border-color: var(--primary);
        }
        .badge-pago {
            color: #3B82F6;
            border-color: #3B82F6;
        }
        .badge-pendente {
            color: #F59E0B;
            border-color: #F59E0B;
        }
        .badge-cancelada {
            color: #EF4444;
            border-color: #EF4444;
        }

        /* Loading state */
        .loading-placeholder {
            background: #F1F5F9;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            color: var(--gray);
        }
        .loading-placeholder i {
            animation: spin 1s linear infinite;
            font-size: 2rem;
            color: var(--primary);
        }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        /* Mobile */
        @media (max-width: 992px) {
            .sidebar { width: min(280px, 86vw); }
            .mobile-nav { display: flex; position: fixed; bottom: 0; left: 0; right: 0; background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.05); padding: 0.5rem; justify-content: space-around; z-index: 1000; }
            .mobile-nav a { text-align: center; color: var(--gray); font-size: 0.7rem; text-decoration: none; }
            .mobile-nav i { font-size: 1.4rem; display: block; margin-bottom: 0.2rem; }
            .main { padding: 1.5rem; padding-bottom: 5rem; }
            .quadra-img { height: 180px; }
            .account-name { display: none; }
            .account-button { padding-right: 0.45rem; gap: 0.35rem; }
        }
        @media (min-width: 993px) { .mobile-nav { display: none; } }
    </style>
</head>
<body>

<div class="layout">
    <!-- Sidebar Desktop -->
    <aside class="sidebar">
        <a href="/painel" class="sidebar-brand">EsporTec</a>
        <nav>
            <div class="nav-item"><a href="/painel" class="nav-link active"><i class="bi bi-grid"></i> Painel</a></div>
            <div class="nav-item"><a href="/nova-reserva" class="nav-link"><i class="bi bi-calendar-plus"></i> Nova Reserva</a></div>
            <div class="nav-item"><a href="/minhas-reservas" class="nav-link"><i class="bi bi-list-check"></i> Minhas Reservas</a></div>
            <div class="nav-item"><a href="/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações <span class="badge bg-danger rounded-pill ms-auto" id="notifCount">3</span></a></div>
            <div class="nav-item"><a href="/perfil" class="nav-link"><i class="bi bi-person"></i> Meu Perfil</a></div>
        </nav>
        <a href="/login" class="nav-link logout"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </aside>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Conteúdo Principal -->
    <main class="main">
        <div class="header">
            <div class="d-flex align-items-center header-start">
                <button type="button" class="menu-toggle" id="menuToggle" aria-label="Abrir menu">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1 id="boasVindasCliente">Olá!</h1>
                    <p id="resumoReservasHoje">Bem-vindo de volta. Carregando suas reservas...</p>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <button type="button" class="btn btn-light" id="searchToggle" aria-label="Buscar"><i class="bi bi-search"></i></button>
                <a href="/notificacoes" class="btn btn-light" aria-label="Notificações"><i class="bi bi-bell"></i></a>
                <button type="button" class="account-button" id="profileToggle" aria-label="Abrir menu da conta" aria-expanded="false">
                    <span class="account-avatar">{{ substr(auth()->user()->nome_completo ?? 'C', 0, 2) }}</span>
                    <span class="account-name">{{ explode(' ', auth()->user()->nome_completo ?? 'Cliente')[0] }}</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
            </div>
        </div>

        <div id="searchPanel" class="top-panel d-none">
            <label class="form-label fw-semibold" for="clientSearch">Buscar arenas ou quadras</label>
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control" id="clientSearch" placeholder="Digite o nome da arena ou quadra">
                <button type="button" class="btn btn-success" id="goSearch">Ir</button>
            </div>
        </div>

        <div id="profilePanel" class="top-panel profile-menu d-none">
            <div class="profile-menu-header">
                <span class="profile-menu-avatar">{{ substr(auth()->user()->nome_completo ?? 'C', 0, 2) }}</span>
                <div>
                    <h6 class="fw-bold mb-1">{{ auth()->user()->nome_completo ?? 'Cliente' }}</h6>
                    <small class="text-muted">Cliente EsporTec</small>
                </div>
            </div>
            <div class="profile-actions">
                <a href="/perfil" class="profile-action">
                    <span><i class="bi bi-person me-2"></i>Meu perfil</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="/notificacoes" class="profile-action">
                    <span><i class="bi bi-bell me-2"></i>Notificações</span>
                    <span class="badge bg-danger rounded-pill" id="profileNotifCount">3</span>
                </a>
                <a href="/login" class="profile-action danger">
                    <span><i class="bi bi-box-arrow-left me-2"></i>Sair da conta</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>

        <!-- Próxima Reserva -->
        <div class="highlight-card" id="proximaReservaCard">
            <div class="loading-placeholder" id="proximaReservaLoading">
                <i class="bi bi-hourglass-split"></i>
                <p class="mb-0 mt-2">Carregando sua próxima partida...</p>
            </div>
            <div id="proximaReservaContent" class="d-none">
                <h3 class="mb-2" id="proximaReservaQuadra">Quadra Society Premium</h3>
                <p class="mb-3 opacity-75" id="proximaReservaInfo">Hoje, 19:00</p>
                <div class="d-flex gap-4 align-items-center flex-wrap">
                    <div>
                        <small class="d-block opacity-75">Duração</small>
                        <strong id="proximaReservaDuracao">1h30min</strong>
                    </div>
                    <div>
                        <small class="d-block opacity-75">Status</small>
                        <span class="badge bg-light text-success px-4 py-2 rounded-pill fw-bold" id="proximaReservaStatus">Confirmada</span>
                    </div>
                    <button type="button" class="btn btn-light ms-auto fw-semibold px-4" data-bs-toggle="modal" data-bs-target="#modalProximaReserva">
                        Ver Detalhes
                    </button>
                </div>
            </div>
        </div>

        <!-- Atalhos Rápidos -->
        <h5 class="fw-bold mb-3">Atalhos Rápidos</h5>
        <div class="quick-grid">
            <a href="/nova-reserva" class="quick-btn">
                <i class="bi bi-plus-circle-dotted"></i>
                <span>Nova Reserva</span>
            </a>
            <a href="/minhas-reservas" class="quick-btn">
                <i class="bi bi-clock-history"></i>
                <span>Histórico</span>
            </a>
            <a href="/notificacoes" class="quick-btn">
                <i class="bi bi-chat-dots"></i>
                <span>Notificações</span>
            </a>
            <a href="/perfil" class="quick-btn">
                <i class="bi bi-gear"></i>
                <span>Meu Perfil</span>
            </a>
        </div>

        <!-- Arenas disponíveis -->
        <section class="arena-selector">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Escolha a arena</h5>
                    <p class="text-muted mb-0">Você pode reservar em uma arena específica ou ver todas as quadras cadastradas.</p>
                </div>
                <span class="badge bg-success" id="arenasCount">3 arenas</span>
            </div>
            <div class="arena-options" id="arenaOptions">
                @if(isset($arenas) && $arenas->count() > 0)
                    <button type="button" class="arena-option active" data-arena-filter="todas">
                        <strong>Todas as arenas</strong>
                        <small>Mostrar todas as quadras disponíveis</small>
                    </button>
                    @foreach($arenas as $arena)
                        <button type="button" class="arena-option" data-arena-filter="{{ $arena->slug ?? strtolower(str_replace(' ', '-', $arena->nome)) }}">
                            <strong>{{ $arena->nome }}</strong>
                            <small>{{ $arena->cidade ?? 'Localização' }} • {{ $arena->quadras_count ?? '1' }} quadra{{ $arena->quadras_count != 1 ? 's' : '' }} cadastrada{{ $arena->quadras_count != 1 ? 's' : '' }}</small>
                        </button>
                    @endforeach
                @else
                    <button type="button" class="arena-option active" data-arena-filter="todas">
                        <strong>Todas as arenas</strong>
                        <small>Mostrar todas as quadras disponíveis</small>
                    </button>
                    <button type="button" class="arena-option" data-arena-filter="esportec-arena">
                        <strong>EsporTec Arena</strong>
                        <small>Centro • 3 quadras cadastradas</small>
                    </button>
                @endif
            </div>
        </section>

        <!-- Quadras Disponíveis -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-0">Quadras Disponíveis</h5>
                <small class="text-muted" id="arenaAtualLabel">Mostrando quadras de todas as arenas</small>
            </div>
        </div>
        
        <div id="quadrasLoading" class="loading-placeholder">
            <i class="bi bi-hourglass-split"></i>
            <p class="mb-0 mt-2">Carregando quadras disponíveis...</p>
        </div>
        
        <div class="row g-4 quadras-grid" id="quadrasGrid"></div>
        
        <div id="emptySearch" class="empty-search d-none">
            <i class="bi bi-search"></i>
            <strong>Nenhuma quadra encontrada</strong>
            <p class="mb-0">Tente buscar por Futsal, Society ou pelo nome da quadra.</p>
        </div>

        <!-- Reservas Recentes -->
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Reservas Recentes</h5>
                <a href="/minhas-reservas" class="text-decoration-none small fw-semibold" style="color: var(--primary)">Ver todas</a>
            </div>
            <div class="table-responsive">
                <div id="reservasLoading" class="loading-placeholder py-3">
                    <i class="bi bi-hourglass-split"></i>
                    <small>Carregando histórico...</small>
                </div>
                <table class="table table-borderless align-middle mb-0" id="reservasTable">
                    <thead class="text-muted small">
                        <tr>
                            <th>Quadra</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Status</th>
                            <th>Pagamento</th>
                        </tr>
                    </thead>
                    <tbody id="reservasBody">
                        <!-- Preenchido via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modal Detalhes da Próxima Reserva -->
<div class="modal fade" id="modalProximaReserva" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title fw-bold">Detalhes da próxima partida</h5>
                    <small class="text-muted" id="modalReservaId">Reserva #ESP-1900</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted d-block">Quadra</small>
                            <strong class="fs-5" id="modalQuadraNome">Quadra Society Premium</strong>
                            <p class="mb-0 text-muted mt-2" id="modalQuadraDesc">Grama sintética, iluminação LED e capacidade para 14 jogadores.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted d-block">Data e horário</small>
                            <strong class="fs-5" id="modalDataHora">Hoje, 19:00 - 20:30</strong>
                            <p class="mb-0 text-muted mt-2">Chegue com 10 minutos de antecedência.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Duração</small>
                            <strong id="modalDuracao">1h30min</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Status da reserva</small>
                            <span class="badge-status badge-confirmada" id="modalStatus">Confirmada</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Pagamento</small>
                            <span class="badge-status badge-pendente" id="modalPagamento">Pendente</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Endereço</small>
                            <strong id="modalEndereco">Rua dos Esportes, 123 - São Paulo, SP</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 flex-wrap">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <a href="/minhas-reservas" class="btn btn-outline-success">
                    <i class="bi bi-list-check me-2"></i>Ver no histórico
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Navegação Mobile -->
<nav class="mobile-nav">
    <a href="/painel"><i class="bi bi-grid"></i>Início</a>
    <a href="/nova-reserva"><i class="bi bi-calendar-plus"></i>Reservar</a>
    <a href="/minhas-reservas"><i class="bi bi-list-check"></i>Reservas</a>
    <a href="/perfil"><i class="bi bi-person"></i>Perfil</a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    const usuarioSessao = JSON.parse(localStorage.getItem('esportec_user') || 'null');
    if (usuarioSessao?.nome_completo) document.getElementById('boasVindasCliente').textContent = `Olá, ${usuarioSessao.nome_completo}!`;
    
    const API_BASE = '/api/cliente';
    let currentArenaFilter = 'todas';
    let currentSearchTerm = '';

    const MOCK_QUADRAS = [
        {
            id: 1, nome: 'Quadra Futsal Arena', tipo: 'Futsal', capacidade_jogadores: 10, coberta: true,
            preco_hora: 120.00, descricao: 'Quadra de futsal coberta com piso de madeira.',
            imagem: 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=800&q=80',
            avaliacao_media: 4.6, total_avaliacoes: 89,
            arena: { nome: 'EsporTec Arena', slug: 'esportec-arena' }, slug: 'futsal-arena'
        },
        {
            id: 2, nome: 'Quadra Society Premium', tipo: 'Society', capacidade_jogadores: 14, coberta: false,
            preco_hora: 150.00, descricao: 'Quadra society com grama sintética de última geração.',
            imagem: 'https://images.unsplash.com/photo-1551958219-acbc608c6377?auto=format&fit=crop&w=800&q=80',
            avaliacao_media: 4.8, total_avaliacoes: 124,
            arena: { nome: 'EsporTec Arena', slug: 'esportec-arena' }, slug: 'society-premium'
        },
        {
            id: 3, nome: 'Quadra Society Descoberta', tipo: 'Society', capacidade_jogadores: 14, coberta: false,
            preco_hora: 100.00, descricao: 'Quadra society ao ar livre com grama sintética.',
            imagem: 'https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=800&q=80',
            avaliacao_media: 4.5, total_avaliacoes: 67,
            arena: { nome: 'EsporTec Arena', slug: 'esportec-arena' }, slug: 'society-descoberta'
        }
    ];

    async function carregarProximaReserva() {
        try {
            const reservas = await EsporTecApi.request(`${API_BASE}/reservas`);
            const agora = new Date();
            agora.setHours(0, 0, 0, 0);
            const reserva = reservas.find(item => {
                const dataReserva = new Date(`${String(item.data).slice(0, 10)}T${item.hora_inicio}`);
                return !['cancelada', 'concluida'].includes(item.status) && dataReserva >= agora;
            });

            if (!reserva) {
                document.getElementById('proximaReservaCard').innerHTML = `
                    <div class="text-center py-3">
                        <i class="bi bi-calendar-plus fs-2"></i>
                        <h3 class="mt-2 mb-1">Você ainda não tem reservas</h3>
                        <p class="mb-3 opacity-75">Escolha uma quadra e faça sua primeira reserva.</p>
                        <a href="/nova-reserva" class="btn btn-light fw-semibold">Nova Reserva</a>
                    </div>`;
                return;
            }

            document.getElementById('proximaReservaCard').innerHTML = `
                <h3 class="mb-2">${reserva.quadra?.nome || 'Quadra não identificada'}</h3>
                <p class="mb-3 opacity-75">${formatarData(reserva.data)}, ${String(reserva.hora_inicio).slice(0, 5)} - ${String(reserva.hora_fim).slice(0, 5)}</p>
                <div class="d-flex gap-4 align-items-center flex-wrap">
                    <div><small class="d-block opacity-75">Duração</small><strong>${calcularDuracao(reserva.hora_inicio, reserva.hora_fim)}</strong></div>
                    <div><small class="d-block opacity-75">Reserva</small><span class="badge bg-light ${getBadgeClass(reserva.status)} px-4 py-2 rounded-pill fw-bold">${formatarStatus(reserva.status)}</span></div>
                    <div><small class="d-block opacity-75">Pagamento</small><strong>${reserva.pagamento?.status === 'pago' ? 'Pago' : 'Pendente'}</strong></div>
                    <a href="/minhas-reservas" class="btn btn-light ms-auto fw-semibold px-4">Ver detalhes</a>
                </div>`;
        } catch (error) {
            document.getElementById('proximaReservaCard').innerHTML = '<div class="text-center py-3"><p class="mb-0">Não foi possível carregar suas reservas agora.</p></div>';
        }
    }

    async function carregarQuadras(arenaSlug = null, search = '') {
        try {
            document.getElementById('quadrasLoading').classList.remove('d-none');
            document.getElementById('quadrasGrid').innerHTML = '';
            
            let url = `${API_BASE}/quadras`;
            const params = new URLSearchParams();
            if (arenaSlug && arenaSlug !== 'todas') params.append('arena', arenaSlug);
            if (search) params.append('busca', search);
            if (params.toString()) url += `?${params.toString()}`;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error('Erro ao carregar quadras');
            
            const quadras = await response.json();
            renderizarQuadras(quadras);
        } catch (error) {
            console.log('Usando dados fictícios para quadras:', error.message);
            let quadrasFiltradas = MOCK_QUADRAS;
            if (arenaSlug && arenaSlug !== 'todas') {
                quadrasFiltradas = MOCK_QUADRAS.filter(q => q.arena?.slug === arenaSlug);
            }
            if (search) {
                quadrasFiltradas = quadrasFiltradas.filter(q => 
                    q.nome.toLowerCase().includes(search.toLowerCase()) ||
                    q.tipo.toLowerCase().includes(search.toLowerCase())
                );
            }
            renderizarQuadras(quadrasFiltradas);
        } finally {
            document.getElementById('quadrasLoading').classList.add('d-none');
        }
    }

    function renderizarQuadras(quadras) {
        if (quadras.length > 0) {
            quadras.forEach(quadra => {
                const card = document.createElement('div');
                card.className = 'col-lg-4';
                card.dataset.arena = quadra.arena?.slug || 'sem-arena';
                card.innerHTML = `
                    <div class="quadra-card">
                        <img src="${quadra.foto || quadra.imagem || 'https://via.placeholder.com/800x220?text=Sem+imagem'}"
                         alt="${quadra.nome}" class="quadra-img">
                        <div class="quadra-content">
                            <span class="arena-badge"><i class="bi bi-building"></i>${quadra.arena?.nome || 'Arena'}</span>
                            <h3 class="quadra-title">${quadra.nome}</h3>
                            <div class="rating">
                                <i class="bi bi-star-fill"></i>
                                <span>${quadra.avaliacao_media?.toFixed(1) || '0.0'} (${quadra.total_avaliacoes || 0} avaliações)</span>
                            </div>
                            <p class="quadra-info">${quadra.descricao || ''}</p>
                            <p class="quadra-info"><strong>Tipo:</strong> ${quadra.tipo}</p>
                            <p class="quadra-info"><strong>Capacidade:</strong> ${quadra.capacidade_jogador || quadra.capacidade_jogadores || 0} jogadores</p>
                            <p class="quadra-info"><strong>Coberta:</strong> ${quadra.coberta ? 'Sim' : 'Não'}</p>
                            <div class="price">R$ ${parseFloat(quadra.preco_hora).toFixed(2).replace('.', ',')}/hora</div>
                            <a href="/nova-reserva?arena=${quadra.arena?.id || quadra.arenas_id}&quadra=${quadra.id}&etapa=data" class="btn-select-quadra">
                                Selecionar <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                `;
                document.getElementById('quadrasGrid').appendChild(card);
            });
            document.getElementById('emptySearch').classList.add('d-none');
        } else {
            document.getElementById('emptySearch').classList.remove('d-none');
        }
    }

    async function carregarReservasRecentes() {
        try {
            document.getElementById('reservasLoading').classList.remove('d-none');
            document.getElementById('reservasBody').innerHTML = '';
            
            const reservas = await EsporTecApi.request(`${API_BASE}/reservas`);
            renderizarReservas(reservas);
            atualizarResumoReservasHoje(reservas);
        } catch (error) {
            console.error('Erro ao carregar reservas:', error.message);
            renderizarReservas([]);
            atualizarResumoReservasHoje([]);
        } finally {
            document.getElementById('reservasLoading').classList.add('d-none');
        }
    }

    function atualizarResumoReservasHoje(reservas) {
        const hoje = new Date().toISOString().slice(0, 10);
        const total = reservas.filter(reserva => String(reserva.data).slice(0, 10) === hoje && reserva.status === 'confirmada').length;
        document.getElementById('resumoReservasHoje').textContent = total === 0
            ? 'Bem-vindo de volta. Você não tem reservas confirmadas para hoje.'
            : `Bem-vindo de volta. Você tem ${total} reserva${total > 1 ? 's' : ''} confirmada${total > 1 ? 's' : ''} para hoje.`;
    }


    function renderizarReservas(reservas) {
        if (reservas.length > 0) {
            reservas.forEach(reserva => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="fw-semibold">${reserva.quadra?.nome || 'Quadra'}</td>
                    <td>${formatarData(reserva.data)}</td>
                    <td>${reserva.hora_inicio}</td>
                    <td><span class="badge-status ${getBadgeClass(reserva.status)}">${formatarStatus(reserva.status)}</span></td>
                    <td><span class="badge-status ${reserva.pagamento?.status === 'pago' ? 'badge-pago' : 'badge-pendente'}">${reserva.pagamento?.status === 'pago' ? 'Pago' : 'Pendente'}</span></td>
                `;
                document.getElementById('reservasBody').appendChild(row);
            });
        } else {
            document.getElementById('reservasBody').innerHTML = '<tr><td colspan="5" class="text-center text-muted py-3">Nenhuma reserva recente</td></tr>';
        }
    }

    function carregarNotificacoesCount() {
        document.getElementById('notifCount').textContent = 3;
        document.getElementById('profileNotifCount').textContent = 3;
    }

    function formatarData(dataISO) {
        if (!dataISO) return '';
        const data = new Date(dataISO);
        const hoje = new Date();
        const amanha = new Date(hoje);
        amanha.setDate(amanha.getDate() + 1);
        if (data.toDateString() === hoje.toDateString()) return 'Hoje';
        if (data.toDateString() === amanha.toDateString()) return 'Amanhã';
        return data.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit' });
    }
    
    function calcularDuracao(inicio, fim) {
        if (!inicio || !fim) return '';
        const [h1, m1] = inicio.split(':').map(Number);
        const [h2, m2] = fim.split(':').map(Number);
        const diffMin = (h2 * 60 + m2) - (h1 * 60 + m1);
        const h = Math.floor(diffMin / 60);
        const m = diffMin % 60;
        return h > 0 ? `${h}h${m > 0 ? `${m}min` : ''}` : `${m}min`;
    }
    
    function formatarStatus(status) {
        const map = { 'pendente': 'Pendente', 'confirmada': 'Confirmada', 'concluida': 'Concluída', 'cancelada': 'Cancelada' };
        return map[status] || status;
    }
    
    function getBadgeClass(status) {
        const map = { 'pendente': 'badge-pendente', 'confirmada': 'badge-confirmada', 'concluida': 'badge-confirmada', 'cancelada': 'badge-cancelada' };
        return map[status] || '';
    }

    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const searchToggle = document.getElementById('searchToggle');
    const profileToggle = document.getElementById('profileToggle');
    const searchPanel = document.getElementById('searchPanel');
    const profilePanel = document.getElementById('profilePanel');
    const clientSearch = document.getElementById('clientSearch');
    const goSearch = document.getElementById('goSearch');
    const emptySearch = document.getElementById('emptySearch');
    const arenaAtualLabel = document.getElementById('arenaAtualLabel');
    const topPanels = [searchPanel, profilePanel];

    function openSidebar() { sidebar.classList.add('open'); sidebarOverlay.classList.add('show'); }
    function closeSidebar() { sidebar.classList.remove('open'); sidebarOverlay.classList.remove('show'); }
    menuToggle.addEventListener('click', openSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);
    document.querySelectorAll('.sidebar .nav-link').forEach(link => link.addEventListener('click', closeSidebar));

    function toggleTopPanel(panel) {
        topPanels.forEach(item => { if (item !== panel) item.classList.add('d-none'); });
        panel.classList.toggle('d-none');
        syncProfileButtonState();
    }
    function syncProfileButtonState() {
        const isOpen = !profilePanel.classList.contains('d-none');
        profileToggle.classList.toggle('active', isOpen);
        profileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }
    searchToggle.addEventListener('click', () => { toggleTopPanel(searchPanel); if (!searchPanel.classList.contains('d-none')) clientSearch.focus(); });
    profileToggle.addEventListener('click', () => toggleTopPanel(profilePanel));

    document.addEventListener('click', event => {
        const clickedTopAction = event.target.closest('#profileToggle, #searchToggle, #profilePanel, #searchPanel');
        if (!clickedTopAction) { topPanels.forEach(panel => panel.classList.add('d-none')); syncProfileButtonState(); }
    });

    function filterCourtCards() { currentSearchTerm = clientSearch.value.trim(); carregarQuadras(currentArenaFilter, currentSearchTerm); }
    function goToSearchResult() { filterCourtCards(); setTimeout(() => { const firstCard = document.querySelector('.quadras-grid .col-lg-4:not(.d-none)'); if (firstCard) firstCard.scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 300); }
    clientSearch.addEventListener('input', filterCourtCards);
    clientSearch.addEventListener('keydown', event => { if (event.key === 'Enter') { event.preventDefault(); goToSearchResult(); } });
    goSearch.addEventListener('click', goToSearchResult);
    document.addEventListener('keydown', event => { if (event.key === 'Escape') { topPanels.forEach(panel => panel.classList.add('d-none')); syncProfileButtonState(); closeSidebar(); } });

    document.addEventListener('DOMContentLoaded', () => {
        carregarProximaReserva();
        carregarQuadras(currentArenaFilter);
        carregarReservasRecentes();
        carregarNotificacoesCount();
    });
</script>
</body>
</html>