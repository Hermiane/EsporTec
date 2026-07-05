<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <small class="opacity-75">ADMIN</small></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link active"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-people"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
            <a href="/admin/logs" class="nav-link"><i class="bi bi-journal-text"></i> Logs</a>
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

        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="card card-soft h-100">
                    <img class="court-img" src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=900&q=80" alt="Quadra Futsal Arena">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="fw-bold">Quadra Futsal Arena</h5>
                            <span class="badge badge-on">Ativa</span>
                        </div>
                        <p class="text-muted small mb-2">Futsal • Coberta • 10 jogadores</p>
                        <strong class="text-success">R$ 120/hora</strong>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button class="btn btn-sm btn-outline-success" data-court-action="editar"><i class="bi bi-pencil"></i> Editar</button>
                            <button class="btn btn-sm btn-outline-success" data-court-action="horarios"><i class="bi bi-clock"></i> Horários</button>
                            <button class="btn btn-sm btn-outline-secondary" data-court-action="bloqueios"><i class="bi bi-slash-circle"></i> Bloqueios</button>
                            <button class="btn btn-sm btn-outline-danger" data-court-action="toggle"><i class="bi bi-ban"></i> Inativar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-soft h-100">
                    <img class="court-img" src="https://images.unsplash.com/photo-1551958219-acbc608c6377?auto=format&fit=crop&w=900&q=80" alt="Quadra Society Premium">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="fw-bold">Quadra Society Premium</h5>
                            <span class="badge badge-on">Ativa</span>
                        </div>
                        <p class="text-muted small mb-2">Society • Aberta • 14 jogadores</p>
                        <strong class="text-success">R$ 150/hora</strong>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button class="btn btn-sm btn-outline-success" data-court-action="editar"><i class="bi bi-pencil"></i> Editar</button>
                            <button class="btn btn-sm btn-outline-success" data-court-action="horarios"><i class="bi bi-clock"></i> Horários</button>
                            <button class="btn btn-sm btn-outline-secondary" data-court-action="bloqueios"><i class="bi bi-slash-circle"></i> Bloqueios</button>
                            <button class="btn btn-sm btn-outline-danger" data-court-action="toggle"><i class="bi bi-ban"></i> Inativar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-soft h-100">
                    <img class="court-img" src="https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=900&q=80" alt="Quadra Society Descoberta">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="fw-bold">Quadra Society Descoberta</h5>
                            <span class="badge badge-off">Bloqueada</span>
                        </div>
                        <p class="text-muted small mb-2">Society • Aberta • 14 jogadores</p>
                        <strong class="text-success">R$ 100/hora</strong>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button class="btn btn-sm btn-outline-success" data-court-action="editar"><i class="bi bi-pencil"></i> Editar</button>
                            <button class="btn btn-sm btn-outline-success" data-court-action="horarios"><i class="bi bi-clock"></i> Horários</button>
                            <button class="btn btn-sm btn-outline-secondary" data-court-action="bloqueios"><i class="bi bi-slash-circle"></i> Bloqueios</button>
                            <button class="btn btn-sm btn-outline-success" data-court-action="toggle"><i class="bi bi-check2"></i> Ativar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="card card-soft p-4 mb-4" id="secaoHorarios">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0">Horários semanais</h5>
                <select class="form-select" style="max-width:260px">
                    <option>Quadra Society Premium</option>
                    <option>Quadra Futsal Arena</option>
                    <option>Quadra Society Descoberta</option>
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
        </section>

        <section class="card card-soft p-4" id="secaoBloqueios">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0">Bloqueios de quadra</h5>
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalBloqueio"><i class="bi bi-plus-lg me-2"></i>Novo bloqueio</button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Data</th><th>Quadra</th><th>Motivo</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                        <tr><td>22/06/2026</td><td>Society Descoberta</td><td>Manutenção do gramado</td><td><span class="badge badge-off">Bloqueada</span></td><td><button class="btn btn-sm btn-outline-success" data-unblock>Desbloquear</button></td></tr>
                        <tr><td>25/06/2026</td><td>Futsal Arena</td><td>Evento interno</td><td><span class="badge badge-off">Bloqueada</span></td><td><button class="btn btn-sm btn-outline-success" data-unblock>Desbloquear</button></td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

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

