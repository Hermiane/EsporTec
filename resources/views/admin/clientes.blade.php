<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Clientes - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-dark: #0F172A; --primary: #3B82F6; --success: #10B981; --warning: #F59E0B; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; margin: 0; }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-box { padding: 1.5rem; border-radius: 12px; color: white; display: flex; align-items: center; gap: 1rem; }
        .stat-box.total { background: linear-gradient(135deg, var(--primary), #60A5FA); }
        .stat-box.birthday { background: linear-gradient(135deg, var(--success), #34D399); }
        .stat-box.vip { background: linear-gradient(135deg, var(--warning), #FCD34D); color: #1F2937; }
        .stat-icon { font-size: 2rem; opacity: 0.9; }
        .stat-value { font-size: 2rem; font-weight: 700; margin: 0.5rem 0; }
        .stat-label { font-size: 0.9rem; opacity: 0.95; }
        .card-custom { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .client-avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 1rem; color: white; font-size: 0.9rem; }
        .badge-vip { background: linear-gradient(135deg, #F59E0B, #FCD34D); color: white; padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
        .btn-action { padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem; border: none; cursor: pointer; margin-right: 0.3rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; }
        .btn-offer { background: rgba(245,158,11,0.1); color: var(--warning); }
        .btn-offer:hover { background: var(--warning); color: white; }
        .btn-history { background: rgba(59,130,246,0.1); color: var(--primary); }
        .btn-history:hover { background: var(--primary); color: white; }
        .btn-primary-admin { background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.6;">ADMIN</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-grid"></i> Visão Geral</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/pessoas" class="nav-link"><i class="bi bi-people"></i> Usuários</a>
            <a href="/admin/clientes" class="nav-link active"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>
    
    <main class="main">
        <div class="header">
            <h1><i class="bi bi-people-fill me-2"></i>Gestão de Clientes</h1>
            <button class="btn-primary-admin" onclick="alert('Enviar oferta em massa para todos os clientes')"><i class="bi bi-envelope me-2"></i>Enviar Oferta em Massa</button>
        </div>

        <div class="stats-row">
            <div class="stat-box total">
                <i class="bi bi-people-fill stat-icon"></i>
                <div>
                    <div class="stat-value">342</div>
                    <div class="stat-label">Total de Clientes</div>
                </div>
            </div>
            <div class="stat-box birthday">
                <i class="bi bi-gift-fill stat-icon"></i>
                <div>
                    <div class="stat-value">28</div>
                    <div class="stat-label">Aniversariantes do Mês</div>
                </div>
            </div>
            <div class="stat-box vip">
                <i class="bi bi-star-fill stat-icon"></i>
                <div>
                    <div class="stat-value">45</div>
                    <div class="stat-label">Clientes VIP</div>
                </div>
            </div>
        </div>

        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Lista de Clientes</h5>
                <input type="text" placeholder="Buscar cliente..." class="form-control" style="width: 300px;">
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Reservas</th>
                            <th>Última Visita</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Cliente VIP -->
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="client-avatar" style="background:#3B82F6;">JS</div>
                                    <div>
                                        <div class="fw-semibold">João Silva</div>
                                        <small class="text-muted">CPF: 123.456.789-00</small>
                                    </div>
                                </div>
                            </td>
                            <td>joao.silva@email.com</td>
                            <td>(11) 99999-9999</td>
                            <td><span class="fw-bold">24</span> reservas</td>
                            <td>12/06/2026</td>
                            <td><span class="badge-vip"><i class="bi bi-star-fill me-1"></i>VIP</span></td>
                            <td>
                                <button class="btn-action btn-offer" onclick="alert('Enviar oferta para João Silva')"><i class="bi bi-gift"></i> Oferta</button>
                                <button class="btn-action btn-history" onclick="alert('Ver histórico de João Silva')"><i class="bi bi-clock-history"></i> Histórico</button>
                            </td>
                        </tr>

                        <!-- Cliente Regular -->
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="client-avatar" style="background:#6B7280;">PM</div>
                                    <div>
                                        <div class="fw-semibold">Pedro Martins</div>
                                        <small class="text-muted">CPF: 987.654.321-00</small>
                                    </div>
                                </div>
                            </td>
                            <td>pedro.m@email.com</td>
                            <td>(11) 98888-8888</td>
                            <td><span class="fw-bold">12</span> reservas</td>
                            <td>10/06/2026</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-person me-1"></i>Regular</span></td>
                            <td>
                                <button class="btn-action btn-offer"><i class="bi bi-gift"></i> Oferta</button>
                                <button class="btn-action btn-history"><i class="bi bi-clock-history"></i> Histórico</button>
                            </td>
                        </tr>

                        <!-- Cliente Aniversariante -->
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="client-avatar" style="background:#10B981;">AL</div>
                                    <div>
                                        <div class="fw-semibold">Ana Lima</div>
                                        <small class="text-muted">CPF: 456.789.123-00</small>
                                    </div>
                                </div>
                            </td>
                            <td>ana.lima@email.com</td>
                            <td>(11) 97777-7777</td>
                            <td><span class="fw-bold">8</span> reservas</td>
                            <td>08/06/2026</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-gift me-1"></i>Aniversário</span></td>
                            <td>
                                <button class="btn-action btn-offer"><i class="bi bi-gift"></i> Oferta</button>
                                <button class="btn-action btn-history"><i class="bi bi-clock-history"></i> Histórico</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>