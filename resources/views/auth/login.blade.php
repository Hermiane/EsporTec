<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; }
        body { font-family: 'Poppins', sans-serif; background: var(--light); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        body.staff-mode { background: #EEF2FF; }
        body.admin-mode { background: #F1F5F9; }
        .auth-card { background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); padding: 2.5rem; width: 100%; max-width: 480px; border-top: 5px solid var(--primary); }
        .access-panel { background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; display: none; }
        .access-panel.active { display: block; }
        .access-badge { display: inline-flex; align-items: center; gap: 0.45rem; background: var(--light); color: var(--primary); border-radius: 999px; padding: 0.4rem 0.8rem; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.75rem; }
        .staff-mode .access-badge { background: #DBEAFE; color: #1565C0; }
        .admin-mode .access-badge { background: #E2E8F0; color: #0F172A; }
        .form-control { border-radius: 10px; padding: 0.9rem; border: 1px solid #e0e0e0; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(45, 129, 93, 0.15); }
        .btn-primary-custom { background: var(--primary); border: none; padding: 0.9rem; border-radius: 10px; font-weight: 600; width: 100%; }
        .btn-primary-custom:hover { background: var(--dark); }
        .auth-link { color: var(--primary); text-decoration: none; font-weight: 500; }
        .auth-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: var(--primary);">EsporTec</h2>
            <p class="text-muted">Entre na sua conta para continuar</p>
        </div>

        <form id="loginForm">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-medium">E-mail</label>
                <input type="email" class="form-control" placeholder="seu@email.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Senha</label>
                <input type="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Tipo de acesso</label>
                <select class="form-control" id="tipoAcesso">
                    <option value="cliente">Cliente</option>
                    <option value="funcionario">Funcionário</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <div class="access-panel active" id="clientePanel">
                <span class="access-badge">Área do cliente</span>
                <small class="text-muted d-block">Acesso para reservar quadras, acompanhar histórico, notificações e perfil.</small>
            </div>
            <div class="access-panel" id="funcionarioPanel">
                <span class="access-badge">Área operacional</span>
                <div class="mb-3">
                    <label class="form-label fw-medium">Matrícula do funcionário</label>
                    <input type="text" class="form-control staff-required" placeholder="Ex: FUNC-2024-089">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-medium">Unidade de trabalho</label>
                    <select class="form-control staff-required">
                        <option>EsporTec - Unidade Principal</option>
                        <option>EsporTec - Unidade Zona Norte</option>
                    </select>
                </div>
            </div>
            <div class="access-panel" id="adminPanel">
                <span class="access-badge">Área administrativa</span>
                <div class="mb-3">
                    <label class="form-label fw-medium">Código administrativo</label>
                    <input type="text" class="form-control admin-required" placeholder="Ex: ADM-ESPORTEC">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-medium">Nível de permissão</label>
                    <select class="form-control admin-required">
                        <option>Administrador</option>
                        <option>Super admin</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Lembrar de mim</label>
                </div>
                <a href="/recuperar-senha" class="auth-link small">Esqueci a senha</a>
            </div>

            <button type="submit" class="btn btn-primary-custom text-white">
                Entrar
            </button>
        </form>
        <div class="text-center mt-4">
            <p class="mb-0">Não tem conta? <a href="/criar-conta" class="auth-link">Criar conta</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/esportec-ui.js"></script>
    <script>
        const tipoAcesso = document.getElementById('tipoAcesso');
        const panels = {
            cliente: document.getElementById('clientePanel'),
            funcionario: document.getElementById('funcionarioPanel'),
            admin: document.getElementById('adminPanel')
        };

        function updateAccessPanel() {
            const perfil = tipoAcesso.value;
            Object.entries(panels).forEach(([key, panel]) => panel.classList.toggle('active', key === perfil));
            document.body.classList.toggle('staff-mode', perfil === 'funcionario');
            document.body.classList.toggle('admin-mode', perfil === 'admin');
        }

        tipoAcesso.addEventListener('change', updateAccessPanel);
        updateAccessPanel();

        document.getElementById('loginForm').addEventListener('submit', event => {
            event.preventDefault();
            const routes = {
                cliente: '/painel',
                funcionario: '/painel-funcionario',
                admin: '/admin/dashboard'
            };
            const perfil = tipoAcesso.value;
            const requiredSelector = perfil === 'funcionario' ? '.staff-required' : perfil === 'admin' ? '.admin-required' : '';
            if (requiredSelector && [...document.querySelectorAll(requiredSelector)].some(input => !input.value.trim())) {
                esportecToast('Preencha os dados profissionais para continuar.', 'warning');
                return;
            }
            esportecToast('Login validado. Redirecionando...', 'success');
            setTimeout(() => window.location.href = routes[perfil], 700);
        });
    </script>
</body>
</html>
