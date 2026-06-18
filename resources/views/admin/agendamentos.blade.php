<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Agendamentos - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-dark: #0F172A; --primary: #3B82F6; --success: #10B981; --danger: #EF4444; --warning: #F59E0B; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; color: var(--admin-dark); margin: 0; }
        .card-custom { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-box { padding: 1.2rem; border-radius: 12px; color: white; display: flex; align-items: center; gap: 1rem; }
        .stat-box.total { background: linear-gradient(135deg, var(--primary), #60A5FA); }
        .stat-box.pending { background: linear-gradient(135deg, var(--warning), #FCD34D); color: #1F2937; }
        .stat-box.confirmed { background: linear-gradient(135deg, var(--success), #34D399); }
        .stat-box.cancelled { background: linear-gradient(135deg, var(--danger), #F87171); }
        .stat-value { font-size: 2rem; font-weight: 700; }
        .stat-label { font-size: 0.9rem; opacity: 0.95; }
        .table-custom { width: 100%; border-collapse: collapse; }
        .table-custom th { text-align: left; padding: 1rem; background: #F1F5F9; color: #64748B; font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid #E2E8F0; }
        .table-custom td { padding: 1rem; border-bottom: 1px solid #F1F5F9; vertical-align: middle; }
        .badge-status { padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
        .badge-pendente { background: #FEF3C7; color: #B45309; }
        .badge-confirmada { background: #D1FAE5; color: #065F46; }
        .badge-cancelada { background: #FEE2E2; color: #991B1B; }
        .badge-concluida { background: #DBEAFE; color: #1E40AF; }
        .btn-action { padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem; border: none; cursor: pointer; margin-right: 0.3rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; }
        .btn-confirm { background: rgba(16,185,129,0.1); color: var(--success); }
        .btn-confirm:hover { background: var(--success); color: white; }
        .btn-cancel { background: rgba(239,68,68,0.1); color: var(--danger); }
        .btn-cancel:hover { background: var(--danger); color: white; }
        .btn-edit { background: rgba(59,130,246,0.1); color: var(--primary); }
        .btn-edit:hover { background: var(--primary); color: white; }
        .filter-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .filter-bar input, .filter-bar select { padding: 0.6rem; border: 1px solid #E2E8F0; border-radius: 8px; }
        .btn-primary-admin { background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.6;">ADMIN</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-grid"></i> Visão Geral</a>
            <a href="/admin/agendamentos" class="nav-link active"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/pessoas" class="nav-link"><i class="bi bi-people"></i> Usuários</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>
    <main class="main">
        <div class="header">
            <h1><i class="bi bi-calendar-check me-2"></i>Gestão de Agendamentos</h1>
            <button class="btn-primary-admin" data-bs-toggle="modal" data-bs-target="#modalReserva">
                <i class="bi bi-plus-lg me-2"></i>Nova Reserva
            </button>
        </div>
        
        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-box total">
                <i class="bi bi-calendar-event fs-1"></i>
                <div>
                    <div class="stat-value">45</div>
                    <div class="stat-label">Total do Mês</div>
                </div>
            </div>
            <div class="stat-box pending">
                <i class="bi bi-clock-history fs-1"></i>
                <div>
                    <div class="stat-value">5</div>
                    <div class="stat-label">Pendentes</div>
                </div>
            </div>
            <div class="stat-box confirmed">
                <i class="bi bi-check-circle fs-1"></i>
                <div>
                    <div class="stat-value">38</div>
                    <div class="stat-label">Confirmadas</div>
                </div>
            </div>
            <div class="stat-box cancelled">
                <i class="bi bi-x-circle fs-1"></i>
                <div>
                    <div class="stat-value">2</div>
                    <div class="stat-label">Canceladas</div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filter-bar">
            <input type="date" class="form-control" style="width: 200px;">
            <select class="form-select" style="width: 200px;">
                <option>Todas as Quadras</option>
                <option>Futsal Arena</option>
                <option>Society Premium</option>
                <option>Beach Tennis #1</option>
            </select>
            <select class="form-select" style="width: 200px;">
                <option>Todos os Status</option>
                <option>Pendente</option>
                <option>Confirmada</option>
                <option>Cancelada</option>
                <option>Concluída</option>
            </select>
            <input type="text" placeholder="Buscar cliente..." class="form-control" style="width: 250px;">
        </div>

        <!-- Tabela -->
        <div class="card-custom">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data/Hora</th>
                        <th>Quadra</th>
                        <th>Cliente</th>
                        <th>Telefone</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1234</td>
                        <td>14/06/2026<br><small>14:00 - 15:30</small></td>
                        <td>Society Premium</td>
                        <td>João Silva</td>
                        <td>(11) 99999-9999</td>
                        <td>R$ 225,00</td>
                        <td><span class="badge-status badge-confirmada">Confirmada</span></td>
                        <td>
                            <button class="btn-action btn-edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn-action btn-cancel"><i class="bi bi-x-circle"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#1235</td>
                        <td>15/06/2026<br><small>19:00 - 20:00</small></td>
                        <td>Futsal Arena</td>
                        <td>Pedro Santos</td>
                        <td>(11) 98888-8888</td>
                        <td>R$ 120,00</td>
                        <td><span class="badge-status badge-pendente">Pendente</span></td>
                        <td>
                            <button class="btn-action btn-confirm"><i class="bi bi-check-circle"></i></button>
                            <button class="btn-action btn-edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn-action btn-cancel"><i class="bi bi-x-circle"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#1236</td>
                        <td>16/06/2026<br><small>10:00 - 11:00</small></td>
                        <td>Beach Tennis #1</td>
                        <td>Ana Lima</td>
                        <td>(11) 97777-7777</td>
                        <td>R$ 100,00</td>
                        <td><span class="badge-status badge-concluida">Concluída</span></td>
                        <td>
                            <button class="btn-action btn-edit" disabled style="opacity:0.5"><i class="bi bi-pencil"></i></button>
                            <button class="btn-action btn-cancel" disabled style="opacity:0.5"><i class="bi bi-x-circle"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Nova Reserva -->
<div class="modal fade" id="modalReserva" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Nova Reserva Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Cliente</label>
                    <input type="text" class="form-control" placeholder="Nome do cliente">
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-medium">Quadra</label>
                        <select class="form-select">
                            <option>Society Premium</option>
                            <option>Futsal Arena</option>
                            <option>Beach Tennis #1</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-medium">Data</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-medium">Hora Início</label>
                        <input type="time" class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-medium">Hora Fim</label>
                        <input type="time" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Valor (R$)</label>
                    <input type="number" step="0.01" class="form-control" placeholder="0,00">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="alert('Reserva criada!');bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide()">
                    <i class="bi bi-check-circle"></i> Criar Reserva
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>