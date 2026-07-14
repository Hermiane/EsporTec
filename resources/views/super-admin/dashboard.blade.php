<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --light:#E8F5EE; --bg:#F8FAFC; --text:#334155; --muted:#64748B; --line:#E2E8F0; }
        body { margin:0; font-family:'Poppins', sans-serif; background:var(--bg); color:var(--text); }
        .layout { min-height:100vh; display:flex; }
        .sidebar { width:270px; background:#10291F; color:white; padding:1.5rem; flex-shrink:0; display:flex; flex-direction:column; }
        .sidebar-brand { color:white; font-weight:700; font-size:1.45rem; text-decoration:none; margin-bottom:1.5rem; display:block; }
        .role-chip { display:inline-flex; width:max-content; align-items:center; gap:.35rem; background:rgba(249,168,37,.16); color:#FDE68A; border:1px solid rgba(249,168,37,.35); border-radius:999px; padding:.35rem .7rem; font-size:.78rem; font-weight:700; margin-bottom:1.4rem; }
        .nav-button, .logout-link { width:100%; border:0; background:transparent; color:rgba(255,255,255,.74); border-radius:10px; padding:.78rem 1rem; margin-bottom:.35rem; display:flex; gap:.75rem; align-items:center; text-decoration:none; text-align:left; font-weight:500; }
        .nav-button:hover, .nav-button.active, .logout-link:hover { background:rgba(255,255,255,.12); color:white; }
        .logout-link { margin-top:auto; color:#FCA5A5; }
        .main { flex:1; padding:2rem; overflow:auto; }
        .hero { background:white; border:1px solid var(--line); border-radius:16px; padding:1.5rem; box-shadow:0 6px 18px rgba(15,23,42,.06); margin-bottom:1.5rem; }
        .hero-badge { display:inline-flex; align-items:center; gap:.4rem; background:#FEF3C7; color:#92400E; border-radius:999px; padding:.35rem .75rem; font-weight:700; font-size:.82rem; }
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(210px,1fr)); gap:1rem; margin-bottom:1.5rem; }
        .stat-card { background:white; border:1px solid var(--line); border-radius:14px; padding:1.2rem; box-shadow:0 4px 14px rgba(15,23,42,.045); }
        .stat-icon { width:42px; height:42px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; background:var(--light); color:var(--primary); font-size:1.25rem; margin-bottom:.75rem; }
        .stat-value { font-size:1.8rem; font-weight:700; margin:.2rem 0; }
        .stat-label { color:var(--muted); font-weight:500; }
        .section-card { background:white; border:1px solid var(--line); border-radius:14px; padding:1.25rem; box-shadow:0 4px 14px rgba(15,23,42,.045); margin-bottom:1.25rem; }
        .table thead th { color:var(--muted); font-weight:600; font-size:.86rem; }
        .status-dot { width:8px; height:8px; border-radius:50%; display:inline-block; margin-right:.45rem; }
        .dot-green { background:#2D815D; }
        .dot-yellow { background:#F9A825; }
        .dot-red { background:#D32F2F; }
        .btn-success { background:var(--primary); border-color:var(--primary); }
        @media (max-width: 992px) {
            .layout { display:block; }
            .sidebar { width:100%; display:block; }
            .main { padding:1rem; }
            .nav-button, .logout-link { display:inline-flex; width:auto; margin-right:.35rem; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/super-admin/dashboard" class="sidebar-brand">EsporTec</a>
        <div class="role-chip"><i class="bi bi-shield-lock"></i> Super admin da plataforma</div>
        <nav>
            <button type="button" class="nav-button active" data-scroll-target="visao-geral"><i class="bi bi-speedometer2"></i> Visão geral</button>
            <button type="button" class="nav-button" data-scroll-target="arenas"><i class="bi bi-buildings"></i> Arenas</button>
            <button type="button" class="nav-button" data-scroll-target="admins"><i class="bi bi-person-gear"></i> Admins das arenas</button>
            <button type="button" class="nav-button" data-scroll-target="logs"><i class="bi bi-journal-text"></i> Logs globais</button>
        </nav>
        <a href="/login" class="logout-link"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </aside>

    <main class="main">
        <section class="hero" id="visao-geral">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <span class="hero-badge"><i class="bi bi-stars"></i> Plataforma EsporTec</span>
                    <h1 class="fw-bold mt-3 mb-2">Painel do Super Admin</h1>
                    <p class="text-muted mb-0">Controle geral do SaaS: arenas cadastradas, proprietários, planos, suporte e logs da plataforma.</p>
                </div>
                <button class="btn btn-success" id="btnNovaArena"><i class="bi bi-plus-lg me-2"></i>Cadastrar arena</button>
            </div>
        </section>

        <div class="stats-grid">
            <article class="stat-card">
                <span class="stat-icon"><i class="bi bi-buildings"></i></span>
                <div class="stat-label">Arenas cadastradas</div>
                <div class="stat-value">8</div>
                <small class="text-success">6 ativas e 2 em análise</small>
            </article>
            <article class="stat-card">
                <span class="stat-icon"><i class="bi bi-person-badge"></i></span>
                <div class="stat-label">Admins de arena</div>
                <div class="stat-value">12</div>
                <small class="text-muted">Proprietários e gestores</small>
            </article>
            <article class="stat-card">
                <span class="stat-icon"><i class="bi bi-cash-stack"></i></span>
                <div class="stat-label">Receita da plataforma</div>
                <div class="stat-value">R$ 2.400</div>
                <small class="text-success">Planos mensais mockados</small>
            </article>
            <article class="stat-card">
                <span class="stat-icon"><i class="bi bi-life-preserver"></i></span>
                <div class="stat-label">Chamados abertos</div>
                <div class="stat-value">3</div>
                <small class="text-warning">Aguardando suporte</small>
            </article>
        </div>

        <section class="section-card" id="arenas">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Arenas da plataforma</h5>
                    <p class="text-muted mb-0">O Super admin vê todas as arenas cadastradas no EsporTec.</p>
                </div>
                <button class="btn btn-outline-success" id="btnExportarArenas"><i class="bi bi-download me-2"></i>Exportar</button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Arena</th><th>Proprietário/Admin</th><th>Plano</th><th>Status</th><th>Ações</th></tr></thead>
                    <tbody>
                        <tr><td class="fw-semibold">EsporTec Arena</td><td>Maria Admin</td><td>Profissional</td><td><span class="status-dot dot-green"></span>Ativa</td><td><button class="btn btn-sm btn-outline-success" data-platform-action="ver-arena">Ver</button></td></tr>
                        <tr><td class="fw-semibold">Arena Society Cametá</td><td>Rafael Costa</td><td>Essencial</td><td><span class="status-dot dot-yellow"></span>Em análise</td><td><button class="btn btn-sm btn-outline-success" data-platform-action="aprovar">Aprovar</button></td></tr>
                        <tr><td class="fw-semibold">Unidade Zona Norte</td><td>Ana Lima</td><td>Profissional</td><td><span class="status-dot dot-green"></span>Ativa</td><td><button class="btn btn-sm btn-outline-secondary" data-platform-action="suspender">Suspender</button></td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="section-card" id="admins">
            <h5 class="fw-bold mb-3">Admins das arenas</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 rounded border">
                        <div class="fw-bold">Maria Admin</div>
                        <small class="text-muted d-block">Proprietária - EsporTec Arena</small>
                        <span class="badge bg-success mt-2">Ativa</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded border">
                        <div class="fw-bold">Rafael Costa</div>
                        <small class="text-muted d-block">Gestor - Arena Society Cametá</small>
                        <span class="badge bg-warning text-dark mt-2">Pendente</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded border">
                        <div class="fw-bold">Ana Lima</div>
                        <small class="text-muted d-block">Gestora - Unidade Zona Norte</small>
                        <span class="badge bg-success mt-2">Ativa</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-card" id="logs">
            <h5 class="fw-bold mb-3">Logs globais da plataforma</h5>
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0 d-flex justify-content-between flex-wrap gap-2"><span>Plataforma aprovou nova arena</span><small class="text-muted">Hoje, 10:12</small></div>
                <div class="list-group-item px-0 d-flex justify-content-between flex-wrap gap-2"><span>Admin da arena alterou forma de pagamento</span><small class="text-muted">Hoje, 09:40</small></div>
                <div class="list-group-item px-0 d-flex justify-content-between flex-wrap gap-2"><span>Suporte acessou logs da arena EsporTec</span><small class="text-muted">Ontem, 17:25</small></div>
            </div>
        </section>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    document.querySelectorAll('[data-scroll-target]').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('[data-scroll-target]').forEach(item => item.classList.remove('active'));
            button.classList.add('active');
            document.getElementById(button.dataset.scrollTarget).scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    document.getElementById('btnNovaArena').addEventListener('click', () => {
        esportecToast('Fluxo de cadastro de arena preparado para integração com o backend.', 'info');
    });

    document.getElementById('btnExportarArenas').addEventListener('click', () => {
        esportecToast('Exportação das arenas simulada no front.', 'success');
    });

    document.addEventListener('click', event => {
        const button = event.target.closest('[data-platform-action]');
        if (!button) {
            return;
        }

        const messages = {
            'ver-arena': 'Detalhes da arena abertos no mock.',
            aprovar: 'Arena aprovada visualmente para demonstração.',
            suspender: 'Arena marcada para suspensão no mock.'
        };
        esportecToast(messages[button.dataset.platformAction], 'success');
    });
</script>
</body>
</html>
