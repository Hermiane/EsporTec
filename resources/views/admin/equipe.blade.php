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
        .sidebar-brand { color:white; font-size:1.5rem; font-weight:700; text-decoration:none; display:block; margin-bottom:2rem; }
        .nav-link { color:rgba(255,255,255,.75); border-radius:8px; padding:.75rem 1rem; margin-bottom:.35rem; display:flex; gap:.75rem; align-items:center; text-decoration:none; }
        .nav-link:hover,.nav-link.active { background:rgba(255,255,255,.12); color:white; }
        .main { flex:1; padding:2rem; }
        .card-soft { background:white; border:0; border-radius:12px; box-shadow:0 4px 16px rgba(15,23,42,.06); }
        .badge-crown { background:#F9A825; color:#1F2937; }
        .badge-admin { background:rgba(21,101,192,.15); color:#1565C0; }
        .badge-func { background:rgba(45,129,93,.15); color:var(--primary); }
        .nav-tabs .nav-link { color:#64748B; background:transparent; }
        .nav-tabs .nav-link.active { color:var(--primary); background:white; border-color:#DEE2E6 #DEE2E6 white; }
        .btn-success { background:var(--primary); border-color:var(--primary); }
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
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link active"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-people"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
            <a href="/admin/logs" class="nav-link"><i class="bi bi-journal-text"></i> Logs</a>
        </nav>
    </aside>
    <main class="main">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Equipe</h1>
                <p class="text-muted mb-0">CPF obrigatório para administradores e funcionários.</p>
            </div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEquipe"><i class="bi bi-person-plus me-2"></i>Novo usuário</button>
        </div>

        <ul class="nav nav-tabs mb-0" id="teamTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#admins" type="button">Administradores</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#funcionarios" type="button">Funcionários</button></li>
        </ul>
        <div class="tab-content card-soft p-4">
            <div class="tab-pane fade show active" id="admins">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead><tr><th>Nome</th><th>CPF</th><th>E-mail</th><th>Perfil</th><th>Status</th><th>Ações</th></tr></thead>
                        <tbody>
                            <tr><td>Super Admin</td><td>000.000.000-00</td><td>admin@esportec.com.br</td><td><span class="badge badge-crown">Super admin</span></td><td><span class="badge bg-success">Ativo</span></td><td><button class="btn btn-sm btn-outline-secondary" disabled><i class="bi bi-lock"></i> Protegido</button></td></tr>
                            <tr><td>Maria Admin</td><td>123.456.789-10</td><td>maria@esportec.com.br</td><td><span class="badge badge-admin">Administrador</span></td><td><span class="badge bg-success">Ativo</span></td><td><button class="btn btn-sm btn-outline-success" data-team-action="editar"><i class="bi bi-pencil"></i> Editar</button> <button class="btn btn-sm btn-outline-danger" data-team-action="toggle"><i class="bi bi-ban"></i> Inativar</button></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="funcionarios">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead><tr><th>Nome</th><th>CPF</th><th>E-mail</th><th>Permissões</th><th>Status</th><th>Ações</th></tr></thead>
                        <tbody>
                            <tr><td>João Silva</td><td>222.333.444-55</td><td>joao@esportec.com.br</td><td>Agenda, pagamentos</td><td><span class="badge bg-success">Ativo</span></td><td><button class="btn btn-sm btn-outline-success" data-team-action="editar"><i class="bi bi-pencil"></i> Editar</button> <button class="btn btn-sm btn-outline-danger" data-team-action="toggle"><i class="bi bi-ban"></i> Inativar</button></td></tr>
                            <tr><td>Ana Lima</td><td>555.666.777-88</td><td>ana@esportec.com.br</td><td>Agenda</td><td><span class="badge bg-secondary">Inativo</span></td><td><button class="btn btn-sm btn-outline-success" data-team-action="toggle"><i class="bi bi-check2"></i> Reativar</button></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="modalEquipe" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">Novo usuário da equipe</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-12"><input class="form-control" id="teamNome" placeholder="Nome completo"></div>
                <div class="col-md-6"><input class="form-control" id="teamCpf" placeholder="CPF"></div>
                <div class="col-md-6"><input class="form-control" placeholder="Telefone"></div>
                <div class="col-md-12"><input type="email" class="form-control" id="teamEmail" placeholder="E-mail"></div>
                <div class="col-md-12"><select class="form-select" id="teamPerfil"><option>Funcionário</option><option>Administrador</option></select></div>
            </div>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-success" id="btnSalvarEquipe">Salvar</button></div>
    </div></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    const modalEquipe = document.getElementById('modalEquipe');

    document.querySelectorAll('[data-team-action]').forEach(button => {
        button.addEventListener('click', () => {
            if (button.dataset.teamAction === 'editar') {
                bootstrap.Modal.getOrCreateInstance(modalEquipe).show();
                return;
            }

            const row = button.closest('tr');
            const statusBadge = row.querySelector('td:nth-child(5) .badge');
            const reativando = button.textContent.trim() === 'Reativar';
            statusBadge.className = reativando ? 'badge bg-success' : 'badge bg-secondary';
            statusBadge.textContent = reativando ? 'Ativo' : 'Inativo';
            button.className = reativando ? 'btn btn-sm btn-outline-danger' : 'btn btn-sm btn-outline-success';
            button.innerHTML = reativando ? '<i class="bi bi-ban"></i> Inativar' : '<i class="bi bi-check2"></i> Reativar';
            esportecToast(reativando ? 'Usuário reativado.' : 'Usuário inativado.', 'success');
        });
    });

    document.getElementById('btnSalvarEquipe').addEventListener('click', () => {
        const nome = document.getElementById('teamNome').value.trim() || 'Novo usuário';
        const cpf = document.getElementById('teamCpf').value.trim() || '000.000.000-00';
        const email = document.getElementById('teamEmail').value.trim() || 'novo@esportec.com.br';
        const perfil = document.getElementById('teamPerfil').value;
        const targetBody = perfil === 'Administrador' ? document.querySelector('#admins tbody') : document.querySelector('#funcionarios tbody');
        const roleCell = perfil === 'Administrador'
            ? '<span class="badge badge-admin">Administrador</span>'
            : 'Agenda, pagamentos';
        targetBody.insertAdjacentHTML('beforeend', `
            <tr>
                <td>${nome}</td><td>${cpf}</td><td>${email}</td><td>${roleCell}</td>
                <td><span class="badge bg-success">Ativo</span></td>
                <td><button class="btn btn-sm btn-outline-secondary" disabled><i class="bi bi-check2"></i> Criado</button></td>
            </tr>
        `);
        esportecToast('Usuário da equipe adicionado na lista.', 'success');
        bootstrap.Modal.getInstance(modalEquipe).hide();
    });
</script>
</body>
</html>

