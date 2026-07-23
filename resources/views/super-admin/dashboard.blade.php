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
            <button type="button" class="nav-button" data-scroll-target="faturamento-arenas"><i class="bi bi-cash-stack"></i> Faturamento por arena</button>
            <button type="button" class="nav-button" data-scroll-target="admins"><i class="bi bi-person-gear"></i> Admins das arenas</button>
            <button type="button" class="nav-button" data-scroll-target="super-administradores"><i class="bi bi-shield-check"></i> Super administradores</button>
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
                <div class="stat-value" id="totalArenas">-</div>
                <small class="text-success" id="resumoArenas">Carregando...</small>
            </article>
            <article class="stat-card">
                <span class="stat-icon"><i class="bi bi-person-badge"></i></span>
                <div class="stat-label">Admins de arena</div>
                <div class="stat-value" id="totalAdmins">-</div>
                <small class="text-muted">Proprietários e gestores</small>
            </article>
            <article class="stat-card">
                <span class="stat-icon"><i class="bi bi-cash-stack"></i></span>
                <div class="stat-label">Faturamento confirmado</div>
                <div class="stat-value" id="faturamentoConfirmado">R$ 0,00</div>
                <small class="text-success">Pagamentos confirmados nas arenas</small>
            </article>
            <article class="stat-card">
                <span class="stat-icon"><i class="bi bi-life-preserver"></i></span>
                <div class="stat-label">Chamados abertos</div>
                <div class="stat-value" id="chamadosAbertos">-</div>
                <small class="text-warning">Chamados de suporte em aberto</small>
            </article>
        </div>

        <section class="section-card" id="faturamento-arenas">
            <div class="mb-3">
                <h5 class="fw-bold mb-1">Faturamento confirmado por arena</h5>
                <p class="text-muted mb-0">Soma dos pagamentos confirmados, separada por arena cadastrada.</p>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Arena</th><th>Quadras ativas</th><th>Reservas</th><th>Faturamento confirmado</th><th>Situação</th></tr></thead>
                    <tbody id="faturamentoArenasBody">
                        <tr><td colspan="5" class="text-center text-muted">Carregando faturamento...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="section-card" id="arenas">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Solicitações e arenas da plataforma</h5>
                    <p class="text-muted mb-0">Solicitações em análise exibem as ações de aprovar ou recusar.</p>
                </div>
                <button class="btn btn-outline-success" id="btnExportarArenas"><i class="bi bi-download me-2"></i>Exportar</button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Arena</th><th>Proprietário/Admin</th><th>Localização</th><th>Operação</th><th>Faturamento</th><th>Status</th><th>Ações</th></tr></thead>
                    <tbody id="arenasBody"><tr><td colspan="7" class="text-center text-muted">Carregando arenas...</td></tr></tbody>
                </table>
            </div>
        </section>

        <section class="section-card" id="admins">
            <h5 class="fw-bold mb-3">Admins das arenas</h5>
            <div class="row g-3" id="adminsBody"><p class="text-muted mb-0">Carregando administradores...</p></div>
        </section>

        <section class="section-card" id="super-administradores">
            <div class="mb-3">
                <h5 class="fw-bold mb-1">Super administradores</h5>
                <p class="text-muted mb-0">Busque uma conta já cadastrada pelo e-mail para conceder acesso global à plataforma.</p>
            </div>
            <form id="formBuscarSuperAdmin" class="row g-2 align-items-end mb-4">
                <div class="col-md-8">
                    <label for="emailBuscaSuperAdmin" class="form-label">E-mail do usuário</label>
                    <input type="email" class="form-control" id="emailBuscaSuperAdmin" required autocomplete="off" placeholder="usuario@exemplo.com">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-outline-success w-100" type="submit"><i class="bi bi-search me-2"></i>Buscar usuário</button>
                </div>
            </form>
            <div id="resultadoBuscaSuperAdmin" class="mb-4"></div>
            <h6 class="fw-bold mb-3">Super administradores cadastrados</h6>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Nome</th><th>E-mail</th><th>Cargo</th><th>Promovido por</th><th>Status</th></tr></thead>
                    <tbody id="superAdminsBody"><tr><td colspan="5" class="text-center text-muted">Carregando...</td></tr></tbody>
                </table>
            </div>
        </section>

        <section class="section-card" id="logs">
            <h5 class="fw-bold mb-3">Logs globais da plataforma</h5>
            <div class="list-group list-group-flush" id="logsBody"><div class="list-group-item px-0 text-muted">Carregando atividades...</div></div>
        </section>
    </main>
