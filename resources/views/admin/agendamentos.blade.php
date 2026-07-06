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
        .badge-pago { background: #DBEAFE; color: #1E40AF; }
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
        @media (max-width: 992px) {
            .layout { display: block; }
            .sidebar { width: 100%; }
            .main { padding: 1rem; }
            .card-custom { overflow-x: auto; }
            .table-custom { min-width: 980px; }
            .filter-bar input, .filter-bar select { width: 100% !important; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.6;">ADMIN</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link active"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
            <a href="/admin/logs" class="nav-link"><i class="bi bi-journal-text"></i> Logs</a>
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
                        <th>Pagamento</th>
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
                        <td><span class="badge-status badge-pendente">Dinheiro pendente</span></td>
                        <td>
                            <button class="btn-action btn-confirm" data-action="confirmar-pagamento"><i class="bi bi-cash-coin"></i> Pgto</button>
                            <button class="btn-action btn-edit" data-action="ver-comprovante"><i class="bi bi-file-earmark-image"></i> Comprovante</button>
                            <button class="btn-action btn-edit" data-action="editar-reserva"><i class="bi bi-pencil"></i> Editar</button>
                            <button class="btn-action btn-cancel" data-action="cancelar-reserva"><i class="bi bi-x-circle"></i> Cancelar</button>
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
                        <td><span class="badge-status badge-pendente">PIX pendente</span></td>
                        <td>
                            <button class="btn-action btn-confirm" data-action="confirmar-reserva"><i class="bi bi-check-circle"></i> Confirmar</button>
                            <button class="btn-action btn-confirm" data-action="confirmar-pagamento"><i class="bi bi-cash-coin"></i> Pgto</button>
                            <button class="btn-action btn-edit" data-action="editar-reserva"><i class="bi bi-pencil"></i> Editar</button>
                            <button class="btn-action btn-cancel" data-action="cancelar-reserva"><i class="bi bi-x-circle"></i> Cancelar</button>
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
                        <td><span class="badge-status badge-pago">Pago</span></td>
                        <td>
                            <button class="btn-action btn-edit" disabled style="opacity:0.5"><i class="bi bi-lock"></i> Fechada</button>
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
                <button type="button" class="btn btn-primary" id="btnSalvarReserva">
                    <i class="bi bi-check-circle"></i> Criar Reserva
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    const modalReserva = document.getElementById('modalReserva');
    const tableBody = document.querySelector('.table-custom tbody');

    function executarAcaoAgendamento(button) {
        const action = button.dataset.action;

        if (action === 'editar-reserva') {
            bootstrap.Modal.getOrCreateInstance(modalReserva).show();
            return;
        }

        if (action === 'confirmar-reserva') {
            const row = button.closest('tr');
            row.querySelector('.badge-status').className = 'badge-status badge-confirmada';
            row.querySelector('.badge-status').textContent = 'Confirmada';
            button.remove();
            esportecToast('Reserva confirmada.', 'success');
            return;
        }

        if (action === 'confirmar-pagamento') {
            const row = button.closest('tr');
            const paymentBadge = row.children[7].querySelector('.badge-status');
            paymentBadge.className = 'badge-status badge-pago';
            paymentBadge.textContent = 'Pago';
            button.remove();
            esportecToast('Pagamento confirmado.', 'success');
            return;
        }

        if (action === 'ver-comprovante') {
            esportecToast('Comprovante aberto para conferência.', 'info');
            return;
        }

        if (action === 'cancelar-reserva') {
            if (!confirm('Cancelar esta reserva?')) {
                return;
            }
            const row = button.closest('tr');
            row.querySelector('.badge-status').className = 'badge-status badge-cancelada';
            row.querySelector('.badge-status').textContent = 'Cancelada';
            row.querySelectorAll('button').forEach(action => action.disabled = true);
            esportecToast('Reserva cancelada.', 'success');
        }
    }

    tableBody.addEventListener('click', event => {
        const button = event.target.closest('[data-action]');
        if (button) {
            executarAcaoAgendamento(button);
        }
    });

    document.querySelectorAll('.filter-bar input, .filter-bar select').forEach(filter => {
        filter.addEventListener('input', filtrarAgendamentos);
        filter.addEventListener('change', filtrarAgendamentos);
    });

    function filtrarAgendamentos() {
        const filtros = [...document.querySelectorAll('.filter-bar input, .filter-bar select')]
            .map(input => {
                if (input.type === 'date' && input.value) {
                    return input.value.split('-').reverse().join('/');
                }
                return input.value.trim().toLowerCase();
            })
            .filter(value => value && !value.startsWith('todas') && !value.startsWith('todos'));

        tableBody.querySelectorAll('tr').forEach(row => {
            const texto = row.textContent.toLowerCase();
            row.classList.toggle('d-none', filtros.some(filtro => !texto.includes(filtro)));
        });
    }

    document.getElementById('btnSalvarReserva').addEventListener('click', () => {
        const id = `#${Math.floor(2000 + Math.random() * 7000)}`;
        tableBody.insertAdjacentHTML('afterbegin', `
            <tr>
                <td>${id}</td>
                <td>Hoje<br><small>19:00 - 20:00</small></td>
                <td>Society Premium</td>
                <td>Reserva manual</td>
                <td>(11) 99999-9999</td>
                <td>R$ 150,00</td>
                <td><span class="badge-status badge-confirmada">Confirmada</span></td>
                <td><span class="badge-status badge-pendente">Pendente</span></td>
                <td>
                    <button class="btn-action btn-confirm" data-action="confirmar-pagamento"><i class="bi bi-cash-coin"></i> Pgto</button>
                    <button class="btn-action btn-edit" data-action="editar-reserva"><i class="bi bi-pencil"></i> Editar</button>
                    <button class="btn-action btn-cancel" data-action="cancelar-reserva"><i class="bi bi-x-circle"></i> Cancelar</button>
                </td>
            </tr>
        `);
        esportecToast('Reserva manual criada na tabela.', 'success');
        bootstrap.Modal.getInstance(modalReserva).hide();
    });
</script>
</body>
</html>
