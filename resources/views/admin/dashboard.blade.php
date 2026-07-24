<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visão Geral - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; --bg: #F8FAFC; --gray: #64748B; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        
        
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, var(--dark) 0%, #154030 100%);
            color: white;
            padding: 1.5rem;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        
        .sidebar-brand {
            color: white;
            font-size: 1.6rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand i { font-size: 2rem; color: #4ADE80; }
        .sidebar-brand small { display: block; font-size: 0.75rem; opacity: 0.7; margin-top: -0.2rem; font-weight: 400; }
        
        .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 0.9rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
        }
        
        
        .main {
            margin-left: 250px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }
        
        
        .mobile-header {
            display: none;
            background: var(--dark);
            color: white;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .mobile-header .btn-menu {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
    
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            border-left: 4px solid var(--primary);
        }
        
        .stat-card.warning { border-left-color: #F9A825; }
        .stat-card.success { border-left-color: var(--primary); }
        .stat-card.info { border-left-color: #1565C0; }
        
        .stat-label {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.3rem;
        }
        
        .stat-subtitle {
            font-size: 0.8rem;
            color: var(--gray);
        }
        
        
        .table-container {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            margin-bottom: 2rem;
            overflow-x: auto;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .badge-status {
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-pendente { background: rgba(249,168,37,0.15); color: #F9A825; }
        .badge-confirmada { background: rgba(45,129,93,0.15); color: var(--primary); }
        
        .btn-action {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-success { background: var(--primary); color: white; }
        .btn-success:hover { background: var(--dark); }
        .btn-danger { background: rgba(239,68,68,0.1); color: #EF4444; }
        .btn-danger:hover { background: rgba(239,68,68,0.2); }
        
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main {
                margin-left: 0;
                padding: 1rem;
            }
            
            .mobile-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .table-container {
                padding: 1rem;
            }
            
            .table thead {
                display: none;
            }
            
            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                padding: 1rem;
                border: 1px solid #E2E8F0;
                border-radius: 8px;
            }
            
            .table td {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem 0;
                border: none;
            }
            
            .table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--gray);
            }
        }
        
        @media (max-width: 576px) {
            .stat-value {
                font-size: 1.5rem;
            }
            
            .btn-action {
                padding: 0.3rem 0.6rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

<!-- HEADER MOBILE -->
<div class="mobile-header">
    <button class="btn-menu" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>
    <span class="fw-bold">EsporTec Admin</span>
    <div style="width: 40px;"></div>
</div>

<div class="sidebar" id="sidebar">
    <a href="/admin/dashboard" class="sidebar-brand">
        <i class="bi bi-trophy"></i>
        <div>
            EsporTec
            <small>Admin da Arena</small>
        </div>
    </a>
    <nav>
        <a href="/admin/dashboard" class="nav-link active"><i class="bi bi-grid"></i> Dashboard</a>
        <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
        <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
        <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3"></i> Quadras</a>
        <a href="/admin/equipe" class="nav-link"><i class="bi bi-people"></i> Equipe</a>
        <a href="/admin/clientes" class="nav-link"><i class="bi bi-person"></i> Clientes</a>
        <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
        <a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </nav>
</div>

<main class="main">
    <div class="mb-4">
        <h2 class="fw-bold mb-2">Visão Geral da Arena</h2>
        <p class="text-muted mb-0">Painel do proprietário/gestor — {{ now()->format('F Y') }}</p>
    </div>

    <!-- CARDS DE ESTATÍSTICAS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label"><i class="bi bi-calendar-check me-2"></i>Reservas Hoje</div>
            <div class="stat-value">1</div>
            <div class="stat-subtitle">0 confirmadas</div>
        </div>
        
        <div class="stat-card success">
            <div class="stat-label"><i class="bi bi-cash-coin me-2"></i>Receita do Mês</div>
            <div class="stat-value">R$ 180,00</div>
            <div class="stat-subtitle">Sem comparação no mês anterior</div>
        </div>
        
        <div class="stat-card info">
            <div class="stat-label"><i class="bi bi-people me-2"></i>Total de Clientes</div>
            <div class="stat-value">3</div>
            <div class="stat-subtitle">+3 novos esta semana</div>
        </div>
        
        <div class="stat-card warning">
            <div class="stat-label"><i class="bi bi-exclamation-triangle me-2"></i>Pendentes</div>
            <div class="stat-value">3</div>
            <div class="stat-subtitle">Aguardando confirmação</div>
        </div>
    </div>

    <!-- PRÓXIMAS RESERVAS -->
    <div class="table-container">
        <h5 class="fw-bold mb-3"><i class="bi bi-calendar3 me-2"></i>Próximas Reservas</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Horário</th>
                        <th>Quadra</th>
                        <th>Cliente</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Horário"><strong>19:00 - 20:00</strong></td>
                        <td data-label="Quadra">Futsal Coberta</td>
                        <td data-label="Cliente">Aedellen Almeida</td>
                        <td data-label="Status"><span class="badge-status badge-pendente"><i class="bi bi-clock"></i> Pendente</span></td>
                        <td data-label="Ações">
                            <button class="btn-action btn-success"><i class="bi bi-check"></i> Confirmar</button>
                            <button class="btn-action btn-danger"><i class="bi bi-x"></i> Cancelar</button>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Horário"><strong>20:00 - 21:00</strong></td>
                        <td data-label="Quadra">Society Premium</td>
                        <td data-label="Cliente">Ana Souza</td>
                        <td data-label="Status"><span class="badge-status badge-confirmada"><i class="bi bi-check-circle"></i> Confirmada</span></td>
                        <td data-label="Ações">
                            <button class="btn-action btn-outline-secondary"><i class="bi bi-eye"></i> Detalhes</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ATIVIDADE RECENTE -->
    <div class="table-container">
        <h5 class="fw-bold mb-3"><i class="bi bi-bell me-2"></i>Atividade Recente</h5>
        <div class="list-group">
            <div class="list-group-item d-flex align-items-center gap-3 py-3">
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-check-lg"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold">Reserva confirmada</div>
                    <small class="text-muted">Aedellen Almeida - 23/07/2026, 10:42</small>
                </div>
            </div>
            <div class="list-group-item d-flex align-items-center gap-3 py-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-plus"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold">Novo cliente cadastrado</div>
                    <small class="text-muted">Carlos Mendes - 23/07/2026, 09:15</small>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }
    
    // Fecha sidebar ao clicar fora no mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const menuBtn = document.querySelector('.btn-menu');
        
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>