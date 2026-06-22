<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Clientes - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-dark: #1F5C42; --primary: #2D815D; --primary-soft: #E8F5EE; --muted: #64748B; --line: #E2E8F0; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-link { color: rgba(255,255,255,0.74); padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; margin: 0; }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-box { padding: 1.5rem; border-radius: 12px; color: #334155; display: flex; align-items: center; gap: 1rem; background: white; border: 1px solid var(--line); border-left: 4px solid var(--primary); box-shadow: 0 2px 8px rgba(15,23,42,0.04); }
        .stat-box.total { border-left-color: var(--primary); }
        .stat-box.birthday { border-left-color: var(--admin-dark); }
        .stat-box.vip { border-left-color: #94A3B8; }
        .stat-icon { font-size: 2rem; color: var(--primary); opacity: 0.9; }
        .stat-value { font-size: 2rem; font-weight: 700; margin: 0.5rem 0; }
        .stat-label { font-size: 0.9rem; color: var(--muted); }
        .card-custom { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .client-avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 1rem; color: var(--primary); background: var(--primary-soft); border: 1px solid rgba(45,129,93,0.2); font-size: 0.9rem; }
        .badge-vip { background: var(--primary-soft); color: var(--primary); padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
        .btn-action { padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem; border: none; cursor: pointer; margin-right: 0.3rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; }
        .btn-offer { background: var(--primary-soft); color: var(--primary); }
        .btn-offer:hover { background: var(--primary); color: white; }
        .btn-history { background: #F1F5F9; color: #475569; }
        .btn-history:hover { background: var(--primary); color: white; }
        .btn-primary-admin { background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-primary-admin:hover { background: var(--admin-dark); }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.6;">ADMIN</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link active"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
            <a href="/admin/logs" class="nav-link"><i class="bi bi-journal-text"></i> Logs</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>

    <main class="main">
        <div class="header">
            <h1><i class="bi bi-people-fill me-2"></i>Gestão de Clientes</h1>
            <button class="btn-primary-admin" id="btnOfertaMassa"><i class="bi bi-envelope me-2"></i>Enviar Oferta em Massa</button>
        </div>

        <div class="stats-row">
            <div class="stat-box total">
                <i class="bi bi-people-fill stat-icon"></i>
                <div>
                    <div class="stat-value">342</div>
                    <div class="stat-label">Total de Clientes</div>
                </div>
            </div>
            <div class="stat-box birthday">
                <i class="bi bi-gift-fill stat-icon"></i>
                <div>
                    <div class="stat-value">28</div>
                    <div class="stat-label">Aniversariantes do Mês</div>
                </div>
            </div>
            <div class="stat-box vip">
                <i class="bi bi-star-fill stat-icon"></i>
                <div>
                    <div class="stat-value">45</div>
                    <div class="stat-label">Clientes VIP</div>
                </div>
            </div>
        </div>

        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Lista de Clientes</h5>
                <input type="search" id="buscarClienteAdmin" placeholder="Buscar cliente..." class="form-control" style="width: 300px;">
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Reservas</th>
                            <th>Última Visita</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Cliente VIP -->
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="client-avatar">JS</div>
                                    <div>
                                        <div class="fw-semibold">João Silva</div>
                                        <small class="text-muted">CPF: 123.456.789-00</small>
                                    </div>
                                </div>
                            </td>
                            <td>joao.silva@email.com</td>
                            <td>(11) 99999-9999</td>
                            <td><span class="fw-bold">24</span> reservas</td>
                            <td>12/06/2026</td>
                            <td><span class="badge-vip"><i class="bi bi-star-fill me-1"></i>VIP</span></td>
                            <td>
                                <button class="btn-action btn-offer" data-client-action="oferta"><i class="bi bi-gift"></i> Enviar oferta</button>
                                <button class="btn-action btn-history" data-client-action="historico"><i class="bi bi-clock-history"></i> Ver histórico</button>
                            </td>
                        </tr>

                        <!-- Cliente Regular -->
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="client-avatar">PM</div>
                                    <div>
                                        <div class="fw-semibold">Pedro Martins</div>
                                        <small class="text-muted">CPF: 987.654.321-00</small>
                                    </div>
                                </div>
                            </td>
                            <td>pedro.m@email.com</td>
                            <td>(11) 98888-8888</td>
                            <td><span class="fw-bold">12</span> reservas</td>
                            <td>10/06/2026</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-person me-1"></i>Regular</span></td>
                            <td>
                                <button class="btn-action btn-offer" data-client-action="oferta"><i class="bi bi-gift"></i> Enviar oferta</button>
                                <button class="btn-action btn-history" data-client-action="historico"><i class="bi bi-clock-history"></i> Ver histórico</button>
                            </td>
                        </tr>

                        <!-- Cliente Aniversariante -->
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="client-avatar">AL</div>
                                    <div>
                                        <div class="fw-semibold">Ana Lima</div>
                                        <small class="text-muted">CPF: 456.789.123-00</small>
                                    </div>
                                </div>
                            </td>
                            <td>ana.lima@email.com</td>
                            <td>(11) 97777-7777</td>
                            <td><span class="fw-bold">8</span> reservas</td>
                            <td>08/06/2026</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-gift me-1"></i>Aniversário</span></td>
                            <td>
                                <button class="btn-action btn-offer" data-client-action="oferta"><i class="bi bi-gift"></i> Enviar oferta</button>
                                <button class="btn-action btn-history" data-client-action="historico"><i class="bi bi-clock-history"></i> Ver histórico</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="modalClienteAdmin" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalClienteTitulo">Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalClienteConteudo"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarClienteModal">Confirmar ação</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    const buscarClienteAdmin = document.getElementById('buscarClienteAdmin');
    const modalClienteAdmin = document.getElementById('modalClienteAdmin');
    const modalClienteTitulo = document.getElementById('modalClienteTitulo');
    const modalClienteConteudo = document.getElementById('modalClienteConteudo');
    const btnConfirmarClienteModal = document.getElementById('btnConfirmarClienteModal');

    buscarClienteAdmin.addEventListener('input', () => {
        const term = buscarClienteAdmin.value.trim().toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            row.classList.toggle('d-none', term && !row.textContent.toLowerCase().includes(term));
        });
    });

    document.getElementById('btnOfertaMassa').addEventListener('click', () => {
        modalClienteTitulo.textContent = 'Enviar oferta em massa';
        modalClienteConteudo.innerHTML = `
            <div class="alert alert-success"><i class="bi bi-megaphone me-2"></i>Campanha preparada para os clientes visíveis na tabela.</div>
            <label class="form-label fw-semibold">Mensagem da oferta</label>
            <textarea class="form-control" rows="4">Olá! A EsporTec preparou uma condição especial para sua próxima reserva. Aproveite esta semana.</textarea>
            <div class="row g-3 mt-2">
                <div class="col-md-6"><label class="form-label">Canal</label><select class="form-select"><option>E-mail</option><option>WhatsApp</option><option>Notificação</option></select></div>
                <div class="col-md-6"><label class="form-label">Público</label><select class="form-select"><option>Clientes visíveis</option><option>Clientes VIP</option><option>Aniversariantes</option></select></div>
            </div>
        `;
        btnConfirmarClienteModal.textContent = 'Preparar envio';
        btnConfirmarClienteModal.onclick = () => {
            bootstrap.Modal.getInstance(modalClienteAdmin).hide();
            esportecToast('Oferta em massa preparada na tela.', 'success');
        };
        bootstrap.Modal.getOrCreateInstance(modalClienteAdmin).show();
    });

    document.querySelectorAll('[data-client-action]').forEach(button => {
        button.addEventListener('click', () => {
            const row = button.closest('tr');
            const nome = row.querySelector('.fw-semibold').textContent.trim();
            if (button.dataset.clientAction === 'oferta') {
                modalClienteTitulo.textContent = `Oferta para ${nome}`;
                modalClienteConteudo.innerHTML = `
                    <label class="form-label fw-semibold">Mensagem personalizada</label>
                    <textarea class="form-control" rows="4">${nome}, sentimos sua falta na EsporTec. Reserve uma quadra esta semana e aproveite uma condição especial.</textarea>
                    <div class="alert alert-info mt-3 mb-0"><i class="bi bi-info-circle me-2"></i>A oferta ficará marcada no relacionamento do cliente.</div>
                `;
                btnConfirmarClienteModal.textContent = 'Preparar oferta';
                btnConfirmarClienteModal.onclick = () => {
                    button.innerHTML = '<i class="bi bi-check2"></i> Oferta pronta';
                    button.disabled = true;
                    bootstrap.Modal.getInstance(modalClienteAdmin).hide();
                    esportecToast(`Oferta preparada para ${nome}.`, 'success');
                };
                bootstrap.Modal.getOrCreateInstance(modalClienteAdmin).show();
                return;
            }
            modalClienteTitulo.textContent = `Histórico de ${nome}`;
            modalClienteConteudo.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Reservas</small><strong class="d-block">${row.children[3].textContent.trim()}</strong></div></div>
                    <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Última visita</small><strong class="d-block">${row.children[4].textContent.trim()}</strong></div></div>
                    <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Status</small><strong class="d-block">${row.children[5].textContent.trim()}</strong></div></div>
                </div>
                <hr>
                <h6 class="fw-bold">Reservas recentes</h6>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between"><span>Society Premium</span><strong>Confirmada</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Futsal Arena</span><strong>Concluída</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Society Descoberta</span><strong>Pagamento pendente</strong></li>
                </ul>
            `;
            btnConfirmarClienteModal.textContent = 'Enviar lembrete';
            btnConfirmarClienteModal.onclick = () => esportecToast(`Lembrete preparado para ${nome}.`, 'success');
            bootstrap.Modal.getOrCreateInstance(modalClienteAdmin).show();
        });
    });
</script>
</body>
</html>
