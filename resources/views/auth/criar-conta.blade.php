<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; }
        body { font-family: 'Poppins', sans-serif; background: var(--light); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .auth-card { background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); padding: 2.5rem; width: 100%; max-width: 520px; }
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
            <h2 class="fw-bold" style="color: var(--primary);">Criar Conta</h2>
            <p class="text-muted">Preencha seus dados para começar</p>
        </div>
        <form id="createAccountForm">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-medium">Nome Completo</label>
                <input type="text" class="form-control" placeholder="Seu nome" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Nome de usuário</label>
                <input type="text" class="form-control" placeholder="Ex: joao.silva" required>
                <small class="text-muted">Campo obrigatório no banco para identificar sua conta.</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">E-mail</label>
                <input type="email" class="form-control" placeholder="seu@email.com" required>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Telefone</label>
                    <input type="tel" class="form-control" placeholder="(00) 00000-0000" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Data de Nascimento</label>
                    <input type="date" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Senha</label>
                    <input type="password" class="form-control" id="senha" placeholder="••••••••" required minlength="6">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Confirmar Senha</label>
                    <input type="password" class="form-control" id="confirmarSenha" placeholder="••••••••" required minlength="6">
                </div>
            </div>
            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="lgpd" required>
                <label class="form-check-label small text-muted" for="lgpd">
                    Quero receber ofertas por e-mail e aceito a <a href="#modalPrivacidade" class="auth-link" data-bs-toggle="modal" data-bs-target="#modalPrivacidade">Política de Privacidade</a> (LGPD).
                </label>
            </div>
            <button type="submit" class="btn btn-primary-custom text-white">Cadastrar</button>
        </form>
        <div class="text-center mt-4">
            <p class="mb-0">Já tem conta? <a href="/login" class="auth-link">Entrar</a></p>
        </div>
    </div>
    <div class="modal fade" id="modalPrivacidade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Política de Privacidade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-0">Seus dados serão usados para cadastro, reservas, notificações e ofertas autorizadas, respeitando a LGPD.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary-custom text-white" data-bs-dismiss="modal">Entendi</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/esportec-ui.js"></script>
    <script src="/js/esportec-api.js"></script>
    <script>
        document.getElementById('createAccountForm').addEventListener('submit', event => {
            event.preventDefault();
            const submitButton = event.submitter;
            if (document.getElementById('senha').value !== document.getElementById('confirmarSenha').value) {
                esportecToast('As senhas precisam ser iguais.', 'warning');
                return;
            }
            const inputs = document.querySelectorAll('#createAccountForm input');
            const payload = { nome_completo: inputs[1].value, nome_usuario: inputs[2].value, email: inputs[3].value, telefone: inputs[4].value.replace(/\D/g, ''), data_nascimento: inputs[5].value, senha: document.getElementById('senha').value, senha_confirmation: document.getElementById('confirmarSenha').value };
            esportecWithLoading(submitButton, 'Cadastrando...', async () => { const data = await EsporTecApi.request('/api/auth/registro', { method: 'POST', body: JSON.stringify(payload) }); EsporTecApi.saveSession(data); }).then(() => { sessionStorage.setItem('esportecRole', 'cliente'); window.location.replace('/painel'); }).catch(error => esportecToast(error.message, 'warning'));
        });
</script>
</body>
</html>
