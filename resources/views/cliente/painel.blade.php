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
        .sidebar { width: 260px; background: white; padding: 1.5rem; box-shadow: 2px 0 10px rgba(0,0,0,0.03); display: flex; flex-direction: column; }
        .sidebar-brand { font-size: 1.6rem; font-weight: 700; color: var(--primary); text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-item { margin-bottom: 0.5rem; }
        .nav-link { color: var(--gray); font-weight: 500; padding: 0.8rem 1rem; border-radius: 10px; display: flex; align-items: center; gap: 0.8rem; transition: all 0.2s; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: var(--light); color: var(--primary); }
        .nav-link i { font-size: 1.2rem; }
        .logout { color: #EF4444; margin-top: auto; }
        .logout:hover { background: rgba(239,68,68,0.1); color: #EF4444; }
        
        .main { flex: 1; padding: 2rem; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .header h1 { font-size: 1.8rem; font-weight: 700; margin: 0; }
        .header p { color: var(--gray); margin: 0; }
        
        /* Cards */
        .card-custom { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.04); padding: 1.5rem; margin-bottom: 1.5rem; }
        .highlight-card { background: linear-gradient(135deg, var(--primary), var(--dark)); color: white; border-radius: 16px; padding: 2rem; position: relative; overflow: hidden; margin-bottom: 2rem; }
        .highlight-card::after { content: '⚽'; position: absolute; right: -10px; bottom: -20px; font-size: 7rem; opacity: 0.1; transform: rotate(-15deg); }
        
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .quick-btn { background: white; border-radius: 12px; padding: 1.5rem 1rem; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.04); cursor: pointer; transition: all 0.2s; text-decoration: none; color: inherit; display: block; }
        .quick-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(45,129,93,0.15); }
        .quick-btn i { font-size: 1.8rem; color: var(--primary); margin-bottom: 0.5rem; display: block; }
        .quick-btn span { font-weight: 600; font-size: 0.9rem; }
        
        .badge-status { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-confirmada { background: rgba(45,129,93,0.15); color: var(--primary); }
        .badge-pendente { background: rgba(249,168,37,0.15); color: #F9A825; }
        .badge-cancelada { background: rgba(211,47,47,0.15); color: #D32F2F; }
        
        /* Mobile */
        @media (max-width: 992px) {
            .sidebar { display: none; }
            .mobile-nav { display: flex; position: fixed; bottom: 0; left: 0; right: 0; background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.05); padding: 0.5rem; justify-content: space-around; z-index: 1000; }
            .mobile-nav a { text-align: center; color: var(--gray); font-size: 0.7rem; text-decoration: none; }
            .mobile-nav i { font-size: 1.4rem; display: block; margin-bottom: 0.2rem; }
            .main { padding: 1.5rem; padding-bottom: 5rem; }
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

    <!-- Conteúdo Principal -->
    <main class="main">
        <div class="header">
            <div>
                <h1>Olá, João! 👋</h1>
                <p>Bem-vindo de volta. Você tem 1 reserva confirmada para hoje.</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <button class="btn btn-light"><i class="bi bi-search"></i></button>
                <button class="btn btn-light"><i class="bi bi-bell"></i></button>
                <img src="https://ui-avatars.com/api/?name=João+Silva&background=2D815D&color=fff&rounded=true" width="40" height="40" alt="Avatar">
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
                    <span class="badge-status badge-confirmada">Confirmada</span>
                </div>
                <a href="#" class="btn btn-light ms-auto fw-semibold px-4 text-decoration-none">Ver Detalhes</a>
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
                <span>Mensagens</span>
            </a>
            <a href="/perfil" class="quick-btn">
                <i class="bi bi-gear"></i>
                <span>Configurações</span>
            </a>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">Quadra Futsal Arena</td>
                            <td>12/06/2026</td>
                            <td>16:00</td>
                            <td><span class="badge-status badge-pendente">Pendente</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Beach Tennis #2</td>
                            <td>10/06/2026</td>
                            <td>10:00</td>
                            <td><span class="badge-status badge-confirmada">Concluída</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Society Premium</td>
                            <td>05/06/2026</td>
                            <td>20:00</td>
                            <td><span class="badge-status badge-cancelada">Cancelada</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Navegação Mobile -->
<nav class="mobile-nav">
    <a href="/painel"><i class="bi bi-grid"></i>Início</a>
    <a href="/nova-reserva"><i class="bi bi-calendar-plus"></i>Reservar</a>
    <a href="/minhas-reservas"><i class="bi bi-list-check"></i>Reservas</a>
    <a href="/perfil"><i class="bi bi-person"></i>Perfil</a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>