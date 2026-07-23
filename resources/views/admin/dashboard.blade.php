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
        :root { --primary:#2D815D; --dark:#1F5C42; --light:#E8F5EE; --bg:#F8FAFC; --text:#334155; }
        body { font-family:'Poppins',sans-serif; background:var(--bg); margin:0; }
        .layout { display:flex; min-height:100vh; }
        
        
        .sidebar {
            width:260px;
            background:linear-gradient(180deg, var(--dark) 0%, #154030 100%);
            color:white;
            padding:2rem 1.5rem;
            position:fixed;
            height:100vh;
            left:0;
            top:0;
            overflow-y:auto;
            z-index:1000;
        }
        .sidebar-brand {
            color:white;
            font-size:1.6rem;
            font-weight:700;
            text-decoration:none;
            display:flex;
            align-items:center;
            gap:0.75rem;
            margin-bottom:3rem;
            padding-bottom:1.5rem;
            border-bottom:1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand i { font-size:2rem; color:#4ADE80; }
        .sidebar-brand small {
            display:block;
            font-size:0.75rem;
            opacity:0.7;
            margin-top:-0.2rem;
            font-weight:400;
        }
        .nav-link {
            color:rgba(255,255,255,0.7);
            padding:0.9rem 1rem;
            border-radius:10px;
            margin-bottom:0.5rem;
            display:flex;
            align-items:center;
            gap:0.8rem;
            text-decoration:none;
            transition:all 0.3s;
            font-weight:500;
        }
        .nav-link:hover, .nav-link.active {
            background:rgba(255,255,255,0.15);
            color:white;
            transform:translateX(5px);
        }
        .nav-link i { font-size:1.2rem; }
        
        /* MAIN CONTENT */
        .main {
            flex:1;
            margin-left:260px;
            padding:2rem;
        }
        
        /* CARDS */
        .card-stat {
            background:white;
            border-radius:16px;
            padding:1.5rem;
            box-shadow:0 4px 16px rgba(15,23,42,0.06);
            border-left:4px solid;
            transition:transform 0.2s;
        }
        .card-stat:hover { transform:translateY(-3px); }
        .card-stat.reservas { border-left-color:#10B981; }
        .card-stat.receita { border-left-color:#3B82F6; }
        .card-stat.clientes { border-left-color:#F59E0B; }
        .card-stat.pendentes { border-left-color:#EF4444; }
        
        .card-stat .icon {
            width:48px;
            height:48px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:1.5rem;
            margin-bottom:1rem;
        }
        .card-stat.reservas .icon { background:#D1FAE5; color:#10B981; }
        .card-stat.receita .icon { background:#DBEAFE; color:#3B82F6; }
        .card-stat.clientes .icon { background:#FEF3C7; color:#F59E0B; }
        .card-stat.pendentes .icon { background:#FEE2E2; color:#EF4444; }
        
        .card-stat h3 {
            font-size:2rem;
            font-weight:700;
            margin:0.5rem 0;
            color:var(--text);
        }
        .card-stat small {
            color:#64748B;
            font-size:0.9rem;
        }
        
        /* BADGES PROFISSIONAIS */
        .badge-status {
            padding:0.5rem 1rem;
            border-radius:8px;
            font-size:0.8rem;
            font-weight:600;
            display:inline-flex;
            align-items:center;
            gap:0.4rem;
            border:1px solid;
        }
        .badge-pendente {
            background:#FFFBEB;
            color:#B45309;
            border-color:#FDE68A;
        }
        .badge-confirmada {
            background:#F0FDF4;
            color:#15803D;
            border-color:#BBF7D0;
        }
        .badge-cancelada {
            background:#FEF2F2;
            color:#B91C1C;
            border-color:#FECACA;
        }
        .badge-concluida {
            background:#EFF6FF;
            color:#1D4ED8;
            border-color:#BFDBFE;
        }
        
        /* TABLE */
        .table-custom {
            background:white;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 4px 16px rgba(15,23,42,0.06);
        }
        .table-custom th {
            background:var(--light);
            color:var(--dark);
            font-weight:600;
            padding:1rem;
            border:none;
        }
        .table-custom td {
            padding:1rem;
            border-bottom:1px solid #F1F5F9;
            vertical-align:middle;
        }
        .table-custom tr:hover { background:#F8FAFC; }
        
        @media (max-width: 992px) {
            .sidebar { width:100%; height:auto; position:relative; }
            .main { margin-left:0; }
        }
    </style>
</head>
<body>
<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">
            <i class="bi bi-trophy"></i>
            <div>
                EsporTec
                <small>Admin da Arena</small>
            </div>
        </a>
        <nav>
            <a href="/admin/dashboard" class="nav-link active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="/admin/agendamentos" class="nav-link">
                <i class="bi bi-calendar-check"></i> Agendamentos
            </a>
            <a href="/admin/financeiro" class="nav-link">
                <i class="bi bi-cash-stack"></i> Financeiro
            </a>
            <a href="/admin/quadras" class="nav-link">
                <i class="bi bi-grid-3x3"></i> Quadras
            </a>
            <a href="/admin/equipe" class="nav-link">
                <i class="bi bi-people"></i> Equipe
            </a>
            <a href="/admin/clientes" class="nav-link">
                <i class="bi bi-person-check"></i> Clientes
            </a>
            <a href="/admin/notificacoes" class="nav-link">
                <i class="bi bi-bell"></i> Notificações
            </a>
            <a href="/admin/configuracoes" class="nav-link">
                <i class="bi bi-gear"></i> Configurações
            </a>
            <a href="/logout" class="nav-link" style="margin-top:2rem; border-top:1px solid rgba(255,255,255,0.1); padding-top:1rem;">
                <i class="bi bi-box-arrow-left"></i> Sair
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">
        <div class="mb-4">
            <h1 class="fw-bold mb-1">Visão Geral da Arena</h1>
            <p class="text-muted mb-3">Painel do proprietário/gestor – {{ now()->format('F Y') }}</p>
            <select class="form-select w-auto">
                <option>Arena Exemplo EsporTec</option>
            </select>
        </div>

        <!-- CARDS -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card-stat reservas">
                    <div class="icon"><i class="bi bi-calendar-check"></i></div>
                    <small>Reservas Hoje</small>
                    <h3>1</h3>
                    <small class="text-success">0 confirmadas</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-stat receita">
                    <div class="icon"><i class="bi bi-cash-coin"></i></div>
                    <small>Receita do Mês</small>
                    <h3>R$ 180,00</h3>
                    <small>Sem comparação no mês anterior</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-stat clientes">
                    <div class="icon"><i class="bi bi-people"></i></div>
                    <small>Total de Clientes</small>
                    <h3>3</h3>
                    <small>+3 novos esta semana</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-stat pendentes">
                    <div class="icon"><i class="bi bi-exclamation-triangle"></i></div>
                    <small>Pendentes</small>
                    <h3>3</h3>
                    <small class="text-warning">Aguardando confirmação</small>
                </div>
            </div>
        </div>

        <!-- PRÓXIMAS RESERVAS -->
        <div class="table-custom mb-4">
            <div class="p-4 border-bottom">
                <h5 class="fw-bold mb-0"><i class="bi bi-calendar3 me-2"></i>Próximas Reservas</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
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
                            <td><strong>19:00 - 20:00</strong></td>
                            <td>Futsal Coberta</td>
                            <td>Aedellen Almeida</td>
                            <td><span class="badge-status badge-pendente"><i class="bi bi-clock"></i> Pendente</span></td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="bi bi-check"></i> Confirmar</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x"></i> Cancelar</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>20:00 - 21:00</strong></td>
                            <td>Society Premium</td>
                            <td>Ana Souza</td>
                            <td><span class="badge-status badge-confirmada"><i class="bi bi-check-circle"></i> Confirmada</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i> Detalhes</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ATIVIDADE RECENTE -->
        <div class="table-custom">
            <div class="p-4 border-bottom">
                <h5 class="fw-bold mb-0"><i class="bi bi-bell me-2"></i>Atividade Recente</h5>
            </div>
            <div class="p-4">
                <div class="d-flex align-items-start mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-2">
                            <i class="bi bi-check-circle fs-5"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="mb-1"><strong>Reserva confirmada</strong> - Aedellen Almeida</p>
                        <small class="text-muted">23/07/2026, 10:42</small>
                    </div>
                </div>
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                            <i class="bi bi-person-plus fs-5"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="mb-1"><strong>Novo cliente cadastrado</strong> - Carlos Mendes</p>
                        <small class="text-muted">23/07/2026, 09:15</small>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>