</div>

<div class="modal fade" id="modalDetalhesArena" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-building me-2"></i>Detalhes da arena</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="detalhesArenaBody"></div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-outline-success" id="linkArenaPublica" href="#" target="_blank" rel="noopener">Abrir página pública</a>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    document.querySelectorAll('[data-scroll-target]').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('[data-scroll-target]').forEach(item => item.classList.remove('active'));
            button.classList.add('active');
            document.getElementById(button.dataset.scrollTarget).scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    document.getElementById('btnNovaArena').addEventListener('click', () => window.location.href = '/cadastrar-arena');

    document.getElementById('btnExportarArenas').addEventListener('click', () => window.print());

    const statusArena = { pendente: ['dot-yellow', 'Em análise'], aprovada: ['dot-green', 'Ativa'], recusada: ['dot-red', 'Recusada'] };
    let arenasAtuais = [];
    function escapar(valor = '') { const elemento = document.createElement('span'); elemento.textContent = valor; return elemento.innerHTML; }
    function renderizarArenas(arenas) {
        arenasAtuais = arenas;
        document.getElementById('totalArenas').textContent = arenas.length;
        const pendentes = arenas.filter(arena => arena.status_aprovacao === 'pendente').length;
        const ativas = arenas.filter(arena => arena.status_aprovacao === 'aprovada' && arena.ativo).length;
        document.getElementById('resumoArenas').textContent = `${ativas} ativa${ativas !== 1 ? 's' : ''} e ${pendentes} em análise`;
        document.getElementById('arenasBody').innerHTML = arenas.length ? arenas.map(arena => {
            const status = !arena.ativo && arena.status_aprovacao === 'aprovada' ? ['dot-red', 'Inativa'] : (statusArena[arena.status_aprovacao] || statusArena.pendente);
            const dono = arena.criado_por?.nome_completo || 'Não informado';
            const excluir = `<button class="btn btn-sm btn-outline-danger ms-1" data-action="excluir" data-id="${arena.id}">Excluir</button>`;
            const acoes = arena.status_aprovacao === 'pendente' ? `<button class="btn btn-sm btn-success me-1" data-action="aprovar" data-id="${arena.id}">Aprovar</button><button class="btn btn-sm btn-outline-danger" data-action="recusar" data-id="${arena.id}">Recusar</button>${excluir}` : arena.status_aprovacao === 'aprovada' ? `<button class="btn btn-sm ${arena.ativo ? 'btn-outline-danger' : 'btn-success'}" data-action="ativacao" data-id="${arena.id}" data-ativo="${arena.ativo ? '1' : '0'}">${arena.ativo ? 'Inativar' : 'Ativar'}</button>${excluir}` : excluir;
            const localizacao = [arena.bairro, arena.cidade, arena.estado].filter(Boolean).join(' - ') || 'Não informada';
            return `<tr>
                <td class="fw-semibold">${escapar(arena.nome)}<small class="d-block text-muted">${arena.quadras_ativas_count || 0} de ${arena.quadras_count || 0} quadra(s) ativa(s)</small></td>
                <td>${escapar(dono)}<small class="d-block text-muted">${escapar(arena.email)}</small></td>
                <td>${escapar(localizacao)}</td>
                <td>${arena.reservas_count || 0} reserva(s)</td>
                <td class="fw-semibold text-success">${moeda(arena.faturamento_confirmado)}</td>
                <td><span class="status-dot ${status[0]}"></span>${status[1]}</td>
                <td><button class="btn btn-sm btn-outline-success me-1" data-detalhes-arena="${arena.id}">Detalhes</button>${acoes}</td>
            </tr>`;
        }).join('') : '<tr><td colspan="7" class="text-center text-muted">Nenhuma arena cadastrada.</td></tr>';
    }
    function moeda(valor) { return Number(valor || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); }
    function formatarData(data) { return data ? new Date(data).toLocaleString('pt-BR', { dateStyle: 'short', timeStyle: 'short' }) : ''; }
    function renderizarResumo(dados) {
        const { metricas, admins, logs, faturamento_por_arena } = dados;
        document.getElementById('totalAdmins').textContent = metricas.admins_ativos;
        document.getElementById('faturamentoConfirmado').textContent = moeda(metricas.faturamento_confirmado);
        document.getElementById('chamadosAbertos').textContent = metricas.chamados_abertos;
        document.getElementById('faturamentoArenasBody').innerHTML = faturamento_por_arena.length
            ? faturamento_por_arena.map(arena => {
                const situacao = arena.status_aprovacao === 'pendente' ? 'Em análise' : arena.status_aprovacao === 'recusada' ? 'Recusada' : arena.ativa ? 'Ativa' : 'Inativa';
                return `<tr>
                    <td class="fw-semibold">${escapar(arena.arena_nome)}</td>
                    <td>${arena.quadras_ativas_count} de ${arena.quadras_count}</td>
                    <td>${arena.reservas_count}</td>
                    <td class="fw-bold text-success">${moeda(arena.faturamento_confirmado)}</td>
                    <td>${situacao}</td>
                </tr>`;
            }).join('')
            : '<tr><td colspan="5" class="text-center text-muted">Nenhuma arena cadastrada.</td></tr>';
        document.getElementById('adminsBody').innerHTML = admins.length ? admins.map(admin => `<div class="col-md-4"><div class="p-3 rounded border"><div class="fw-bold">${escapar(admin.usuario?.nome_completo || 'Usuário')}</div><small class="text-muted d-block">${escapar(admin.cargo)} - ${escapar(admin.arena?.nome || 'Arena')}</small><span class="badge bg-success mt-2">Ativo</span></div></div>`).join('') : '<p class="text-muted mb-0">Nenhum administrador de arena ativo.</p>';
        document.getElementById('logsBody').innerHTML = logs.length ? logs.map(log => `<div class="list-group-item px-0 d-flex justify-content-between flex-wrap gap-2"><span>${escapar(log.descricao)}</span><small class="text-muted">${formatarData(log.created_at)}</small></div>`).join('') : '<div class="list-group-item px-0 text-muted">Nenhuma atividade registrada.</div>';
    }
    async function carregarPainel() {
        try {
            const [dados, arenas, superAdmins] = await Promise.all([
                EsporTecApi.request('/api/super-admin/dashboard'),
                EsporTecApi.request('/api/super-admin/arenas'),
                EsporTecApi.request('/api/super-admin/super-administradores')
            ]);
            renderizarResumo(dados);
            renderizarArenas(arenas);
            renderizarSuperAdmins(superAdmins);
        } catch (erro) {
            document.getElementById('arenasBody').innerHTML = `<tr><td colspan="7" class="text-center text-danger">${escapar(erro.message)}</td></tr>`;
            setTimeout(() => window.location.replace('/painel'), 600);
        }
    }
    function renderizarSuperAdmins(superAdmins) {
        document.getElementById('superAdminsBody').innerHTML = superAdmins.length
            ? superAdmins.map(item => `<tr>
                <td class="fw-semibold">${escapar(item.nome || 'Usuário')}</td>
                <td>${escapar(item.email || '')}</td>
                <td>${escapar(item.cargo)}</td>
                <td>${escapar(item.promovido_por || 'Sistema')}</td>
                <td><span class="badge ${item.ativo ? 'bg-success' : 'bg-secondary'}">${item.ativo ? 'Ativo' : 'Inativo'}</span></td>
            </tr>`).join('')
            : '<tr><td colspan="5" class="text-center text-muted">Nenhum super administrador cadastrado.</td></tr>';
    }
    document.getElementById('formBuscarSuperAdmin').addEventListener('submit', async event => {
        event.preventDefault();
        const resultado = document.getElementById('resultadoBuscaSuperAdmin');
        const email = document.getElementById('emailBuscaSuperAdmin').value.trim();
        resultado.innerHTML = '<div class="text-muted">Buscando usuário...</div>';
        try {
            const usuario = await EsporTecApi.request(`/api/super-admin/usuarios/buscar?email=${encodeURIComponent(email)}`);
            resultado.innerHTML = `<div class="border rounded-3 p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <strong>${escapar(usuario.nome)}</strong>
                        <small class="d-block text-muted">${escapar(usuario.email)}</small>
                    </div>
                    ${usuario.ja_super_admin
                        ? '<span class="badge bg-success">Já é super administrador</span>'
                        : usuario.conta_ativa
                            ? `<button type="button" class="btn btn-success" data-promover-super-admin="${usuario.id}"><i class="bi bi-shield-plus me-2"></i>Promover</button>`
                            : '<span class="badge bg-warning text-dark">Conta inativa</span>'}
                </div>
            </div>`;
        } catch (erro) {
            resultado.innerHTML = `<div class="alert alert-warning mb-0">${escapar(erro.message)}</div>`;
        }
    });
    document.addEventListener('click', async event => {
        const botao = event.target.closest('[data-promover-super-admin]');
        if (!botao) return;
        const cargo = prompt('Informe o cargo deste super administrador:', 'Super Administrador');
        if (!cargo) return;
        if (!confirm('Confirmar acesso global de super administrador para este usuário?')) return;
        try {
            botao.disabled = true;
            const resposta = await EsporTecApi.request('/api/super-admin/super-administradores', {
                method: 'POST',
                body: JSON.stringify({ usuario_id: Number(botao.dataset.promoverSuperAdmin), cargo })
            });
            esportecToast(resposta.message, 'success');
            document.getElementById('resultadoBuscaSuperAdmin').innerHTML = '';
            document.getElementById('emailBuscaSuperAdmin').value = '';
            carregarPainel();
        } catch (erro) {
            esportecToast(erro.message, 'warning');
            botao.disabled = false;
        }
    });
    document.addEventListener('click', event => {
        const botao = event.target.closest('[data-detalhes-arena]');
        if (!botao) return;
        const arena = arenasAtuais.find(item => item.id == botao.dataset.detalhesArena);
        if (!arena) return;
        const endereco = [arena.logradouro, arena.numero, arena.bairro, arena.cidade, arena.estado].filter(Boolean).join(', ');
        const situacao = arena.status_aprovacao === 'pendente' ? 'Em análise' : arena.status_aprovacao === 'recusada' ? 'Recusada' : arena.ativo ? 'Ativa' : 'Inativa';
        const itens = [
            ['Arena', arena.nome],
            ['Proprietário', arena.criado_por?.nome_completo || 'Não informado'],
            ['E-mail', arena.email || 'Não informado'],
            ['Telefone', arena.telefone || 'Não informado'],
            ['Endereço', endereco || 'Não informado'],
            ['CNPJ', arena.cnpj || 'Não informado'],
            ['Quadras', `${arena.quadras_ativas_count || 0} ativas de ${arena.quadras_count || 0}`],
            ['Reservas', arena.reservas_count || 0],
            ['Faturamento confirmado', moeda(arena.faturamento_confirmado)],
            ['Situação', situacao],
        ];
        document.getElementById('detalhesArenaBody').innerHTML = itens.map(([rotulo, valor]) => `
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 h-100">
                    <small class="text-muted d-block">${rotulo}</small>
                    <strong>${escapar(String(valor))}</strong>
                </div>
            </div>
        `).join('');
        document.getElementById('linkArenaPublica').href = `/arenas/${arena.id}/quadras`;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetalhesArena')).show();
    });
    document.addEventListener('click', async event => {
        const botao = event.target.closest('[data-action]'); if (!botao) return;
        const { action, id } = botao.dataset; let body;
        if (action === 'ativacao' && !confirm(botao.dataset.ativo === '1' ? 'Inativar esta arena? Ela deixará de aparecer para clientes.' : 'Ativar esta arena novamente?')) return;
        if (action === 'excluir' && !confirm('Excluir permanentemente esta arena? Essa ação não pode ser desfeita.')) return;
        if (action === 'recusar') { const motivo = prompt('Informe o motivo da recusa:'); if (!motivo) return; body = JSON.stringify({ motivo_recusa: motivo }); }
        try { botao.disabled = true; const rota = action === 'excluir' ? `/api/super-admin/arenas/${id}` : `/api/super-admin/arenas/${id}/${action}`; const resposta = await EsporTecApi.request(rota, { method: action === 'excluir' ? 'DELETE' : 'PATCH', body }); const mensagem = action === 'aprovar' ? (resposta.email_enviado ? 'Arena aprovada e e-mail de confirmação enviado ao proprietário.' : 'Arena aprovada, mas não foi possível enviar o e-mail. Verifique o SMTP.') : action === 'recusar' ? 'Arena recusada com sucesso.' : action === 'excluir' ? 'Arena excluída.' : 'Status da arena atualizado.'; esportecToast(mensagem, action === 'aprovar' && !resposta.email_enviado ? 'warning' : 'success'); carregarPainel(); }
        catch (erro) { esportecToast(erro.message, 'danger'); } finally { botao.disabled = false; }
    });
    carregarPainel();
</script>
</body>
</html>
