<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Pessoas - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-dark: #0F172A; --primary: #3B82F6; --success: #10B981; --danger: #EF4444; --warning: #F59E0B; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; margin: 0; }
        .card-custom { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .user-card { display: flex; align-items: center; padding: 1.2rem; border: 1px solid #E2E8F0; border-radius: 12px; margin-bottom: 1rem; transition: all 0.2s; }
        .user-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); transform: translateY(-2px); }
        .user-avatar { width: 50px; height: 50px; border-radius: 50%; background: #E2E8F0; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 1rem; font-size: 1.2rem; color: #64748B; }
        .user-info { flex: 1; }
        .user-name { font-weight: 600; font-size: 1.1rem; margin-bottom: 0.2rem; }
        .user-email { color: #64748B; font-size: 0.9rem; }
        .user-role { padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; margin-right: 0.5rem; }
        .role-super-admin { background: #DC2626; color: white; }
        .role-admin { background: #3B82F6; color: white; }
        .role-funcionario { background: #10B981; color: white; }
        .badge-active { background: #D1FAE5; color: #065F46; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; }
        .badge-inactive { background: #FEE2E2; color: #991B1B; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; }
        .btn-action { padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem; border: none; cursor: pointer; margin-left: 0.3rem; }
        .btn-edit { background: rgba(59,130,246,0.1); color: var(--primary); }
        .btn-inactive { background: rgba(239,68,68,0.1); color: var(--danger); }
        .btn-primary-admin { background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; }
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
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
            <a href="/admin/logs" class="nav-link"><i class="bi bi-journal-text"></i> Logs</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>
    <main class="main">
        <div class="header">
            <h1><i class="bi bi-people me-2"></i>Gestão de Pessoas</h1>
            <button class="btn-primary-admin" data-bs-toggle="modal" data-bs-target="#modalNovoUsuario">
                <i class="bi bi-person-plus me-2"></i>Novo Usuário
            </button>
        </div>

        <div class="card-custom">
            <h5 class="fw-bold mb-3">Administradores e Funcionários</h5>

            <!-- Usuário Super Admin (Protegido) -->
            <div class="user-card">
                <div class="user-avatar" style="background:#DC2626; color:white;">SA</div>
                <div class="user-info">
                    <div class="user-name">Super Admin <span class="user-role role-super-admin">SUPER ADMIN</span></div>
                    <div class="user-email">admin@esportec.com.br</div>
                </div>
                <span class="badge-active"><i class="bi bi-check-circle me-1"></i>Ativo</span>
                <!-- Botões desativados pois Super Admin não é editável -->
                <button class="btn-action btn-edit" disabled style="opacity: 0.5;"><i class="bi bi-lock"></i> Protegido</button>
            </div>

            <!-- Usuário Admin -->
            <div class="user-card">
                <div class="user-avatar" style="background:#3B82F6; color:white;">MA</div>
                <div class="user-info">
                    <div class="user-name">Maria Admin <span class="user-role role-admin">ADMIN</span></div>
                    <div class="user-email">maria@esportec.com.br</div>
                </div>
                <span class="badge-active"><i class="bi bi-check-circle me-1"></i>Ativo</span>
                <button class="btn-action btn-edit" data-person-action="editar"><i class="bi bi-pencil"></i> Editar</button>
                <button class="btn-action btn-inactive" data-person-action="toggle"><i class="bi bi-ban"></i> Inativar</button>
            </div>

            <!-- Usuário Funcionário -->
            <div class="user-card">
                <div class="user-avatar" style="background:#10B981; color:white;">JS</div>
                <div class="user-info">
                    <div class="user-name">João Silva <span class="user-role role-funcionario">FUNCIONÁRIO</span></div>
                    <div class="user-email">joao.silva@esportec.com.br</div>
                </div>
                <span class="badge-active"><i class="bi bi-check-circle me-1"></i>Ativo</span>
                <button class="btn-action btn-edit" data-person-action="editar"><i class="bi bi-pencil"></i> Editar</button>
                <button class="btn-action btn-inactive" data-person-action="toggle"><i class="bi bi-ban"></i> Inativar</button>
            </div>

            <!-- Usuário Inativo -->
            <div class="user-card">
                <div class="user-avatar" style="background:#9CA3AF; color:white;">AL</div>
                <div class="user-info">
                    <div class="user-name">Ana Lima <span class="user-role role-funcionario">FUNCIONÁRIO</span></div>
                    <div class="user-email">ana.lima@esportec.com.br</div>
                </div>
                <span class="badge-inactive"><i class="bi bi-x-circle me-1"></i>Inativo</span>
                <button class="btn-action btn-edit" data-person-action="editar"><i class="bi bi-pencil"></i> Editar</button>
                <button class="btn-action btn-inactive" data-person-action="toggle" style="background:rgba(16,185,129,0.1); color:var(--success);"><i class="bi bi-check"></i> Reativar</button>
            </div>
        </div>
    </main>
</div>

<!-- Modal Novo Usuário -->
<div class="modal fade" id="modalNovoUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus me-2"></i>Novo Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Nome Completo</label>
                    <input type="text" class="form-control" id="pessoaNome">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">E-mail</label>
                    <input type="email" class="form-control" id="pessoaEmail">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">CPF</label>
                    <input type="text" class="form-control" placeholder="000.000.000-00">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Perfil</label>
                    <select class="form-select" id="pessoaPerfil">
                        <option value="admin">Administrador</option>
                        <option value="funcionario">Funcionário</option>
                    </select>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-medium">Senha</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-medium">Confirmar Senha</label>
                        <input type="password" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnCriarUsuario">
                    <i class="bi bi-check-circle"></i> Criar Usuário
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    const modalNovoUsuario = document.getElementById('modalNovoUsuario');

    document.addEventListener('click', event => {
        const button = event.target.closest('[data-person-action]');
        if (!button) {
            return;
        }

            if (button.dataset.personAction === 'editar') {
                bootstrap.Modal.getOrCreateInstance(modalNovoUsuario).show();
                return;
            }

            const card = button.closest('.user-card');
            const badge = card.querySelector('.badge-active, .badge-inactive');
            const reativando = button.textContent.trim() === 'Reativar';
            badge.className = reativando ? 'badge-active' : 'badge-inactive';
            badge.innerHTML = reativando ? '<i class="bi bi-check-circle me-1"></i>Ativo' : '<i class="bi bi-x-circle me-1"></i>Inativo';
            button.innerHTML = reativando ? '<i class="bi bi-ban"></i> Inativar' : '<i class="bi bi-check"></i> Reativar';
            esportecToast(reativando ? 'Pessoa reativada.' : 'Pessoa inativada.', 'success');
    });

    document.getElementById('btnCriarUsuario').addEventListener('click', () => {
        const nome = document.getElementById('pessoaNome').value.trim() || 'Novo usuário';
        const email = document.getElementById('pessoaEmail').value.trim() || 'novo@esportec.com.br';
        const perfil = document.getElementById('pessoaPerfil').value;
        const iniciais = nome.split(' ').map(parte => parte[0]).join('').slice(0, 2).toUpperCase();
        document.querySelector('.card-custom').insertAdjacentHTML('beforeend', `
            <div class="user-card">
                <div class="user-avatar" style="background:#10B981; color:white;">${iniciais}</div>
                <div class="user-info">
                    <div class="user-name">${nome} <span class="user-role ${perfil === 'admin' ? 'role-admin' : 'role-funcionario'}">${perfil === 'admin' ? 'ADMIN' : 'FUNCIONÁRIO'}</span></div>
                    <div class="user-email">${email}</div>
                </div>
                <span class="badge-active"><i class="bi bi-check-circle me-1"></i>Ativo</span>
                <button class="btn-action btn-edit" data-person-action="editar"><i class="bi bi-pencil"></i> Editar</button>
                <button class="btn-action btn-inactive" data-person-action="toggle"><i class="bi bi-ban"></i> Inativar</button>
            </div>
        `);
        esportecToast('Usuário criado na lista de pessoas.', 'success');
        bootstrap.Modal.getInstance(modalNovoUsuario).hide();
    });
</script>
</body>
</html>
