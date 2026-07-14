<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --bg:#F8FAFC; }
        body { margin:0; font-family:'Poppins',sans-serif; background:var(--bg); color:#334155; }
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:260px; background:var(--dark); padding:1.5rem; flex-shrink:0; }
        .sidebar-brand { color:white; font-size:1.5rem; font-weight:700; text-decoration:none; display:block; margin-bottom:2rem; }
        .nav-link { color:rgba(255,255,255,.75); border-radius:8px; padding:.75rem 1rem; margin-bottom:.35rem; display:flex; gap:.75rem; align-items:center; text-decoration:none; }
        .nav-link:hover,.nav-link.active { background:rgba(255,255,255,.12); color:white; }
        .main { flex:1; padding:2rem; }
        .card-soft { background:white; border:0; border-radius:12px; box-shadow:0 4px 16px rgba(15,23,42,.06); }
        @media (max-width: 992px) { .layout { display:block; } .sidebar { width:100%; } .main { padding:1rem; } }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/super-admin/dashboard" class="sidebar-brand">EsporTec <small class="opacity-75">Super admin</small></a>
        <nav>
            <a href="/super-admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
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
                <h1 class="fw-bold mb-1">Logs da plataforma</h1>
                <p class="text-muted mb-0">Acesso restrito ao super admin da plataforma EsporTec.</p>
            </div>
            <span class="badge bg-warning text-dark">Super admin da plataforma</span>
        </div>
        <section class="card-soft p-4">
            <div class="row g-3 mb-3">
                <div class="col-md-3"><input type="date" class="form-control" id="dataLog"></div>
                <div class="col-md-3"><select class="form-select" id="tipoLog"><option value="">Todas as ações</option><option>Login</option><option>Reserva</option><option>Pagamento</option><option>Usuário</option><option>Equipe</option></select></div>
                <div class="col-md-4"><input class="form-control" id="buscarLog" placeholder="Buscar usuário ou descrição"></div>
                <div class="col-md-2"><button class="btn btn-success w-100" id="btnFiltrarLogs"><i class="bi bi-search me-1"></i>Filtrar</button></div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Data</th><th>Usuário</th><th>Ação</th><th>Descrição</th><th>IP</th></tr></thead>
                    <tbody>
                        <tr data-log-date="2026-06-21"><td>21/06/2026 15:42</td><td>Maria Admin</td><td><span class="badge bg-success">Pagamento</span></td><td>Confirmou pagamento da reserva #1235.</td><td>192.168.0.14</td></tr>
                        <tr data-log-date="2026-06-21"><td>21/06/2026 14:18</td><td>João Funcionário</td><td><span class="badge bg-primary">Reserva</span></td><td>Alterou horário da reserva #1234.</td><td>192.168.0.22</td></tr>
                        <tr data-log-date="2026-06-21"><td>21/06/2026 09:10</td><td>Plataforma EsporTec</td><td><span class="badge bg-warning text-dark">Equipe</span></td><td>Inativou funcionário Ana Lima como ação de suporte da plataforma.</td><td>192.168.0.10</td></tr>
                        <tr data-log-date="2026-06-20"><td>20/06/2026 20:05</td><td>Pedro Cliente</td><td><span class="badge bg-secondary">Login</span></td><td>Acessou a área do cliente.</td><td>189.88.12.40</td></tr>
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
<script src="/js/esportec-ui.js"></script>
<script>
    function filtrarLogs() {
        const tipo = document.getElementById('tipoLog').value.toLowerCase();
        const termo = document.getElementById('buscarLog').value.trim().toLowerCase();
        const data = document.getElementById('dataLog').value;
        let visiveis = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const texto = row.textContent.toLowerCase();
            const bateTipo = !tipo || texto.includes(tipo);
            const bateBusca = !termo || texto.includes(termo);
            const bateData = !data || row.dataset.logDate === data;
            const mostrar = bateTipo && bateBusca && bateData;
            row.classList.toggle('d-none', !mostrar);
            if (mostrar) {
                visiveis += 1;
            }
        });
        document.getElementById('logsEmpty').classList.toggle('d-none', visiveis > 0);
    }

    document.getElementById('btnFiltrarLogs').addEventListener('click', filtrarLogs);
    document.getElementById('buscarLog').addEventListener('input', filtrarLogs);
    document.getElementById('tipoLog').addEventListener('change', filtrarLogs);
    document.getElementById('dataLog').addEventListener('change', filtrarLogs);
</script>
</body>
</html>

