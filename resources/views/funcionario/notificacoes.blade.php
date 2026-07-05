<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações - EsporTec Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --light:#E8F5EE; --bg:#F8FAFC; }
        body { margin:0; font-family:'Poppins',sans-serif; background:var(--bg); color:#334155; }
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:250px; background:var(--dark); color:white; padding:1.5rem; flex-shrink:0; }
        .sidebar-brand { color:white; font-size:1.4rem; font-weight:700; text-decoration:none; display:block; margin-bottom:2rem; }
        .nav-link { color:rgba(255,255,255,.76); border-radius:8px; padding:.75rem 1rem; margin-bottom:.4rem; display:flex; gap:.75rem; align-items:center; text-decoration:none; }
        .nav-link:hover,.nav-link.active { background:rgba(255,255,255,.12); color:white; }
        .main { flex:1; padding:2rem; }
        .notice-card { background:white; border-radius:12px; padding:1rem; box-shadow:0 4px 16px rgba(15,23,42,.06); display:flex; gap:1rem; margin-bottom:1rem; align-items:flex-start; }
        .notice-icon { width:42px; height:42px; border-radius:12px; background:var(--light); color:var(--primary); display:inline-flex; align-items:center; justify-content:center; font-size:1.25rem; flex:0 0 42px; }
        @media (max-width: 992px) { .layout { display:block; } .sidebar { width:100%; } .main { padding:1rem; } }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/painel-funcionario" class="sidebar-brand">EsporTec <small class="opacity-75">FUNCIONÁRIO</small></a>
        <nav>
            <a href="/painel-funcionario" class="nav-link"><i class="bi bi-grid"></i> Painel</a>
            <a href="/funcionario/agenda" class="nav-link"><i class="bi bi-calendar-week"></i> Agenda</a>
            <a href="/funcionario/notificacoes" class="nav-link active"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/funcionario/perfil" class="nav-link"><i class="bi bi-person"></i> Perfil</a>
        </nav>
    </aside>
    <main class="main">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Notificações operacionais</h1>
                <p class="text-muted mb-0">Avisos úteis para atendimento, agenda, pagamentos e manutenção.</p>
            </div>
            <button class="btn btn-success" id="btnMarcarTodas"><i class="bi bi-check2-all me-2"></i>Marcar como lidas</button>
        </div>
        <section id="staffNotices">
            <article class="notice-card">
                <span class="notice-icon"><i class="bi bi-cash-coin"></i></span>
                <div><h5 class="fw-bold mb-1">Pagamento pendente</h5><p class="mb-1">João Silva chega às 19:00 com PIX ainda em análise.</p><small class="text-muted">Agora há pouco</small></div>
            </article>
            <article class="notice-card">
                <span class="notice-icon"><i class="bi bi-tools"></i></span>
                <div><h5 class="fw-bold mb-1">Bloqueio de quadra</h5><p class="mb-1">Society Descoberta bloqueada para manutenção das 14:00 às 16:00.</p><small class="text-muted">Hoje, 08:45</small></div>
            </article>
            <article class="notice-card">
                <span class="notice-icon"><i class="bi bi-calendar-check"></i></span>
                <div><h5 class="fw-bold mb-1">Nova reserva manual</h5><p class="mb-1">Reserva criada para Futsal Arena às 16:00.</p><small class="text-muted">Hoje, 10:20</small></div>
            </article>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    document.getElementById('btnMarcarTodas').addEventListener('click', () => {
        document.querySelectorAll('.notice-card').forEach(card => card.style.opacity = '0.55');
        esportecToast('Notificações operacionais marcadas como lidas.', 'success');
    });
</script>
</body>
</html>
