<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notificações - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --dark:#1F5C42; --primary:#2D815D; --light:#E8F5EE; --bg:#F8FAFC; }
        body { margin:0; font-family:'Poppins',sans-serif; background:var(--bg); color:#334155; }
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:260px; background:var(--dark); color:white; padding:1.5rem; flex-shrink:0; }
        .sidebar-brand { color:white; font-size:1.5rem; font-weight:700; text-decoration:none; display:block; margin-bottom:2rem; }
        .nav-link { color:rgba(255,255,255,.75); border-radius:8px; padding:.75rem 1rem; margin-bottom:.35rem; display:flex; gap:.75rem; align-items:center; text-decoration:none; }
        .nav-link:hover,.nav-link.active { background:rgba(255,255,255,.12); color:white; }
        .main { flex:1; padding:2rem; }
        .notice-card { background:white; border-radius:12px; padding:1.1rem; box-shadow:0 4px 16px rgba(15,23,42,.06); display:flex; gap:1rem; align-items:flex-start; margin-bottom:1rem; transition:opacity 0.2s; }
        .notice-card.lida { opacity: 0.55; }
        .notice-icon { width:44px; height:44px; border-radius:12px; background:var(--light); color:var(--primary); display:inline-flex; align-items:center; justify-content:center; font-size:1.35rem; flex:0 0 44px; }
        @media (max-width: 992px) { .layout { display:block; } .sidebar { width:100%; } .main { padding:1rem; } }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <small class="opacity-75">Admin da arena</small></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-people"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link active"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
    </aside>
    <main class="main">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Notificações administrativas</h1>
                <p class="text-muted mb-0">Alertas operacionais, pagamentos e mensagens importantes da arena.</p>
            </div>
            <button class="btn btn-success" id="btnMarcarTodas"><i class="bi bi-check2-all me-2"></i>Marcar todas como lidas</button>
        </div>
        <section id="adminNotices">
            <!-- Preenchido via JS -->
            <div class="text-center text-muted py-4"><i class="bi bi-hourglass-spin me-2"></i>Carregando notificações...</div>
        </section>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    
    //  INTEGRAÇÃO COM API - ADMIN NOTIFICAÇÕES
    
    const API_BASE = '/api';
    
    // Mock data para fallback
    const MOCK_NOTIFICACOES = [
        { id: 1, tipo: 'pagamento', titulo: 'Pagamento pendente', mensagem: 'Reserva #1235 aguarda conferência de PIX.', tempo: 'Agora há pouco', lida: false, icone: 'bi-cash-coin' },
        { id: 2, tipo: 'reserva', titulo: 'Nova reserva manual', mensagem: 'Funcionário criou reserva para Society Premium às 19:00.', tempo: 'Hoje, 10:20', lida: false, icone: 'bi-calendar-check' },
        { id: 3, tipo: 'manutencao', titulo: 'Manutenção registrada', mensagem: 'Society Descoberta precisa de revisão no gramado.', tempo: 'Hoje, 08:45', lida: false, icone: 'bi-tools' },
        { id: 4, tipo: 'cliente', titulo: 'Novo cliente cadastrado', mensagem: 'Maria Oliveira completou o cadastro na plataforma.', tempo: 'Ontem, 16:30', lida: true, icone: 'bi-person-plus' },
        { id: 5, tipo: 'sistema', titulo: 'Backup realizado', mensagem: 'Backup automático concluído com sucesso.', tempo: 'Ontem, 02:00', lida: true, icone: 'bi-database-check' }
    ];

    //  CARREGAR NOTIFICAÇÕES - API: GET /api/admin/notificacoes
    async function carregarNotificacoes() {
        try {
            const response = await fetch(`${API_BASE}/admin/notificacoes`);
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            const notificacoes = await response.json();
            
            if (!notificacoes || notificacoes.length === 0) {
                console.log(' API retornou vazio, usando mock');
                renderizarNotificacoes(MOCK_NOTIFICACOES);
                return;
            }
            
            renderizarNotificacoes(notificacoes);
            console.log(' Notificações carregadas:', notificacoes.length);
        } catch (error) {
            console.log(' Erro na API, usando mock:', error.message);
            renderizarNotificacoes(MOCK_NOTIFICACOES);
        }
    }

    function renderizarNotificacoes(notificacoes) {
        const container = document.getElementById('adminNotices');
        container.innerHTML = '';

        if (!notificacoes || notificacoes.length === 0) {
            container.innerHTML = '<div class="text-center text-muted py-4"><i class="bi bi-bell-slash me-2"></i>Nenhuma notificação nova.</div>';
            return;
        }

        // Ordena: não lidas primeiro
        notificacoes.sort((a, b) => (a.lida === b.lida ? 0 : a.lida ? 1 : -1));

        notificacoes.forEach(notif => {
            container.innerHTML += `
                <article class="notice-card ${notif.lida ? 'lida' : ''}" data-notif-id="${notif.id}">
                    <span class="notice-icon"><i class="bi bi-${notif.icone}"></i></span>
                    <div>
                        <h5 class="fw-bold mb-1">${notif.titulo}</h5>
                        <p class="mb-1">${notif.mensagem}</p>
                        <small class="text-muted">${notif.tempo}</small>
                    </div>
                </article>
            `;
        });
    }

    //  MARCAR TODAS COMO LIDAS - API: PATCH /api/admin/notificacoes/marcar-todas
    document.getElementById('btnMarcarTodas').addEventListener('click', async () => {
        try {
            const response = await fetch(`${API_BASE}/admin/notificacoes/marcar-todas`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
            });
            if (!response.ok) throw new Error('Erro');
            
            esportecToast('Notificações marcadas como lidas.', 'success');
            carregarNotificacoes();
        } catch (error) {
            console.log(' Fallback: marcando visualmente');
            // Fallback visual
            document.querySelectorAll('.notice-card:not(.lida)').forEach(card => {
                card.classList.add('lida');
            });
            esportecToast('Notificações marcadas como lidas (simulado).', 'success');
        }
    });

    //  MARCAR INDIVIDUAL COMO LIDA (ao clicar no card)
    document.getElementById('adminNotices').addEventListener('click', async event => {
        const card = event.target.closest('.notice-card');
        if (!card || card.classList.contains('lida')) return;

        const notifId = card.dataset.notifId;
        
        try {
            const response = await fetch(`${API_BASE}/admin/notificacoes/${notifId}/ler`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
            });
            if (!response.ok) throw new Error('Erro');
            
            card.classList.add('lida');
        } catch (error) {
            // Fallback visual
            card.classList.add('lida');
            console.log(' Notificação marcada como lida (simulado)');
        }
    });

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        carregarNotificacoes();
    });
</script>
</body>
</html>