<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Logs - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --bg:#F8FAFC; }
        body { margin:0; font-family:'Poppins',sans-serif; background:var(--bg); color:#334155; }
        .layout { display:flex; min-height:100vh; }
        
        
        .sidebar {
            width:260px;
            background:linear-gradient(180deg, var(--dark) 0%, #154030 100%);
            color:white;
            padding:1.5rem;
            position:fixed;
            height:100vh;
            left:0;
            top:0;
            overflow-y:auto;
            z-index:1000;
        }
        .sidebar-brand {
            color:white;
            font-size:1.5rem;
            font-weight:700;
            text-decoration:none;
            display:flex;
            align-items:center;
            gap:0.5rem;
            margin-bottom:2rem;
            padding-bottom:1rem;
            border-bottom:1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand i { font-size:1.8rem; color:#4ADE80; }
        .sidebar-brand small { font-size:0.7rem; opacity:0.75; display:block; margin-top:-0.2rem; }
        .nav-link {
            color:rgba(255,255,255,.75);
            border-radius:8px;
            padding:.75rem 1rem;
            margin-bottom:.35rem;
            display:flex;
            gap:.75rem;
            align-items:center;
            text-decoration:none;
            transition:all 0.3s;
        }
        .nav-link:hover,.nav-link.active {
            background:rgba(255,255,255,.15);
            color:white;
            transform:translateX(3px);
        }
        
        .main { flex:1; margin-left:260px; padding:2rem; }
        .card-soft { background:white; border:0; border-radius:12px; box-shadow:0 4px 16px rgba(15,23,42,.06); }
        .badge-login { background:#6c757d; }
        .badge-reserva { background:#0d6efd; }
        .badge-pagamento { background:#198754; }
        .badge-usuario { background:#0dcaf0; color:#000; }
        .badge-equipe { background:#ffc107; color:#000; }
        .badge-backup { background:#6f42c1; }
        @media (max-width: 992px) { .layout { display:block; } .sidebar { width:100%; position:relative; height:auto; } .main { margin-left:0; padding:1rem; } }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">
            <i class="bi bi-trophy"></i>
            <div>
                EsporTec
                <small>Admin da arena</small>
            </div>
        </a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-people"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
            <a href="/admin/logs" class="nav-link active"><i class="bi bi-journal-text"></i> Logs</a>
        </nav>
    </aside>
    <main class="main">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Logs do Sistema</h1>
                <p class="text-muted mb-0">Acompanhe as ações realizadas na arena.</p>
            </div>
        </div>
        <section class="card-soft p-4">
            <div class="row g-3 mb-3">
                <div class="col-md-3"><input type="date" class="form-control" id="dataLog"></div>
                <div class="col-md-3"><select class="form-select" id="tipoLog"><option value="">Todas as ações</option><option value="login">Login</option><option value="reserva">Reserva</option><option value="pagamento">Pagamento</option><option value="usuario">Usuário</option><option value="equipe">Equipe</option><option value="backup">Backup</option><option value="sistema">Sistema</option></select></div>
                <div class="col-md-4"><input class="form-control" id="buscarLog" placeholder="Buscar usuário ou descrição"></div>
                <div class="col-md-2"><button class="btn btn-success w-100" id="btnFiltrarLogs"><i class="bi bi-search me-1"></i>Filtrar</button></div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Data</th><th>Usuário</th><th>Ação</th><th>Descrição</th><th>IP</th></tr></thead>
                    <tbody id="tabelaLogs">
                        <tr data-log-date="2026-06-21" data-log-tipo="pagamento">
                            <td>21/06/2026 15:42</td>
                            <td>Maria Admin</td>
                            <td><span class="badge badge-pagamento">Pagamento</span></td>
                            <td>Confirmou pagamento da reserva #1235</td>
                            <td><small class="text-muted">192.168.0.14</small></td>
                        </tr>
                        <tr data-log-date="2026-06-21" data-log-tipo="reserva">
                            <td>21/06/2026 14:18</td>
                            <td>João Funcionário</td>
                            <td><span class="badge badge-reserva">Reserva</span></td>
                            <td>Alterou horário da reserva #1234</td>
                            <td><small class="text-muted">192.168.0.22</small></td>
                        </tr>
                        <tr data-log-date="2026-06-21" data-log-tipo="equipe">
                            <td>21/06/2026 09:10</td>
                            <td>Plataforma EsporTec</td>
                            <td><span class="badge badge-equipe">Equipe</span></td>
                            <td>Inativou funcionário Ana Lima como ação de suporte da plataforma</td>
                            <td><small class="text-muted">192.168.0.10</small></td>
                        </tr>
                        <tr data-log-date="2026-06-20" data-log-tipo="login">
                            <td>20/06/2026 20:05</td>
                            <td>Pedro Cliente</td>
                            <td><span class="badge badge-login">Login</span></td>
                            <td>Acessou a área do cliente</td>
                            <td><small class="text-muted">189.88.12.40</small></td>
                        </tr>
                        <tr data-log-date="2026-06-20" data-log-tipo="reserva">
                            <td>20/06/2026 18:30</td>
                            <td>Ana Lima</td>
                            <td><span class="badge badge-reserva">Reserva</span></td>
                            <td>Criou nova reserva para Society Premium</td>
                            <td><small class="text-muted">189.88.12.40</small></td>
                        </tr>
                        <tr data-log-date="2026-06-20" data-log-tipo="backup">
                            <td>20/06/2026 12:00</td>
                            <td>Sistema</td>
                            <td><span class="badge badge-backup">Backup</span></td>
                            <td>Backup automático concluído com sucesso</td>
                            <td><small class="text-muted">127.0.0.1</small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="logsEmpty" class="text-center py-5 d-none">
                <i class="bi bi-search fs-1 text-success"></i>
                <h5 class="fw-bold mt-3">Nenhum log encontrado</h5>
                <p class="text-muted mb-0">Tente mudar a data, ação ou termo pesquisado.</p>
            </div>
        </section>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Filtragem LOCAL (sem API, sem redirecionamento)
function aplicarFiltros() {
    const data = document.getElementById('dataLog').value;
    const tipo = document.getElementById('tipoLog').value.toLowerCase();
    const busca = document.getElementById('buscarLog').value.trim().toLowerCase();
    
    let visiveis = 0;
    document.querySelectorAll('#tabelaLogs tr[data-log-date]').forEach(row => {
        const texto = row.textContent.toLowerCase();
        const bateTipo = !tipo || row.dataset.logTipo === tipo || texto.includes(tipo);
        const bateBusca = !busca || texto.includes(busca);
        const bateData = !data || row.dataset.logDate === data;
        const mostrar = bateTipo && bateBusca && bateData;
        row.style.display = mostrar ? '' : 'none';
        if (mostrar) visiveis += 1;
    });
    document.getElementById('logsEmpty').classList.toggle('d-none', visiveis > 0);
}

document.getElementById('btnFiltrarLogs').addEventListener('click', aplicarFiltros);
document.getElementById('buscarLog').addEventListener('input', aplicarFiltros);
document.getElementById('tipoLog').addEventListener('change', aplicarFiltros);
document.getElementById('dataLog').addEventListener('change', aplicarFiltros);

document.getElementById('buscarLog').addEventListener('keydown', event => {
    if (event.key === 'Enter') {
        event.preventDefault();
        aplicarFiltros();
    }
});
</script>
</body>
</html>