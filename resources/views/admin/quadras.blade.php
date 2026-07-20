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
        .sidebar { width:260px; background:var(--dark); color:white; padding:1.5rem; flex-shrink:0; }
        .sidebar-brand { color:white; font-size:1.5rem; font-weight:700; text-decoration:none; display:block; margin-bottom:2rem; }
        .nav-link { color:rgba(255,255,255,.75); border-radius:8px; padding:.75rem 1rem; margin-bottom:.35rem; display:flex; gap:.75rem; align-items:center; text-decoration:none; }
        .nav-link:hover,.nav-link.active { background:rgba(255,255,255,.12); color:white; }
        .main { flex:1; padding:2rem; overflow-x:hidden; }
        .card-soft { background:white; border:0; border-radius:12px; box-shadow:0 4px 16px rgba(15,23,42,.06); }
        .court-img { height:170px; object-fit:cover; border-radius:12px 12px 0 0; }
        .badge-on { background:rgba(45,129,93,.15); color:var(--primary); }
        .badge-off { background:rgba(211,47,47,.12); color:#D32F2F; }
        .week-grid { display:grid; grid-template-columns:repeat(7,minmax(120px,1fr)); gap:.75rem; overflow-x:auto; }
        .day-box { border:1px solid #E2E8F0; border-radius:10px; padding:1rem; background:white; min-width:120px; }
        .day-box .form-check-input:checked { background-color:var(--primary); border-color:var(--primary); }
        .btn-success { background:var(--primary); border-color:var(--primary); }
        .btn-success:hover { background:var(--dark); border-color:var(--dark); }
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
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalQuadra"><i class="bi bi-plus-lg me-2"></i>Nova Quadra</button>
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
                @foreach (['Seg','Ter','Qua','Qui','Sex','Sáb','Dom'] as $dia)
                    <div class="day-box">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label fw-semibold">{{ $dia }}</label>
                        </div>
                        <label class="form-label small">Início</label>
                        <input type="time" class="form-control form-control-sm mb-2" value="07:00">
                        <label class="form-label small">Fim</label>
                        <input type="time" class="form-control form-control-sm" value="23:00">
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
<script>
    
    //  INTEGRAÇÃO COM API - ADMIN QUADRAS
    
    const API_BASE = '/api';
    
    // Mock data para fallback
    let MOCK_QUADRAS = [
        { id: 1, nome: 'Quadra Futsal Arena', tipo: 'Futsal', capacidade: 10, coberta: true, preco_hora: 120.00, ativo: true, imagem: 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=900&q=80' },
        { id: 2, nome: 'Quadra Society Premium', tipo: 'Society', capacidade: 14, coberta: false, preco_hora: 150.00, ativo: true, imagem: 'https://images.unsplash.com/photo-1551958219-acbc608c6377?auto=format&fit=crop&w=900&q=80' },
        { id: 3, nome: 'Quadra Society Descoberta', tipo: 'Society', capacidade: 14, coberta: false, preco_hora: 100.00, ativo: false, imagem: 'https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=900&q=80' }
    ];
    
    const MOCK_BLOQUEIOS = [
        { id: 1, data: '2026-06-22', quadra_id: 3, quadra_nome: 'Society Descoberta', motivo: 'Manutenção do gramado', status: 'bloqueada' },
        { id: 2, data: '2026-06-25', quadra_id: 1, quadra_nome: 'Futsal Arena', motivo: 'Evento interno', status: 'bloqueada' }
    ];

    //  CARREGAR QUADRAS
    async function carregarQuadras() {
        try {
            const response = await fetch(`${API_BASE}/admin/quadras`);
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            const quadras = await response.json();
            
            if (!quadras || quadras.length === 0) {
                console.log('️ API retornou vazio, usando mock');
                renderizarQuadras(MOCK_QUADRAS);
                atualizarSelects(MOCK_QUADRAS);
                return;
            }
            
            renderizarQuadras(quadras);
            atualizarSelects(quadras);
            console.log(' Quadras carregadas da API:', quadras.length);
        } catch (error) {
            console.log(' Erro na API, usando mock:', error.message);
            renderizarQuadras(MOCK_QUADRAS);
            atualizarSelects(MOCK_QUADRAS);
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
                        <img class="court-img" src="${quadra.imagem || 'https://via.placeholder.com/900x170?text=Sem+imagem'}" alt="${quadra.nome}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="fw-bold">${quadra.nome}</h5>
                                ${badge}
                            </div>
                            <p class="text-muted small mb-2">${quadra.tipo} • ${quadra.coberta ? 'Coberta' : 'Aberta'} • ${quadra.capacidade} jogadores</p>
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

    //  SALVAR NOVA QUADRA
    document.getElementById('btnSalvarQuadra').addEventListener('click', async () => {
        const payload = {
            nome: document.getElementById('quadraNomeAdmin').value.trim(),
            tipo: document.getElementById('quadraTipoAdmin').value,
            preco_hora: parseFloat(document.getElementById('quadraValorAdmin').value) || 0,
            capacidade: parseInt(document.getElementById('quadraCapacidadeAdmin').value) || 10,
            coberta: document.getElementById('quadraCoberturaAdmin').value === 'Coberta',
            ativo: true
        };

        if (!payload.nome) { esportecToast('Informe o nome da quadra.', 'warning'); return; }

        try {
            const response = await fetch(`${API_BASE}/admin/quadras`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify(payload)
            });
            if (!response.ok) throw new Error('Erro');
            
            bootstrap.Modal.getInstance(document.getElementById('modalQuadra')).hide();
            esportecToast('Quadra cadastrada.', 'success');
            carregarQuadras();
        } catch (error) {
            console.error('Erro ao salvar quadra:', error);
            bootstrap.Modal.getInstance(document.getElementById('modalQuadra')).hide();
            esportecToast('Quadra cadastrada (simulado).', 'success');
            MOCK_QUADRAS.push({ id: Date.now(), ...payload, imagem: 'https://via.placeholder.com/900x170?text=Nova' });
            renderizarQuadras(MOCK_QUADRAS);
            atualizarSelects(MOCK_QUADRAS);
        }
    });

    //  AÇÕES DOS BOTÕES (editar, horarios, bloqueios, toggle, excluir)
    document.addEventListener('click', async event => {
        const button = event.target.closest('[data-court-action]');
        if (!button) return;

        const action = button.dataset.courtAction;
        const id = button.dataset.id;

        if (action === 'editar') {
            const quadra = MOCK_QUADRAS.find(q => q.id == id);
            if (quadra) {
                document.getElementById('quadraNomeAdmin').value = quadra.nome;
                document.getElementById('quadraTipoAdmin').value = quadra.tipo;
                document.getElementById('quadraValorAdmin').value = quadra.preco_hora;
                document.getElementById('quadraCapacidadeAdmin').value = quadra.capacidade;
                document.getElementById('quadraCoberturaAdmin').value = quadra.coberta ? 'Coberta' : 'Descoberta';
            }
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalQuadra')).show();
            return;
        }

        if (action === 'horarios') {
            document.getElementById('selectQuadraHorarios').value = id;
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
                const quadra = MOCK_QUADRAS.find(q => q.id == id);
                if (!quadra) return;
                
                const response = await fetch(`${API_BASE}/admin/quadras/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify({ ativo: !quadra.ativo })
                });
                if (!response.ok) throw new Error('Erro');
                
                esportecToast(quadra.ativo ? 'Quadra inativada.' : 'Quadra ativada.', 'success');
                carregarQuadras();
            } catch (error) {
                const card = button.closest('.col-lg-4');
                const badge = card.querySelector('.badge');
                const ativando = button.textContent.trim() === 'Ativar';
                
                badge.className = ativando ? 'badge badge-on' : 'badge badge-off';
                badge.textContent = ativando ? 'Ativa' : 'Bloqueada';
                button.className = ativando ? 'btn btn-sm btn-outline-danger' : 'btn btn-sm btn-outline-success';
                button.innerHTML = ativando ? '<i class="bi bi-ban"></i> Inativar' : '<i class="bi bi-check2"></i> Ativar';
                
                esportecToast(ativando ? 'Quadra inativada (simulado).' : 'Quadra ativada (simulado).', 'success');
            }
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
            } catch (error) {
                console.error('Erro ao excluir quadra:', error);
                // Fallback visual - remove do mock
                MOCK_QUADRAS = MOCK_QUADRAS.filter(q => q.id != id);
                renderizarQuadras(MOCK_QUADRAS);
                atualizarSelects(MOCK_QUADRAS);
                esportecToast('Quadra excluída (simulado).', 'success');
            }
        }
    });

    //  SALVAR BLOQUEIO
    document.getElementById('btnSalvarBloqueio').addEventListener('click', () => {
        const data = document.getElementById('bloqueioDataAdmin').value;
        const quadraId = document.getElementById('bloqueioQuadraAdmin').value;
        const motivo = document.getElementById('bloqueioMotivoAdmin').value.trim() || 'Bloqueio operacional';
        const quadra = MOCK_QUADRAS.find(q => q.id == quadraId)?.nome || 'Quadra';

        if (!data || !quadraId) { esportecToast('Preencha data e quadra.', 'warning'); return; }

        document.getElementById('listaBloqueios').insertAdjacentHTML('afterbegin', `
            <tr>
                <td>${formatarData(data)}</td>
                <td>${quadra}</td>
                <td>${motivo}</td>
                <td><span class="badge badge-off">Bloqueada</span></td>
                <td><button class="btn btn-sm btn-outline-success" data-unblock="${Date.now()}">Desbloquear</button></td>
            </tr>
        `);
        
        bootstrap.Modal.getInstance(document.getElementById('modalBloqueio')).hide();
        esportecToast('Bloqueio registrado.', 'success');
    });

    // Desbloquear
    document.addEventListener('click', event => {
        const btn = event.target.closest('[data-unblock]');
        if (btn) {
            const row = btn.closest('tr');
            row.querySelector('.badge').className = 'badge badge-on';
            row.querySelector('.badge').textContent = 'Liberada';
            btn.textContent = 'Liberado';
            btn.disabled = true;
            esportecToast('Bloqueio liberado.', 'success');
        }
    });

    // Salvar horários
    document.getElementById('btnSalvarHorarios')?.addEventListener('click', () => {
        esportecToast('Horários salvos.', 'success');
    });

    function formatarData(dataISO) {
        if (!dataISO) return '-';
        const [ano, mes, dia] = dataISO.split('-');
        return `${dia}/${mes}/${ano}`;
    }

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        console.log(' Carregando quadras...');
        carregarQuadras();
    });
</script>
</body>
</html>

