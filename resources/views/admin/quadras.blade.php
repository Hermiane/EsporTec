<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quadras - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --light:#E8F5EE; --bg:#F8FAFC; --text:#334155; }
        body { margin:0; font-family:'Poppins',sans-serif; background:var(--bg); color:var(--text); }
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
        
        .main { flex:1; margin-left:260px; padding:2rem; overflow-x:hidden; }
        .card-soft { background:white; border:0; border-radius:12px; box-shadow:0 4px 16px rgba(15,23,42,.06); }
        .court-img { height:170px; object-fit:cover; border-radius:12px 12px 0 0; }
        .badge-on { background:rgba(45,129,93,.15); color:var(--primary); }
        .badge-off { background:rgba(211,47,47,.12); color:#D32F2F; }
        .week-grid { display:grid; grid-template-columns:repeat(7,minmax(120px,1fr)); gap:.75rem; overflow-x:auto; }
        .day-box { border:1px solid #E2E8F0; border-radius:10px; padding:1rem; background:white; min-width:120px; }
        .day-box .form-check-input:checked { background-color:var(--primary); border-color:var(--primary); }
        .btn-success { background:var(--primary); border-color:var(--primary); }
        .btn-success:hover { background:var(--dark); border-color:var(--dark); }
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
            <a href="/admin/quadras" class="nav-link active"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-people"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
    </aside>

    <main class="main">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Quadras</h1>
                <p class="text-muted mb-0">Cadastre, edite horários e controle bloqueios.</p>
            </div>
            <button class="btn btn-success" id="btnNovaQuadra" data-bs-toggle="modal" data-bs-target="#modalQuadra"><i class="bi bi-plus-lg me-2"></i>Nova Quadra</button>
        </div>

        <div class="row g-4 mb-4" id="listaQuadras">
            <!-- Preenchido via JS -->
            <div class="col-lg-4"><div class="card card-soft h-100"><div class="p-4 text-center text-muted"><i class="bi bi-hourglass-spin"></i> Carregando quadras...</div></div></div>
        </div>

        <section class="card card-soft p-4 mb-4" id="secaoHorarios">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0">Horários semanais</h5>
                <select class="form-select" style="max-width:260px" id="selectQuadraHorarios">
                    <option value="">Selecione uma quadra</option>
                </select>
            </div>
            <div class="week-grid">
                @foreach (['segunda-feira' => 'Seg', 'terca-feira' => 'Ter', 'quarta-feira' => 'Qua', 'quinta-feira' => 'Qui', 'sexta-feira' => 'Sex', 'sabado' => 'Sáb', 'domingo' => 'Dom'] as $valorDia => $dia)
                    <div class="day-box">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input horario-ativo" type="checkbox" data-dia="{{ $valorDia }}" checked>
                            <label class="form-check-label fw-semibold">{{ $dia }}</label>
                        </div>
                        <label class="form-label small">Início</label>
                        <input type="time" class="form-control form-control-sm mb-2 horario-inicio" data-dia="{{ $valorDia }}" value="07:00">
                        <label class="form-label small">Fim</label>
                        <input type="time" class="form-control form-control-sm horario-fim" data-dia="{{ $valorDia }}" value="23:00">
                    </div>
                @endforeach
            </div>
            <div class="text-end mt-3">
                <button class="btn btn-success btn-sm" id="btnSalvarHorarios"><i class="bi bi-check-lg"></i> Salvar horários</button>
            </div>
        </section>

        <section class="card card-soft p-4" id="secaoBloqueios">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0">Bloqueios de quadra</h5>
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalBloqueio"><i class="bi bi-plus-lg me-2"></i>Novo bloqueio</button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Data</th><th>Quadra</th><th>Motivo</th><th>Status</th><th></th></tr></thead>
                    <tbody id="listaBloqueios">
                        <!-- Preenchido via JS -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<!-- Modal Nova Quadra -->
<div class="modal fade" id="modalQuadra" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">Nova quadra</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <input class="form-control mb-3" id="quadraNomeAdmin" placeholder="Nome da quadra">
            <div class="row g-3">
                <div class="col-md-6"><select class="form-select" id="quadraTipoAdmin"><option>Society</option><option>Futsal</option></select></div>
                <div class="col-md-6"><input class="form-control" id="quadraValorAdmin" placeholder="Valor/hora"></div>
                <div class="col-md-6"><input class="form-control" id="quadraCapacidadeAdmin" placeholder="Capacidade"></div>
                <div class="col-md-6"><select class="form-select" id="quadraCoberturaAdmin"><option>Coberta</option><option>Descoberta</option></select></div>
                <div class="col-12"><textarea class="form-control" id="quadraDescricaoAdmin" placeholder="Descrição da quadra"></textarea></div>
                <div class="col-12"><label class="form-label">Foto da quadra</label><input type="file" class="form-control" id="quadraFotoAdmin" accept="image/jpeg,image/png,image/webp"><small class="text-muted">JPG, PNG ou WebP, até 5 MB.</small></div>
            </div>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-success" id="btnSalvarQuadra">Salvar</button></div>
    </div></div>
</div>

<!-- Modal Bloqueio -->
<div class="modal fade" id="modalBloqueio" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">Novo bloqueio</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <select class="form-select mb-3" id="bloqueioQuadraAdmin"><option value="">Selecione...</option></select>
            <input type="date" class="form-control mb-3" id="bloqueioDataAdmin">
            <textarea class="form-control" rows="3" id="bloqueioMotivoAdmin" placeholder="Motivo do bloqueio"></textarea>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-success" id="btnSalvarBloqueio">Bloquear</button></div>
    </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    
    //  INTEGRAÇÃO COM API - ADMIN QUADRAS
    
    const API_BASE = '/api';
    
    let quadrasAtuais = [];
    let quadraEmEdicao = null;

    document.getElementById('btnNovaQuadra').addEventListener('click', () => {
        quadraEmEdicao = null;
        document.querySelector('#modalQuadra .modal-title').textContent = 'Nova quadra';
        ['quadraNomeAdmin', 'quadraValorAdmin', 'quadraCapacidadeAdmin', 'quadraDescricaoAdmin'].forEach(id => {
            document.getElementById(id).value = '';
        });
        document.getElementById('quadraTipoAdmin').selectedIndex = 0;
        document.getElementById('quadraCoberturaAdmin').selectedIndex = 0;
        document.getElementById('quadraFotoAdmin').value = '';
    });
    
    const MOCK_BLOQUEIOS = [
        { id: 1, data: '2026-06-22', quadra_id: 3, quadra_nome: 'Society Descoberta', motivo: 'Manutenção do gramado', status: 'bloqueada' },
        { id: 2, data: '2026-06-25', quadra_id: 1, quadra_nome: 'Futsal Arena', motivo: 'Evento interno', status: 'bloqueada' }
    ];

    //  CARREGAR QUADRAS
    async function carregarQuadras() {
        try {
            const quadras = await EsporTecApi.request(`${API_BASE}/admin/quadras`);
            
            if (!quadras || quadras.length === 0) {
                renderizarQuadras([]);
                atualizarSelects([]);
                return;
            }
            
            renderizarQuadras(quadras);
            atualizarSelects(quadras);
            quadrasAtuais = quadras;
            console.log(' Quadras carregadas da API:', quadras.length);
        } catch (error) {
            console.error('Erro ao carregar quadras:', error.message);
            renderizarQuadras([]);
            atualizarSelects([]);
            esportecToast(error.message, 'warning');
        }
    }

    function renderizarQuadras(quadras) {
        const container = document.getElementById('listaQuadras');
        container.innerHTML = '';

        if (!quadras || quadras.length === 0) {
            container.innerHTML = '<div class="col-12"><div class="card card-soft p-4 text-center text-muted">Nenhuma quadra cadastrada.</div></div>';
            return;
        }

        quadras.forEach(quadra => {
            const ativo = quadra.ativo !== false;
            const badge = ativo ? 
                `<span class="badge badge-on">Ativa</span>` : 
                `<span class="badge badge-off">Bloqueada</span>`;
            const btnToggle = ativo ?
                `<button class="btn btn-sm btn-outline-danger" data-court-action="toggle" data-id="${quadra.id}"><i class="bi bi-ban"></i> Inativar</button>` :
                `<button class="btn btn-sm btn-outline-success" data-court-action="toggle" data-id="${quadra.id}"><i class="bi bi-check2"></i> Ativar</button>`;

            container.innerHTML += `
                <div class="col-lg-4" data-quadra-id="${quadra.id}">
                    <div class="card card-soft h-100">
                        <img class="court-img" src="${quadra.foto || quadra.imagem || 'https://via.placeholder.com/900x170?text=Sem+imagem'}" alt="${quadra.nome}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="fw-bold">${quadra.nome}</h5>
                                ${badge}
                            </div>
                            <p class="text-muted small mb-2">${quadra.tipo} • ${quadra.coberta ? 'Coberta' : 'Aberta'} • ${quadra.capacidade_jogador || quadra.capacidade || 0} jogadores</p>
                            <strong class="text-success">R$ ${parseFloat(quadra.preco_hora).toFixed(2).replace('.', ',')}/hora</strong>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <button class="btn btn-sm btn-outline-success" data-court-action="editar" data-id="${quadra.id}"><i class="bi bi-pencil"></i> Editar</button>
                                <button class="btn btn-sm btn-outline-success" data-court-action="horarios" data-id="${quadra.id}"><i class="bi bi-clock"></i> Horários</button>
                                <button class="btn btn-sm btn-outline-secondary" data-court-action="bloqueios" data-id="${quadra.id}"><i class="bi bi-slash-circle"></i> Bloqueios</button>
                                ${btnToggle}
                                <button class="btn btn-sm btn-outline-danger" data-court-action="excluir" data-id="${quadra.id}"><i class="bi bi-trash"></i> Excluir</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    }

    function atualizarSelects(quadras) {
        const selects = [document.getElementById('selectQuadraHorarios'), document.getElementById('bloqueioQuadraAdmin')];
        selects.forEach(select => {
            if (!select) return;
            const firstOption = select.querySelector('option[value=""]')?.outerHTML || '<option value="">Selecione...</option>';
            select.innerHTML = firstOption;
            quadras.forEach(q => {
                select.innerHTML += `<option value="${q.id}">${q.nome}</option>`;
            });
        });
    }

    async function carregarHorariosAdmin(quadraId) {
        if (!quadraId) return;
        try {
            const horarios = await EsporTecApi.request(`${API_BASE}/admin/quadras/${quadraId}/horarios`);
            const porDia = Object.fromEntries(horarios.map(h => [h.dia_semana, h]));
            document.querySelectorAll('.horario-ativo').forEach(checkbox => {
                const horario = porDia[checkbox.dataset.dia];
                checkbox.checked = Boolean(horario?.ativo);
                document.querySelector(`.horario-inicio[data-dia="${checkbox.dataset.dia}"]`).value = (horario?.hora_inicio || '07:00').slice(0, 5);
                document.querySelector(`.horario-fim[data-dia="${checkbox.dataset.dia}"]`).value = (horario?.hora_fim || '23:00').slice(0, 5);
            });
        } catch (error) {
            esportecToast(error.message || 'Não foi possível carregar os horários.', 'warning');
        }
    }

    function renderizarBloqueios(bloqueios) {
        const lista = document.getElementById('listaBloqueios');
        lista.innerHTML = bloqueios.length ? bloqueios.map(bloqueio => `
            <tr>
                <td>${formatarData(String(bloqueio.data).slice(0, 10))}</td>
                <td>${bloqueio.quadra?.nome || 'Quadra'}</td>
                <td>${bloqueio.motivo}</td>
                <td><span class="badge badge-off">Bloqueada</span></td>
                <td><button class="btn btn-sm btn-outline-success" data-unblock="${bloqueio.id}">Desbloquear</button></td>
            </tr>`).join('') : '<tr><td colspan="5" class="text-center text-muted">Nenhum bloqueio cadastrado.</td></tr>';
    }

    async function carregarBloqueios() {
        try {
            renderizarBloqueios(await EsporTecApi.request(`${API_BASE}/admin/bloqueios-quadras`));
        } catch (error) {
            console.error('Erro ao carregar bloqueios:', error);
            renderizarBloqueios([]);
        }
    }

    //  SALVAR NOVA QUADRA
    document.getElementById('btnSalvarQuadra').addEventListener('click', async () => {
        const dadosQuadra = {
            nome: document.getElementById('quadraNomeAdmin').value.trim(),
            tipo: document.getElementById('quadraTipoAdmin').value.toLowerCase(),
            preco_hora: parseFloat(document.getElementById('quadraValorAdmin').value) || 0,
            capacidade_jogador: parseInt(document.getElementById('quadraCapacidadeAdmin').value) || 10,
            coberta: document.getElementById('quadraCoberturaAdmin').value === 'Coberta',
            descricao: document.getElementById('quadraDescricaoAdmin').value.trim(),
        };
        if (!dadosQuadra.nome) { esportecToast('Informe o nome da quadra.', 'warning'); return; }

        if (quadraEmEdicao) {
            try {
                await EsporTecApi.request(`${API_BASE}/admin/quadras/${quadraEmEdicao}`, {
                    method: 'PUT',
                    body: JSON.stringify(dadosQuadra)
                });
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalQuadra')).hide();
                esportecToast('Quadra atualizada.', 'success');
                quadraEmEdicao = null;
                await carregarQuadras();
            } catch (error) {
                esportecToast(error.message || 'Não foi possível atualizar a quadra.', 'danger');
            }
            return;
        }

        const payload = new FormData();
        payload.append('nome', dadosQuadra.nome);
        payload.append('tipo', dadosQuadra.tipo);
        payload.append('preco_hora', dadosQuadra.preco_hora);
        payload.append('capacidade_jogador', dadosQuadra.capacidade_jogador);
        payload.append('coberta', dadosQuadra.coberta ? '1' : '0');
        payload.append('descricao', dadosQuadra.descricao);
        payload.append('ativo', '1');
        const foto = document.getElementById('quadraFotoAdmin').files[0]; if (foto) payload.append('foto', foto);

        try {
            await EsporTecApi.request(`${API_BASE}/admin/quadras`, {
                method: 'POST',
                body: payload
            });
            
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalQuadra')).hide();
            esportecToast('Quadra cadastrada.', 'success');
            await carregarQuadras();
        } catch (error) {
            console.error('Erro ao salvar quadra:', error);
            esportecToast(error.message, 'danger');
        }
    });

    //  AÇÕES DOS BOTÕES (editar, horarios, bloqueios, toggle, excluir)
    document.addEventListener('click', async event => {
        const button = event.target.closest('[data-court-action]');
        if (!button) return;

        const action = button.dataset.courtAction;
        const id = button.dataset.id;

        if (action === 'editar') {
            const quadra = quadrasAtuais.find(q => q.id == id);
            if (quadra) {
                quadraEmEdicao = quadra.id;
                document.querySelector('#modalQuadra .modal-title').textContent = 'Editar quadra';
                document.getElementById('quadraNomeAdmin').value = quadra.nome;
                document.getElementById('quadraTipoAdmin').value = quadra.tipo;
                document.getElementById('quadraValorAdmin').value = quadra.preco_hora;
                document.getElementById('quadraCapacidadeAdmin').value = quadra.capacidade_jogador;
                document.getElementById('quadraCoberturaAdmin').value = quadra.coberta ? 'Coberta' : 'Descoberta';
                document.getElementById('quadraDescricaoAdmin').value = quadra.descricao || '';
            }
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalQuadra')).show();
            return;
        }

        if (action === 'horarios') {
            document.getElementById('selectQuadraHorarios').value = id;
            await carregarHorariosAdmin(id);
            document.getElementById('secaoHorarios').scrollIntoView({ behavior: 'smooth' });
            return;
        }

        if (action === 'bloqueios') {
            document.getElementById('bloqueioQuadraAdmin').value = id;
            document.getElementById('secaoBloqueios').scrollIntoView({ behavior: 'smooth' });
            return;
        }

        if (action === 'toggle') {
            if (!confirm('Alterar status desta quadra?')) return;
            
            try {
                const quadra = quadrasAtuais.find(q => q.id == id);
                if (!quadra) return;
                
                const response = await fetch(`${API_BASE}/admin/quadras/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify({ ativo: !quadra.ativo })
                });
                if (!response.ok) throw new Error('Erro');
                
                esportecToast(quadra.ativo ? 'Quadra inativada.' : 'Quadra ativada.', 'success');
                carregarQuadras();
            } catch (error) { esportecToast('Não foi possível alterar a quadra.', 'danger'); }
        }

        //  EXCLUIR QUADRA
        if (action === 'excluir') {
            if (!confirm('️ Tem certeza que deseja excluir esta quadra?\n\nEsta ação NÃO pode ser desfeita e todas as reservas associadas serão perdidas.')) return;
            
            try {
                const response = await fetch(`${API_BASE}/admin/quadras/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                });
                if (!response.ok) throw new Error('Erro ao excluir');
                
                esportecToast('Quadra excluída com sucesso.', 'success');
                carregarQuadras();
            } catch (error) { console.error('Erro ao excluir quadra:', error); esportecToast('Não foi possível excluir a quadra.', 'danger'); }
        }
    });

    //  SALVAR BLOQUEIO
    document.getElementById('btnSalvarBloqueio').addEventListener('click', async () => {
        const data = document.getElementById('bloqueioDataAdmin').value;
        const quadraId = document.getElementById('bloqueioQuadraAdmin').value;
        const motivo = document.getElementById('bloqueioMotivoAdmin').value.trim() || 'Bloqueio operacional';
        if (!data || !quadraId) { esportecToast('Preencha data e quadra.', 'warning'); return; }

        try {
            await EsporTecApi.request(`${API_BASE}/admin/bloqueios-quadras`, {
                method: 'POST',
                body: JSON.stringify({ quadras_id: Number(quadraId), data, motivo })
            });
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalBloqueio')).hide();
            await carregarBloqueios();
            esportecToast('Bloqueio registrado.', 'success');
        } catch (error) {
            esportecToast(error.message || 'Não foi possível registrar o bloqueio.', 'danger');
        }
    });

    // Desbloquear
    document.addEventListener('click', async event => {
        const btn = event.target.closest('[data-unblock]');
        if (btn) {
            try {
                await EsporTecApi.request(`${API_BASE}/admin/bloqueios-quadras/${btn.dataset.unblock}`, { method: 'DELETE' });
                await carregarBloqueios();
                esportecToast('Bloqueio removido.', 'success');
            } catch (error) {
                esportecToast(error.message || 'Não foi possível remover o bloqueio.', 'danger');
            }
        }
    });

    // Salvar horários
    document.getElementById('btnSalvarHorarios')?.addEventListener('click', async () => {
        const quadraId = document.getElementById('selectQuadraHorarios').value;
        if (!quadraId) { esportecToast('Selecione uma quadra.', 'warning'); return; }
        const horarios = [...document.querySelectorAll('.horario-ativo')].map(checkbox => ({
            dia_semana: checkbox.dataset.dia,
            ativo: checkbox.checked,
            hora_inicio: document.querySelector(`.horario-inicio[data-dia="${checkbox.dataset.dia}"]`).value,
            hora_fim: document.querySelector(`.horario-fim[data-dia="${checkbox.dataset.dia}"]`).value,
        }));
        try {
            await EsporTecApi.request(`${API_BASE}/admin/quadras/${quadraId}/horarios`, {
                method: 'PUT', body: JSON.stringify({ horarios })
            });
            esportecToast('Horários salvos.', 'success');
        } catch (error) {
            esportecToast(error.message || 'Não foi possível salvar os horários.', 'danger');
        }
    });

    document.getElementById('selectQuadraHorarios').addEventListener('change', event => carregarHorariosAdmin(event.target.value));

    function formatarData(dataISO) {
        if (!dataISO) return '-';
        const [ano, mes, dia] = dataISO.split('-');
        return `${dia}/${mes}/${ano}`;
    }

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        console.log(' Carregando quadras...');
        carregarQuadras();
        carregarBloqueios();
    });
</script>
</body>
</html>
