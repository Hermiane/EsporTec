<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; --text: #24364A; --muted: #64748B; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #E8F5EE 0%, #FFFFFF 52%, #F8FAFC 100%); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; color: var(--text); }
        body.staff-mode { background: linear-gradient(135deg, #E8F5EE 0%, #EEF2FF 55%, #FFFFFF 100%); }
        body.admin-mode { background: linear-gradient(135deg, #E8F5EE 0%, #F1F5F9 55%, #FFFFFF 100%); }
        body.super-admin-mode { background: linear-gradient(135deg, #FEF3C7 0%, #FFFFFF 55%, #F8FAFC 100%); }
        .auth-card { background: rgba(255,255,255,0.96); border-radius: 18px; box-shadow: 0 18px 50px rgba(15,23,42,0.12); padding: 2.25rem; width: 100%; max-width: 560px; border: 1px solid rgba(45,129,93,0.14); }
        .brand-mark { width: 52px; height: 52px; margin: 0 auto 0.8rem; border-radius: 16px; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; box-shadow: 0 10px 24px rgba(45,129,93,0.22); }
        .access-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 0.75rem; margin-bottom: 1rem; }
        .access-option input { display: none; }
        .access-card { height: 100%; border: 1px solid #E2E8F0; border-radius: 14px; padding: 0.9rem 0.75rem; cursor: pointer; background: #FFFFFF; display: flex; flex-direction: column; gap: 0.4rem; align-items: flex-start; transition: all 0.2s ease; }
        .access-card i { width: 34px; height: 34px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background: var(--light); color: var(--primary); font-size: 1.1rem; }
        .access-card strong { font-size: 0.92rem; }
        .access-card small { color: var(--muted); line-height: 1.25; }
        .access-option input:checked + .access-card { border-color: var(--primary); background: var(--light); box-shadow: 0 8px 22px rgba(45,129,93,0.14); }
        .access-option input:checked + .access-card i { background: var(--primary); color: white; }
        .access-panel { background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 1rem; margin-bottom: 1rem; display: none; }
        .access-panel.active { display: block; }
        .access-badge { display: inline-flex; align-items: center; gap: 0.45rem; background: var(--light); color: var(--primary); border-radius: 999px; padding: 0.4rem 0.8rem; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.55rem; }
        .access-description { color: var(--muted); font-size: 0.9rem; margin-bottom: 0.9rem; }
        .staff-mode .access-badge { background: #DBEAFE; color: #1565C0; }
        .admin-mode .access-badge { background: #E2E8F0; color: #0F172A; }
        .super-admin-mode .access-badge { background: #FEF3C7; color: #92400E; }
        .form-control { border-radius: 10px; padding: 0.9rem; border: 1px solid #e0e0e0; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(45, 129, 93, 0.15); }
        .btn-primary-custom { background: var(--primary); border: none; padding: 0.9rem; border-radius: 10px; font-weight: 600; width: 100%; }
        .btn-primary-custom:hover { background: var(--dark); }
        .auth-link { color: var(--primary); text-decoration: none; font-weight: 500; }
        .auth-link:hover { text-decoration: underline; }
        .login-support { background: #F8FAFC; border-radius: 12px; padding: 0.75rem; font-size: 0.85rem; color: var(--muted); }
        @media (max-width: 576px) {
            .auth-card { padding: 1.5rem; }
            .access-card { flex-direction: row; align-items: center; }
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <div class="brand-mark">
                <i class="bi bi-dribbble"></i>
            </div>
            <h2 class="fw-bold" style="color: var(--primary);">EsporTec</h2>
            <p class="text-muted">Entre na sua conta para continuar</p>
        </div>

        <form id="loginForm">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-medium">E-mail</label>
                <input type="email" class="form-control" placeholder="seu@email.com" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium">Senha</label>
                <input type="password" class="form-control" placeholder="Digite sua senha" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium">Escolha seu tipo de acesso</label>
                <div class="access-grid" id="tipoAcesso">
                    <label class="access-option">
                        <input type="radio" name="tipo-acesso" value="cliente" checked>
                        <span class="access-card">
                            <i class="bi bi-person"></i>
                            <strong>Cliente</strong>
                            <small>Reservas e histórico</small>
                        </span>
                    </label>
                    <label class="access-option">
                        <input type="radio" name="tipo-acesso" value="funcionario">
                        <span class="access-card">
                            <i class="bi bi-headset"></i>
                            <strong>Funcionário</strong>
                            <small>Agenda e balcão</small>
                        </span>
                    </label>
                    <label class="access-option">
                        <input type="radio" name="tipo-acesso" value="admin">
                        <span class="access-card">
                            <i class="bi bi-shield-lock"></i>
                            <strong>Admin da arena</strong>
                            <small>Dono ou gestor</small>
                        </span>
                    </label>
                    <label class="access-option">
                        <input type="radio" name="tipo-acesso" value="super_admin">
                        <span class="access-card">
                            <i class="bi bi-stars"></i>
                            <strong>Super admin</strong>
                            <small>Plataforma EsporTec</small>
                        </span>
                    </label>
                </div>
            </div>

            <div class="access-panel active" id="clientePanel">
                <span class="access-badge"><i class="bi bi-person-check"></i>Área do cliente</span>
                <p class="access-description">Acesso para reservar quadras, acompanhar histórico, pagamentos, notificações e perfil.</p>
            </div>
            <div class="access-panel" id="funcionarioPanel">
                <span class="access-badge"><i class="bi bi-calendar-check"></i>Área do funcionário</span>
                <p class="access-description">Acesso para controlar agenda, confirmar check-in, registrar pagamentos presenciais e acompanhar reservas do dia.</p>
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
                <span class="access-badge"><i class="bi bi-speedometer2"></i>Admin da arena</span>
                <p class="access-description">Acesso para o proprietário ou gestor administrar a própria arena: agendamentos, financeiro, quadras, equipe, clientes e configurações.</p>
                <div class="login-support">
                    <i class="bi bi-building me-1"></i>
                    O acesso é liberado automaticamente para o dono ou gestor vinculado a uma arena aprovada.
                </div>
            </div>
            <div class="access-panel" id="superAdminPanel">
                <span class="access-badge"><i class="bi bi-stars"></i>Super admin da plataforma</span>
                <p class="access-description">Acesso para quem mantém o SaaS EsporTec: cadastrar arenas, acompanhar proprietários, planos, suporte e logs globais.</p>
                <div class="login-support mb-0">
                    <i class="bi bi-shield-check me-1"></i>
                    O acesso é liberado automaticamente para contas cadastradas como superadministradoras.
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Manter conectado neste dispositivo</label>
                </div>
                <a href="/recuperar-senha" class="auth-link small">Esqueci a senha</a>
            </div>

            <button type="submit" class="btn btn-primary-custom text-white">
                Entrar
            </button>
        </form>

        <div class="login-support mt-3">
            <i class="bi bi-info-circle me-1"></i>
            Cliente reserva quadras. Funcionário opera a arena. Admin gerencia a arena. Super admin controla a plataforma EsporTec.
        </div>
        <div class="text-center mt-4">
            <p class="mb-0">Não tem conta? <a href="/criar-conta" class="auth-link">Criar conta</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/esportec-ui.js"></script>
    <script src="/js/esportec-api.js"></script>
    <script>
        const accessInputs = document.querySelectorAll('input[name="tipo-acesso"]');
        const panels = {
            cliente: document.getElementById('clientePanel'),
            funcionario: document.getElementById('funcionarioPanel'),
            admin: document.getElementById('adminPanel'),
            super_admin: document.getElementById('superAdminPanel')
        };

        function getSelectedPerfil() {
            return document.querySelector('input[name="tipo-acesso"]:checked').value;
        }

        function updateAccessPanel() {
            const perfil = getSelectedPerfil();
            Object.entries(panels).forEach(([key, panel]) => panel.classList.toggle('active', key === perfil));
            document.body.classList.toggle('staff-mode', perfil === 'funcionario');
            document.body.classList.toggle('admin-mode', perfil === 'admin');
            document.body.classList.toggle('super-admin-mode', perfil === 'super_admin');
        }

        accessInputs.forEach(input => input.addEventListener('change', updateAccessPanel));
        updateAccessPanel();

        document.getElementById('loginForm').addEventListener('submit', event => {
            event.preventDefault();
            const submitButton = event.submitter;
            const redirectTo = new URLSearchParams(window.location.search).get('redirect');
            const clientRoutes = ['/painel', '/nova-reserva', '/minhas-reservas', '/notificacoes', '/perfil'];
            const safeClientRedirect = clientRoutes.includes(redirectTo) ? redirectTo : '/painel';
            const routes = {
                cliente: safeClientRedirect,
                funcionario: '/painel-funcionario',
                admin: '/admin/dashboard',
                super_admin: '/super-admin/dashboard'
            };
            const perfil = getSelectedPerfil();
            const requiredSelector = perfil === 'funcionario' ? '.staff-required' : '';
            if (requiredSelector && [...document.querySelectorAll(requiredSelector)].some(input => !input.value.trim())) {
                esportecToast('Preencha os dados profissionais para continuar.', 'warning');
                return;
            }
            const email = document.querySelector('#loginForm input[type="email"]').value;
            const senha = document.querySelector('#loginForm input[type="password"]').value;
            esportecWithLoading(submitButton, 'Entrando...', async () => {
                const data = await EsporTecApi.request('/api/auth/login', { method: 'POST', body: JSON.stringify({ email, senha, tipo_acesso: perfil }) });
                EsporTecApi.saveSession(data);
                return data;
            }).then(data => { sessionStorage.setItem('esportecRole', data.acesso_atual); window.location.href = routes[data.acesso_atual]; }).catch(error => esportecToast(error.message, 'warning'));
        });
    </script>
</body>
</html>
