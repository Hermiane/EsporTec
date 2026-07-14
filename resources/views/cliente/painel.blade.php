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

        .badge-status { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-confirmada { background: rgba(45,129,93,0.15); color: var(--primary); }
        .badge-pago { background: rgba(21,101,192,0.15); color: #1565C0; }
        .badge-pendente { background: rgba(249,168,37,0.15); color: #F9A825; }
        .badge-cancelada { background: rgba(211,47,47,0.15); color: #D32F2F; }

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
            <div class="nav-item"><a href="/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações <span class="badge bg-danger rounded-pill ms-auto">3</span></a></div>
            <div class="nav-item"><a href="/perfil" class="nav-link"><i class="bi bi-person"></i> Meu Perfil</a></div>
        </nav>
        <a href="/login" class="nav-link logout"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </aside>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Conteudo Principal -->
    <main class="main">
        <div class="header">
            <div class="d-flex align-items-center header-start">
                <button type="button" class="menu-toggle" id="menuToggle" aria-label="Abrir menu">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1>Olá, João!</h1>
                    <p>Bem-vindo de volta. Você tem 1 reserva confirmada para hoje.</p>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <button type="button" class="btn btn-light" id="searchToggle" aria-label="Buscar"><i class="bi bi-search"></i></button>
                <a href="/notificacoes" class="btn btn-light" aria-label="Notificações"><i class="bi bi-bell"></i></a>
                <button type="button" class="account-button" id="profileToggle" aria-label="Abrir menu da conta" aria-expanded="false">
                    <span class="account-avatar">JS</span>
                    <span class="account-name">João</span>
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
                <span class="profile-menu-avatar">JS</span>
                <div>
                    <h6 class="fw-bold mb-1">João Silva</h6>
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
                    <span class="badge bg-danger rounded-pill">3</span>
                </a>
                <a href="/login" class="profile-action danger">
                    <span><i class="bi bi-box-arrow-left me-2"></i>Sair da conta</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>

        <!-- Próxima Reserva -->
        <div class="highlight-card">
            <h3 class="mb-2">Sua próxima partida</h3>
            <p class="mb-3 opacity-75">Quadra Society Premium • Hoje, 19:00</p>
            <div class="d-flex gap-4 align-items-center flex-wrap">
                <div>
                    <small class="d-block opacity-75">Duração</small>
                    <strong>1h30min</strong>
                </div>
                <div>
                    <small class="d-block opacity-75">Status</small>
                    <span class="badge bg-light text-success px-4 py-2 rounded-pill fw-bold">Confirmada</span>
                </div>
                <button type="button" class="btn btn-light ms-auto fw-semibold px-4" data-bs-toggle="modal" data-bs-target="#modalProximaReserva">
                    Ver Detalhes
                </button>
            </div>
        </div>

        <!-- Atalhos Rapidos -->
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
                <span class="badge bg-success">3 arenas</span>
            </div>
            <div class="arena-options" id="arenaOptions">
                <button type="button" class="arena-option active" data-arena-filter="todas">
                    <strong>Todas as arenas</strong>
                    <small>Mostrar todas as quadras disponíveis</small>
                </button>
                <button type="button" class="arena-option" data-arena-filter="esportec-arena">
                    <strong>EsporTec Arena</strong>
                    <small>Centro • 3 quadras cadastradas</small>
                </button>
                <button type="button" class="arena-option" data-arena-filter="society-cameta">
                    <strong>Arena Society Cametá</strong>
                    <small>Bairro Novo • 1 quadra cadastrada</small>
                </button>
                <button type="button" class="arena-option" data-arena-filter="zona-norte">
                    <strong>Unidade Zona Norte</strong>
                    <small>Zona Norte • 1 quadra cadastrada</small>
                </button>
            </div>
        </section>

        <!-- Quadras Disponíveis -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-0">Quadras Disponíveis</h5>
                <small class="text-muted" id="arenaAtualLabel">Mostrando quadras de todas as arenas</small>
            </div>
        </div>
        <div class="row g-4 quadras-grid">
            <div class="col-lg-4" data-arena="esportec-arena">
                <div class="quadra-card">
                    <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=800&q=80"
                         alt="Quadra Futsal Arena" class="quadra-img">
                    <div class="quadra-content">
                        <span class="arena-badge"><i class="bi bi-building"></i>EsporTec Arena</span>
                        <h3 class="quadra-title">Quadra Futsal Arena</h3>
                        <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <span>4.6 (89 avaliações)</span>
                        </div>
                        <p class="quadra-info">Quadra de futsal coberta com piso de madeira, ótima para competições e treinos.</p>
                        <p class="quadra-info"><strong>Tipo:</strong> Futsal</p>
                        <p class="quadra-info"><strong>Capacidade:</strong> 10 jogadores</p>
                        <p class="quadra-info"><strong>Coberta:</strong> Sim</p>
                        <div class="price">R$ 120/hora</div>
                        <a href="/nova-reserva?arena=esportec-arena&quadra=futsal-arena&etapa=data" class="btn-select-quadra">
                            Selecionar <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-arena="esportec-arena">
                <div class="quadra-card">
                    <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?auto=format&fit=crop&w=800&q=80"
                         alt="Quadra Society Premium" class="quadra-img">
                    <div class="quadra-content">
                        <span class="arena-badge"><i class="bi bi-building"></i>EsporTec Arena</span>
                        <h3 class="quadra-title">Quadra Society Premium</h3>
                        <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <span>4.8 (124 avaliações)</span>
                        </div>
                        <p class="quadra-info">Quadra society com grama sintética de última geração e iluminação LED.</p>
                        <p class="quadra-info"><strong>Tipo:</strong> Society</p>
                        <p class="quadra-info"><strong>Capacidade:</strong> 14 jogadores</p>
                        <p class="quadra-info"><strong>Coberta:</strong> Não</p>
                        <div class="price">R$ 150/hora</div>
                        <a href="/nova-reserva?arena=esportec-arena&quadra=society-premium&etapa=data" class="btn-select-quadra">
                            Selecionar <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-arena="esportec-arena">
                <div class="quadra-card">
                    <img src="https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=800&q=80"
                         alt="Quadra Society Descoberta" class="quadra-img">
                    <div class="quadra-content">
                        <span class="arena-badge"><i class="bi bi-building"></i>EsporTec Arena</span>
                        <h3 class="quadra-title">Quadra Society Descoberta</h3>
                        <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <span>4.5 (67 avaliações)</span>
                        </div>
                        <p class="quadra-info">Quadra society ao ar livre com grama sintética e iluminação noturna.</p>
                        <p class="quadra-info"><strong>Tipo:</strong> Society</p>
                        <p class="quadra-info"><strong>Capacidade:</strong> 14 jogadores</p>
                        <p class="quadra-info"><strong>Coberta:</strong> Não</p>
                        <div class="price">R$ 100/hora</div>
                        <a href="/nova-reserva?arena=esportec-arena&quadra=society-descoberta&etapa=data" class="btn-select-quadra">
                            Selecionar <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-arena="society-cameta">
                <div class="quadra-card">
                    <img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=800&q=80"
                         alt="Campo Society Cametá" class="quadra-img">
                    <div class="quadra-content">
                        <span class="arena-badge"><i class="bi bi-building"></i>Arena Society Cametá</span>
                        <h3 class="quadra-title">Campo Society Cametá</h3>
                        <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <span>4.7 (51 avaliações)</span>
                        </div>
                        <p class="quadra-info">Campo society com grama sintética, arquibancada pequena e iluminação noturna.</p>
                        <p class="quadra-info"><strong>Tipo:</strong> Society</p>
                        <p class="quadra-info"><strong>Capacidade:</strong> 14 jogadores</p>
                        <p class="quadra-info"><strong>Coberta:</strong> Não</p>
                        <div class="price">R$ 130/hora</div>
                        <a href="/nova-reserva?arena=society-cameta&quadra=campo-society-cameta&etapa=data" class="btn-select-quadra">
                            Selecionar <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-arena="zona-norte">
                <div class="quadra-card">
                    <img src="https://images.unsplash.com/photo-1598881034666-6d344b6f58a6?auto=format&fit=crop&w=800&q=80"
                         alt="Quadra Zona Norte" class="quadra-img">
                    <div class="quadra-content">
                        <span class="arena-badge"><i class="bi bi-building"></i>Unidade Zona Norte</span>
                        <h3 class="quadra-title">Quadra Zona Norte</h3>
                        <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <span>4.4 (38 avaliações)</span>
                        </div>
                        <p class="quadra-info">Quadra coberta para futsal e eventos esportivos de pequeno porte.</p>
                        <p class="quadra-info"><strong>Tipo:</strong> Futsal</p>
                        <p class="quadra-info"><strong>Capacidade:</strong> 10 jogadores</p>
                        <p class="quadra-info"><strong>Coberta:</strong> Sim</p>
                        <div class="price">R$ 110/hora</div>
                        <a href="/nova-reserva?arena=zona-norte&quadra=quadra-zona-norte&etapa=data" class="btn-select-quadra">
                            Selecionar <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
                <table class="table table-borderless align-middle mb-0">
                    <thead class="text-muted small">
                        <tr>
                            <th>Quadra</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Status</th>
                            <th>Pagamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">Quadra Futsal Arena</td>
                            <td>12/06/2026</td>
                            <td>16:00</td>
                            <td><span class="badge-status badge-confirmada">Confirmada</span></td>
                            <td><span class="badge-status badge-pendente">Pendente</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Quadra Society Descoberta</td>
                            <td>10/06/2026</td>
                            <td>10:00</td>
                            <td><span class="badge-status badge-confirmada">Concluída</span></td>
                            <td><span class="badge-status badge-pago">Pago</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Society Premium</td>
                            <td>05/06/2026</td>
                            <td>20:00</td>
                            <td><span class="badge-status badge-cancelada">Cancelada</span></td>
                            <td><span class="badge-status badge-cancelada">Cancelado</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="modalProximaReserva" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title fw-bold">Detalhes da próxima partida</h5>
                    <small class="text-muted">Reserva #ESP-1900</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted d-block">Quadra</small>
                            <strong class="fs-5">Quadra Society Premium</strong>
                            <p class="mb-0 text-muted mt-2">Grama sintética, iluminação LED e capacidade para 14 jogadores.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted d-block">Data e horário</small>
                            <strong class="fs-5">Hoje, 19:00 - 20:30</strong>
                            <p class="mb-0 text-muted mt-2">Chegue com 10 minutos de antecedência.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Duração</small>
                            <strong>1h30min</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Status da reserva</small>
                            <span class="badge-status badge-confirmada">Confirmada</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Pagamento</small>
                            <span class="badge-status badge-pendente">Pendente</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Endereço</small>
                            <strong>Rua dos Esportes, 123 - São Paulo, SP</strong>
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

<!-- Navegacao Mobile -->
<nav class="mobile-nav">
    <a href="/painel"><i class="bi bi-grid"></i>Início</a>
    <a href="/nova-reserva"><i class="bi bi-calendar-plus"></i>Reservar</a>
    <a href="/minhas-reservas"><i class="bi bi-list-check"></i>Reservas</a>
    <a href="/perfil"><i class="bi bi-person"></i>Perfil</a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
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
    let currentArenaFilter = 'todas';
    const topPanels = [searchPanel, profilePanel];

    function openSidebar() {
        sidebar.classList.add('open');
        sidebarOverlay.classList.add('show');
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        sidebarOverlay.classList.remove('show');
    }

    menuToggle.addEventListener('click', openSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('click', closeSidebar);
    });

    function toggleTopPanel(panel) {
        topPanels.forEach(item => {
            if (item !== panel) {
                item.classList.add('d-none');
            }
        });
        panel.classList.toggle('d-none');
        syncProfileButtonState();
    }

    function syncProfileButtonState() {
        const isOpen = !profilePanel.classList.contains('d-none');
        profileToggle.classList.toggle('active', isOpen);
        profileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    searchToggle.addEventListener('click', () => {
        toggleTopPanel(searchPanel);
        if (!searchPanel.classList.contains('d-none')) {
            clientSearch.focus();
        }
    });

    profileToggle.addEventListener('click', () => toggleTopPanel(profilePanel));

    document.querySelectorAll('[data-arena-filter]').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('[data-arena-filter]').forEach(item => item.classList.remove('active'));
            button.classList.add('active');
            currentArenaFilter = button.dataset.arenaFilter;
            arenaAtualLabel.textContent = currentArenaFilter === 'todas'
                ? 'Mostrando quadras de todas as arenas'
                : `Mostrando quadras da ${button.querySelector('strong').textContent.trim()}`;
            filterCourtCards();
            document.querySelector('.quadras-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    document.addEventListener('click', event => {
        const clickedTopAction = event.target.closest('#profileToggle, #searchToggle, #profilePanel, #searchPanel');
        if (!clickedTopAction) {
            topPanels.forEach(panel => panel.classList.add('d-none'));
            syncProfileButtonState();
        }
    });

    function filterCourtCards() {
        const term = clientSearch.value.trim().toLowerCase();
        let visibleCount = 0;

        document.querySelectorAll('.quadras-grid .col-lg-4').forEach(cardColumn => {
            const title = cardColumn.querySelector('.quadra-title').textContent.toLowerCase();
            const matchesArena = currentArenaFilter === 'todas' || cardColumn.dataset.arena === currentArenaFilter;
            const matchesSearch = !term || title.includes(term) || cardColumn.textContent.toLowerCase().includes(term);
            const shouldHide = !(matchesArena && matchesSearch);
            cardColumn.classList.toggle('d-none', shouldHide);
            if (!shouldHide) {
                visibleCount++;
            }
        });

        emptySearch.classList.toggle('d-none', visibleCount > 0);
        return visibleCount;
    }

    function goToSearchResult() {
        filterCourtCards();
        const firstVisibleCard = [...document.querySelectorAll('.quadras-grid .col-lg-4')]
            .find(cardColumn => !cardColumn.classList.contains('d-none'));

        if (firstVisibleCard) {
            firstVisibleCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstVisibleCard.querySelector('.quadra-card').classList.add('shadow-lg');
            setTimeout(() => firstVisibleCard.querySelector('.quadra-card').classList.remove('shadow-lg'), 900);
            return;
        }

        emptySearch.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    clientSearch.addEventListener('input', filterCourtCards);
    clientSearch.addEventListener('keydown', event => {
        if (event.key === 'Enter') {
            event.preventDefault();
            goToSearchResult();
        }
    });
    goSearch.addEventListener('click', goToSearchResult);

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            topPanels.forEach(panel => panel.classList.add('d-none'));
            syncProfileButtonState();
            closeSidebar();
        }
    });
</script>
</body>
</html>
