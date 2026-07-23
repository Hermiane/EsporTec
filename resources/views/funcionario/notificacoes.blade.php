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
        
        
        .sidebar {
            width:250px;
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
        .sidebar-brand small { display:block; font-size:0.75rem; opacity:0.7; margin-top:-0.2rem; font-weight:400; }
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
        .nav-link:hover,.nav-link.active {
            background:rgba(255,255,255,0.15);
            color:white;
            transform:translateX(5px);
        }
        
        .main { flex:1; margin-left:250px; padding:2rem; }
        
        
        .page-header h1 {
            font-size: 1.3rem !important;
            font-weight: 600 !important;
            margin-bottom: 0.2rem !important;
        }
        .page-header p {
            font-size: 0.9rem !important;
            color: #64748B !important;
            margin: 0 !important;
        }
        
        .notice-card {
            background:white;
            border-radius:12px;
            padding:1rem;
            box-shadow:0 4px 16px rgba(15,23,42,.06);
            display:flex;
            gap:1rem;
            margin-bottom:1rem;
            align-items:flex-start;
            transition:opacity 0.2s;
        }
        .notice-card.lida { opacity: 0.55; }
        .notice-icon {
            width:42px;
            height:42px;
            border-radius:12px;
            background:var(--light);
            color:var(--primary);
            display:inline-flex;
            align-items:center;
            justify-content:center;
            font-size:1.25rem;
            flex:0 0 42px;
        }
        @media (max-width: 992px) {
            .layout { display:block; }
            .sidebar { width:100%; position:relative; height:auto; }
            .main { margin-left:0; padding:1rem; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/painel-funcionario" class="sidebar-brand">
            <i class="bi bi-trophy"></i>
            <div>
                EsporTec
                <small>Área do Funcionário</small>
            </div>
        </a>
        <nav>
            <a href="/painel-funcionario" class="nav-link"><i class="bi bi-grid"></i> Painel</a>
            <a href="/funcionario/agenda" class="nav-link"><i class="bi bi-calendar-week"></i> Agenda</a>
            <a href="/funcionario/notificacoes" class="nav-link active"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/funcionario/perfil" class="nav-link"><i class="bi bi-person"></i> Perfil</a>
        </nav>
    </aside>
    <main class="main">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 page-header">
            <div>
                <h1 class="fw-bold mb-1"><i class="bi bi-bell me-2"></i>Notificações</h1>
                <p class="text-muted mb-0">Avisos de agenda, pagamentos e manutenção.</p>
            </div>
            <button class="btn btn-success btn-sm" id="btnMarcarTodas"><i class="bi bi-check2-all me-1"></i>Marcar como lidas</button>
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
        document.querySelectorAll('.notice-card').forEach(card => card.classList.add('lida'));
        esportecToast('Notificações marcadas como lidas.', 'success');
    });
</script>
</body>
</html>