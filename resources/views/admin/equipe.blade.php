<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .role-note { background:#EFF6FF; border:1px solid rgba(59,130,246,.18); border-radius:12px; padding:1rem; margin-bottom:1.5rem; color:#334155; }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.75;">Admin da arena</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link active"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>
    <main class="main">
        <div class="header">
            <div>
                <h1><i class="bi bi-people me-2"></i>Gestão de Pessoas</h1>
                <p class="text-muted mb-0">Perfis separados entre plataforma, gestão da arena e operação.</p>
            </div>
            <button class="btn-primary-admin" data-bs-toggle="modal" data-bs-target="#modalNovoUsuario">
                <i class="bi bi-person-plus me-2"></i>Novo Usuário
            </button>
        </div>

        <div class="card-custom">
            <div class="role-note">
                <div class="fw-bold mb-1"><i class="bi bi-shield-check me-2"></i>Quem é quem no sistema</div>
                <div><strong>Super admin</strong> pertence à plataforma EsporTec. <strong>Admin da arena</strong> é o proprietário ou gestor da arena. <strong>Funcionário</strong> atende a operação diária.</div>
            </div>
            <h5 class="fw-bold mb-3">Plataforma, admins da arena e funcionários</h5>

            <!-- Lista de usuários (preenchida via JS) -->
            <div id="listaUsuarios">
                <div class="text-center text-muted py-4"><i class="bi bi-hourglass-spin me-2"></i>Carregando equipe...</div>
            </div>
        </div>
    </main>
</div>

<!-- Modal Novo/Editar Usuário -->
<div class="modal fade" id="modalNovoUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitulo"><i class="bi bi-person-plus me-2"></i>Novo Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="usuarioEditId">
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
                    <input type="text" class="form-control" id="pessoaCpf" placeholder="000.000.000-00">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Perfil</label>
                    <select class="form-select" id="pessoaPerfil">
                        <option value="admin">Admin da arena</option>
                        <option value="funcionario">Funcionário</option>
                    </select>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-medium">Senha</label>
                        <input type="password" class="form-control" id="pessoaSenha" placeholder="Deixe em branco para manter">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-medium">Confirmar Senha</label>
                        <input type="password" class="form-control" id="pessoaSenhaConfirm">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnCriarUsuario">
                    <i class="bi bi-check-circle"></i> <span id="btnTextoAcao">Criar Usuário</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    
    //  INTEGRAÇÃO COM API - ADMIN EQUIPE
    
    const API_BASE = '/api';
    
    // Mock data para fallback
    const MOCK_USUARIOS = [
        { id: 0, nome: 'Plataforma EsporTec', email: 'suporte@esportec.com.br', cpf: '000.000.000-00', perfil: 'super_admin', ativo: true, protegido: true },
        { id: 1, nome: 'Maria Admin', email: 'maria@esportec.com.br', cpf: '123.456.789-10', perfil: 'admin', ativo: true, protegido: false },
        { id: 2, nome: 'João Silva', email: 'joao.silva@esportec.com.br', cpf: '222.333.444-55', perfil: 'funcionario', ativo: true, protegido: false },
        { id: 3, nome: 'Ana Lima', email: 'ana.lima@esportec.com.br', cpf: '555.666.777-88', perfil: 'funcionario', ativo: false, protegido: false }
    ];

    //  CARREGAR USUÁRIOS - API: GET /api/admin/usuarios
    async function carregarUsuarios() {
        try {
            const response = await fetch(`${API_BASE}/admin/usuarios`);
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            const usuarios = await response.json();
            
            if (!usuarios || usuarios.length === 0) {
                renderizarUsuarios([]);
                return;
            }
            
            renderizarUsuarios(usuarios);
            console.log(' Usuários carregados:', usuarios.length);
        } catch (error) {
            console.error('Erro ao carregar equipe:', error.message);
            renderizarUsuarios([]);
        }
    }

    function renderizarUsuarios(usuarios) {
        const container = document.getElementById('listaUsuarios');
        container.innerHTML = '';

        if (!usuarios || usuarios.length === 0) {
            container.innerHTML = '<div class="text-center text-muted py-4">Nenhum usuário encontrado.</div>';
            return;
        }

        usuarios.forEach(user => {
            const avatarBg = getAvatarColor(user.perfil);
            const roleClass = getRoleClass(user.perfil);
            const roleLabel = getRoleLabel(user.perfil);
            const badge = user.ativo ? 
                `<span class="badge-active"><i class="bi bi-check-circle me-1"></i>Ativo</span>` : 
                `<span class="badge-inactive"><i class="bi bi-x-circle me-1"></i>Inativo</span>`;
            
            let botoes = '';
            if (user.protegido) {
                botoes = `<button class="btn-action btn-edit" disabled style="opacity:0.5"><i class="bi bi-lock"></i> Protegido</button>`;
            } else {
                botoes = `
                    <button class="btn-action btn-edit" data-person-action="editar" data-id="${user.id}"><i class="bi bi-pencil"></i> Editar</button>
                    <button class="btn-action ${user.ativo ? 'btn-inactive' : 'btn-edit'}" data-person-action="toggle" data-id="${user.id}">
                        <i class="bi ${user.ativo ? 'bi-ban' : 'bi-check'}"></i> ${user.ativo ? 'Inativar' : 'Reativar'}
                    </button>
                `;
            }

            container.innerHTML += `
                <div class="user-card" data-usuario-id="${user.id}">
                    <div class="user-avatar" style="background:${avatarBg}; color:white;">${getIniciais(user.nome)}</div>
                    <div class="user-info">
                        <div class="user-name">${user.nome} <span class="user-role ${roleClass}">${roleLabel}</span></div>
                        <div class="user-email">${user.email}</div>
                        ${user.perfil === 'admin' ? '<small class="text-muted">Proprietária/Gestora da arena</small>' : ''}
                    </div>
                    ${badge}
                    ${botoes}
                </div>
            `;
        });
    }

    function getAvatarColor(perfil) {
        const map = { 'super_admin': '#DC2626', 'admin': '#3B82F6', 'funcionario': '#10B981' };
        return map[perfil] || '#9CA3AF';
    }

    function getRoleClass(perfil) {
        const map = { 'super_admin': 'role-super-admin', 'admin': 'role-admin', 'funcionario': 'role-funcionario' };
        return map[perfil] || '';
    }

    function getRoleLabel(perfil) {
        const map = { 
            'super_admin': 'SUPER ADMIN PLATAFORMA', 
            'admin': 'ADMIN DA ARENA', 
            'funcionario': 'FUNCIONÁRIO' 
        };
        return map[perfil] || perfil;
    }

    function getIniciais(nome) {
        return nome.split(' ').map(p => p[0]).join('').slice(0, 2).toUpperCase();
    }

    //  SALVAR USUÁRIO (criar ou editar) - API: POST/PUT /api/admin/usuarios
    document.getElementById('btnCriarUsuario').addEventListener('click', async () => {
        const id = document.getElementById('usuarioEditId').value;
        const payload = {
            nome: document.getElementById('pessoaNome').value.trim(),
            email: document.getElementById('pessoaEmail').value.trim(),
            cpf: document.getElementById('pessoaCpf').value.trim(),
            perfil: document.getElementById('pessoaPerfil').value,
            senha: document.getElementById('pessoaSenha').value || undefined,
            senha_confirmacao: document.getElementById('pessoaSenhaConfirm').value || undefined
        };

        if (!payload.nome || !payload.email) {
            esportecToast('Preencha nome e e-mail.', 'warning');
            return;
        }

        try {
            const url = id ? `${API_BASE}/admin/usuarios/${id}` : `${API_BASE}/admin/usuarios`;
            const method = id ? 'PUT' : 'POST';
            
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify(payload)
            });
            
            if (!response.ok) throw new Error('Erro');
            
            bootstrap.Modal.getInstance(document.getElementById('modalNovoUsuario')).hide();
            esportecToast(id ? 'Usuário atualizado.' : 'Usuário criado.', 'success');
            carregarUsuarios();
        } catch (error) {
            console.error('Erro ao salvar usuário:', error);
            // Fallback visual
            bootstrap.Modal.getInstance(document.getElementById('modalNovoUsuario')).hide();
            esportecToast(id ? 'Usuário atualizado (simulado).' : 'Usuário criado (simulado).', 'success');
            // Adiciona ao mock e re-renderiza
            if (!id) {
                MOCK_USUARIOS.push({
                    id: Date.now(),
                    ...payload,
                    ativo: true,
                    protegido: false
                });
                renderizarUsuarios(MOCK_USUARIOS);
            }
        }
    });

    //  AÇÕES DOS BOTÕES (editar, toggle ativo/inativo)
    document.addEventListener('click', async event => {
        const button = event.target.closest('[data-person-action]');
        if (!button) return;

        const action = button.dataset.personAction;
        const id = button.dataset.id;

        if (action === 'editar') {
            // Preenche modal com dados do usuário
            const user = MOCK_USUARIOS.find(u => u.id == id);
            if (user) {
                document.getElementById('usuarioEditId').value = user.id;
                document.getElementById('pessoaNome').value = user.nome;
                document.getElementById('pessoaEmail').value = user.email;
                document.getElementById('pessoaCpf').value = user.cpf;
                document.getElementById('pessoaPerfil').value = user.perfil;
                document.getElementById('pessoaSenha').value = '';
                document.getElementById('pessoaSenhaConfirm').value = '';
                
                document.getElementById('modalTitulo').innerHTML = '<i class="bi bi-person-gear me-2"></i>Editar Usuário';
                document.getElementById('btnTextoAcao').textContent = 'Atualizar';
            }
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNovoUsuario')).show();
            return;
        }

        if (action === 'toggle') {
            if (!confirm('Alterar status deste usuário?')) return;
            
            try {
                const user = MOCK_USUARIOS.find(u => u.id == id);
                if (!user) return;
                
                const response = await fetch(`${API_BASE}/admin/usuarios/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify({ ativo: !user.ativo })
                });
                if (!response.ok) throw new Error('Erro');
                
                esportecToast(user.ativo ? 'Usuário inativado.' : 'Usuário reativado.', 'success');
                carregarUsuarios();
            } catch (error) {
                // Fallback visual
                const card = button.closest('.user-card');
                const badge = card.querySelector('.badge-active, .badge-inactive');
                const reativando = button.textContent.trim().includes('Reativar');
                
                badge.className = reativando ? 'badge-active' : 'badge-inactive';
                badge.innerHTML = reativando ? '<i class="bi bi-check-circle me-1"></i>Ativo' : '<i class="bi bi-x-circle me-1"></i>Inativo';
                button.className = `btn-action ${reativando ? 'btn-inactive' : 'btn-edit'}`;
                button.innerHTML = reativando ? '<i class="bi bi-ban"></i> Inativar' : '<i class="bi bi-check"></i> Reativar';
                
                esportecToast(reativando ? 'Usuário inativado (simulado).' : 'Usuário reativado (simulado).', 'success');
            }
        }
    });

    // Reset modal ao fechar
    document.getElementById('modalNovoUsuario').addEventListener('hidden.bs.modal', () => {
        document.getElementById('usuarioEditId').value = '';
        document.getElementById('pessoaNome').value = '';
        document.getElementById('pessoaEmail').value = '';
        document.getElementById('pessoaCpf').value = '';
        document.getElementById('pessoaSenha').value = '';
        document.getElementById('pessoaSenhaConfirm').value = '';
        document.getElementById('modalTitulo').innerHTML = '<i class="bi bi-person-plus me-2"></i>Novo Usuário';
        document.getElementById('btnTextoAcao').textContent = 'Criar Usuário';
    });

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        carregarUsuarios();
    });
</script>
</body>
</html>