<div class="modal fade" id="modalBloqueio" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">Novo bloqueio</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <select class="form-select mb-3" id="bloqueioQuadraAdmin"><option>Society Premium</option><option>Futsal Arena</option></select>
            <input type="date" class="form-control mb-3" id="bloqueioDataAdmin">
            <textarea class="form-control" rows="3" id="bloqueioMotivoAdmin" placeholder="Motivo do bloqueio"></textarea>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-success" id="btnSalvarBloqueio">Bloquear</button></div>
    </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    const modalQuadra = document.getElementById('modalQuadra');
    const modalBloqueio = document.getElementById('modalBloqueio');

    document.addEventListener('click', event => {
        const button = event.target.closest('[data-court-action]');
        if (button) {
            const action = button.dataset.courtAction;
            if (action === 'editar') {
                bootstrap.Modal.getOrCreateInstance(modalQuadra).show();
            }
            if (action === 'horarios') {
                document.getElementById('secaoHorarios').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            if (action === 'bloqueios') {
                document.getElementById('secaoBloqueios').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            if (action === 'toggle') {
                const card = button.closest('.card');
                const badge = card.querySelector('.badge');
                const activating = button.textContent.trim() === 'Ativar';
                badge.className = activating ? 'badge badge-on' : 'badge badge-off';
                badge.textContent = activating ? 'Ativa' : 'Bloqueada';
                button.className = activating ? 'btn btn-sm btn-outline-danger' : 'btn btn-sm btn-outline-success';
                button.innerHTML = activating ? '<i class="bi bi-ban"></i> Inativar' : '<i class="bi bi-check2"></i> Ativar';
            }
        }

        const unblockButton = event.target.closest('[data-unblock]');
        if (unblockButton) {
            const row = unblockButton.closest('tr');
            row.querySelector('.badge').className = 'badge badge-on';
            row.querySelector('.badge').textContent = 'Liberada';
            unblockButton.textContent = 'Liberada';
            unblockButton.disabled = true;
            esportecToast('Bloqueio liberado.', 'success');
        }
    });

    document.getElementById('btnSalvarQuadra').addEventListener('click', () => {
        const nome = document.getElementById('quadraNomeAdmin').value.trim() || 'Nova Quadra';
        const tipo = document.getElementById('quadraTipoAdmin').value;
        const valor = document.getElementById('quadraValorAdmin').value.trim() || '120';
        const capacidade = document.getElementById('quadraCapacidadeAdmin').value.trim() || '10 jogadores';
        const cobertura = document.getElementById('quadraCoberturaAdmin').value;
        document.querySelector('.row.g-4.mb-4').insertAdjacentHTML('beforeend', `
            <div class="col-lg-4">
                <div class="card card-soft h-100">
                    <img class="court-img" src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=900&q=80" alt="${nome}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="fw-bold">${nome}</h5>
                            <span class="badge badge-on">Ativa</span>
                        </div>
                        <p class="text-muted small mb-2">${tipo} • ${cobertura} • ${capacidade}</p>
                        <strong class="text-success">R$ ${valor}/hora</strong>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button class="btn btn-sm btn-outline-success" data-court-action="editar"><i class="bi bi-pencil"></i> Editar</button>
                            <button class="btn btn-sm btn-outline-success" data-court-action="horarios"><i class="bi bi-clock"></i> Horários</button>
                            <button class="btn btn-sm btn-outline-secondary" data-court-action="bloqueios"><i class="bi bi-slash-circle"></i> Bloqueios</button>
                            <button class="btn btn-sm btn-outline-danger" data-court-action="toggle"><i class="bi bi-ban"></i> Inativar</button>
                        </div>
                    </div>
                </div>
            </div>
        `);
        esportecToast('Quadra adicionada aos cards.', 'success');
        bootstrap.Modal.getInstance(modalQuadra).hide();
    });

    document.getElementById('btnSalvarBloqueio').addEventListener('click', () => {
        const data = document.getElementById('bloqueioDataAdmin').value || 'Hoje';
        const quadra = document.getElementById('bloqueioQuadraAdmin').value;
        const motivo = document.getElementById('bloqueioMotivoAdmin').value.trim() || 'Bloqueio operacional';
        document.querySelector('#secaoBloqueios tbody').insertAdjacentHTML('afterbegin', `<tr><td>${data}</td><td>${quadra}</td><td>${motivo}</td><td><span class="badge badge-off">Bloqueada</span></td><td><button class="btn btn-sm btn-outline-success" data-unblock>Desbloquear</button></td></tr>`);
        esportecToast('Bloqueio registrado na tabela.', 'success');
        bootstrap.Modal.getInstance(modalBloqueio).hide();
    });
</script>
</body>
</html>

