<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipe - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --light:#E8F5EE; --bg:#F8FAFC; }
        body { margin:0; font-family:'Poppins',sans-serif; background:var(--bg); color:#334155; }
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:260px; background:var(--dark); padding:1.5rem; flex-shrink:0; }
        .sidebar-brand { color:white; font-size:1.5rem; font-weight:700; text-decoration:none; display:flex; align-items:center; gap:0.5rem; margin-bottom:2rem; }
        .sidebar-brand i { font-size:1.8rem; }
        .sidebar-brand small { font-size:0.7rem; opacity:0.75; display:block; margin-top:-0.2rem; }
        .nav-link { color:rgba(255,255,255,.75); border-radius:8px; padding:.75rem 1rem; margin-bottom:.35rem; display:flex; gap:.75rem; align-items:center; text-decoration:none; }
        .nav-link:hover,.nav-link.active { background:rgba(255,255,255,.12); color:white; }
        .main { flex:1; padding:2rem; }
        
        /* Ajuste das tabs com mais espaçamento */
        .tabs-wrapper { 
            margin-bottom: 1.5rem; 
            background: white;
            padding: 1rem 1.5rem 0;
            border-radius: 12px 12px 0 0;
            border-bottom: 2px solid #E2E8F0;
        }
        .nav-tabs { 
            border-bottom: 0; 
            gap: 0.5rem;
        }
        .nav-tabs .nav-link { 
            color:#64748B; 
            background:transparent; 
            border: 1px solid transparent;
            border-radius: 8px 8px 0 0;
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            transition: all 0.2s;
        }
        .nav-tabs .nav-link:hover { 
            color: var(--primary);
            background: var(--light);
            border-color: transparent;
        }
        .nav-tabs .nav-link.active { 
            color:var(--primary); 
            background: var(--light); 
            border-color: #E2E8F0 #E2E8F0 transparent;
            font-weight: 600;
        }
        .nav-tabs .nav-link i {
            font-size: 1rem;
        }
        
        .card-soft { 
            background:white; 
            border:0; 
            border-radius: 0 0 12px 12px;
            box-shadow:0 4px 16px rgba(15,23,42,.06); 
            margin-top: 0;
        }
        
        .badge-crown { background:#F9A825; color:#1F2937; display:inline-flex; align-items:center; gap:0.3rem; padding: 0.35rem 0.7rem; }
        .badge-admin { background:rgba(21,101,192,.15); color:#1565C0; display:inline-flex; align-items:center; gap:0.3rem; padding: 0.35rem 0.7rem; }
        .badge-func { background:rgba(45,129,93,.15); color:var(--primary); display:inline-flex; align-items:center; gap:0.3rem; padding: 0.35rem 0.7rem; }
        
        .btn-success { background:var(--primary); border-color:var(--primary); }
        
        /* Ajustes para botões de ação não sobrepor */
        .actions-cell { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 0.3rem;
            align-items: center;
        }
        .btn-action-sm { 
            padding: 0.4rem 0.7rem; 
            border-radius: 6px; 
            font-size: 0.8rem; 
            font-weight: 600; 
            display: inline-flex; 
            align-items: center; 
            gap: 0.3rem;
            white-space: nowrap;
        }
        
        .table th { 
            font-weight: 600; 
            color: #64748B;
            border-bottom: 2px solid #E2E8F0;
            padding: 1rem 0.75rem;
        }
        .table td { 
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #F1F5F9;
        }
        
        @media (max-width: 1400px) {
            .btn-action-sm { padding: 0.35rem 0.6rem; font-size: 0.75rem; }
            .table td, .table th { padding: 0.8rem 0.6rem; font-size: 0.9rem; }
        }
        
        @media (max-width: 1200px) {
            .actions-cell { flex-direction: column; align-items: flex-start; }
            .btn-action-sm { width: 100%; justify-content: flex-start; }
        }
        
        @media (max-width: 992px) { 
            .layout { display:block; } 
            .sidebar { width:100%; } 
            .main { padding:1rem; }
            .actions-cell { flex-direction: row; flex-wrap: wrap; }
            .btn-action-sm { width: auto; }
            .tabs-wrapper { padding: 0.75rem 1rem 0; }
        }
        
        @media (max-width: 768px) {
            .table th, .table td { font-size: 0.8rem; padding: 0.6rem 0.5rem; }
            .btn-action-sm { font-size: 0.7rem; padding: 0.3rem 0.5rem; }
            .nav-tabs .nav-link { padding: 0.6rem 1rem; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">
            <i class="bi bi-trophy"></i>
            <div>
                EsporTec
                <small>ADMIN</small>
            </div>
        </a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link active"><i class="bi bi-people"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-people"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
            <a href="/admin/logs" class="nav-link"><i class="bi bi-journal-text"></i> Logs</a>
        </nav>
    </aside>
    <main class="main">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1"><i class="bi bi-people me-2"></i>Equipe</h1>
                <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>CPF obrigatório para administradores e funcionários.</p>
            </div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEquipe">
                <i class="bi bi-person-plus"></i>Novo usuário
            </button>
        </div>

        <!-- Wrapper das tabs com espaçamento -->
        <div class="tabs-wrapper">
            <ul class="nav nav-tabs" id="teamTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#admins" type="button">
                        <i class="bi bi-shield-check me-1"></i>Administradores
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#funcionarios" type="button">
                        <i class="bi bi-person-badge me-1"></i>Funcionários
                    </button>
                </li>
            </ul>
        </div>
        
        <div class="tab-content card-soft">
            <div class="tab-pane fade show active p-4" id="admins">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th><i class="bi bi-person me-1"></i>Nome</th>
                                <th><i class="bi bi-card-text me-1"></i>CPF</th>
                                <th><i class="bi bi-envelope me-1"></i>E-mail</th>
                                <th><i class="bi bi-person-gear me-1"></i>Perfil</th>
                                <th><i class="bi bi-toggle-on me-1"></i>Status</th>
                                <th><i class="bi bi-tools me-1"></i>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Super Admin</td>
                                <td>000.000.000-00</td>
                                <td>admin@esportec.com.br</td>
                                <td><span class="badge badge-crown"><i class="bi bi-shield-lock"></i> Super admin</span></td>
                                <td><span class="badge bg-success"><i class="bi bi-check-circle"></i> Ativo</span></td>
                                <td class="actions-cell">
                                    <button class="btn btn-sm btn-outline-secondary btn-action-sm" disabled>
                                        <i class="bi bi-lock"></i> Protegido
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Maria Admin</td>
                                <td>123.456.789-10</td>
                                <td>maria@esportec.com.br</td>
                                <td><span class="badge badge-admin"><i class="bi bi-shield-check"></i> Administrador</span></td>
                                <td><span class="badge bg-success"><i class="bi bi-check-circle"></i> Ativo</span></td>
                                <td class="actions-cell">
                                    <button class="btn btn-sm btn-outline-success btn-action-sm" data-team-action="editar">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-action-sm" data-team-action="toggle">
                                        <i class="bi bi-ban"></i> Inativar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-4" id="funcionarios">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th><i class="bi bi-person me-1"></i>Nome</th>
                                <th><i class="bi bi-card-text me-1"></i>CPF</th>
                                <th><i class="bi bi-envelope me-1"></i>E-mail</th>
                                <th><i class="bi bi-key me-1"></i>Permissões</th>
                                <th><i class="bi bi-toggle-on me-1"></i>Status</th>
                                <th><i class="bi bi-tools me-1"></i>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>João Silva</td>
                                <td>222.333.444-55</td>
                                <td>joao@esportec.com.br</td>
                                <td>Agenda, pagamentos</td>
                                <td><span class="badge bg-success"><i class="bi bi-check-circle"></i> Ativo</span></td>
                                <td class="actions-cell">
                                    <button class="btn btn-sm btn-outline-success btn-action-sm" data-team-action="editar">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-action-sm" data-team-action="toggle">
                                        <i class="bi bi-ban"></i> Inativar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Ana Lima</td>
                                <td>555.666.777-88</td>
                                <td>ana@esportec.com.br</td>
                                <td>Agenda</td>
                                <td><span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Inativo</span></td>
                                <td class="actions-cell">
                                    <button class="btn btn-sm btn-outline-success btn-action-sm" data-team-action="toggle">
                                        <i class="bi bi-check2"></i> Reativar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="modalEquipe" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fw-bold"><i class="bi bi-person-plus me-2"></i>Novo usuário da equipe</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-medium"><i class="bi bi-person me-1"></i>Nome completo</label>
                    <input class="form-control" id="teamNome" placeholder="Nome completo">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium"><i class="bi bi-card-text me-1"></i>CPF</label>
                    <input class="form-control" id="teamCpf" placeholder="CPF">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium"><i class="bi bi-phone me-1"></i>Telefone</label>
                    <input class="form-control" placeholder="Telefone">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-medium"><i class="bi bi-envelope me-1"></i>E-mail</label>
                    <input type="email" class="form-control" id="teamEmail" placeholder="E-mail">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-medium"><i class="bi bi-person-gear me-1"></i>Perfil</label>
                    <select class="form-select" id="teamPerfil">
                        <option>Funcionário</option>
                        <option>Administrador</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
            <button class="btn btn-success" id="btnSalvarEquipe">
                <i class="bi bi-check-lg me-1"></i>Salvar
            </button>
        </div>
    </div></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    const modalEquipe = document.getElementById('modalEquipe');

    document.addEventListener('click', event => {
        const button = event.target.closest('[data-team-action]');
        if (!button) {
            return;
        }

        if (button.dataset.teamAction === 'editar') {
            bootstrap.Modal.getOrCreateInstance(modalEquipe).show();
            return;
        }

        const row = button.closest('tr');
        const statusBadge = row.querySelector('td:nth-child(5) .badge');
        const reativando = button.textContent.trim() === 'Reativar';
        statusBadge.className = reativando ? 'badge bg-success' : 'badge bg-secondary';
        statusBadge.innerHTML = reativando 
            ? '<i class="bi bi-check-circle"></i> Ativo' 
            : '<i class="bi bi-x-circle"></i> Inativo';
        button.className = reativando ? 'btn btn-sm btn-outline-danger btn-action-sm' : 'btn btn-sm btn-outline-success btn-action-sm';
        button.innerHTML = reativando 
            ? '<i class="bi bi-ban"></i> Inativar' 
            : '<i class="bi bi-check2"></i> Reativar';
        esportecToast(reativando ? 'Usuário reativado.' : 'Usuário inativado.', 'success');
    });

    document.getElementById('btnSalvarEquipe').addEventListener('click', () => {
        const nome = document.getElementById('teamNome').value.trim() || 'Novo usuário';
        const cpf = document.getElementById('teamCpf').value.trim() || '000.000.000-00';
        const email = document.getElementById('teamEmail').value.trim() || 'novo@esportec.com.br';
        const perfil = document.getElementById('teamPerfil').value;
        const targetBody = perfil === 'Administrador' ? document.querySelector('#admins tbody') : document.querySelector('#funcionarios tbody');
        
        const roleCell = perfil === 'Administrador'
            ? '<span class="badge badge-admin"><i class="bi bi-shield-check"></i> Administrador</span>'
            : 'Agenda, pagamentos';
            
        targetBody.insertAdjacentHTML('beforeend', `
            <tr>
                <td>${nome}</td>
                <td>${cpf}</td>
                <td>${email}</td>
                <td>${roleCell}</td>
                <td><span class="badge bg-success"><i class="bi bi-check-circle"></i> Ativo</span></td>
                <td class="actions-cell">
                    <button class="btn btn-sm btn-outline-success btn-action-sm" data-team-action="editar">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                    <button class="btn btn-sm btn-outline-danger btn-action-sm" data-team-action="toggle">
                        <i class="bi bi-ban"></i> Inativar
                    </button>
                </td>
            </tr>
        `);
        esportecToast('Usuário da equipe adicionado na lista.', 'success');
        bootstrap.Modal.getInstance(modalEquipe).hide();
    });
</script>
</body>
</html>