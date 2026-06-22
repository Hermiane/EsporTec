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
                <label class="form-label fw-medium">E-mail</label>
                <input type="email" class="form-control" placeholder="seu@email.com" required>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Telefone</label>
                    <input type="tel" class="form-control" placeholder="(00) 00000-0000">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Data de Nascimento</label>
                    <input type="date" class="form-control">
                </div>
            </div>
            <!-- Campo Endereço (RF02) -->
            <div class="mb-3">
                <label class="form-label fw-medium">Endereço Completo</label>
                <input type="text" class="form-control" placeholder="Rua, Nº, Bairro, Cidade" required>
                <small class="text-muted">Necessário para envio de ofertas e notificações.</small>
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
                    Quero receber ofertas por e-mail e aceito a <a href="#" class="auth-link">Política de Privacidade</a> (LGPD).
                </label>
            </div>
            <button type="submit" class="btn btn-primary-custom text-white">Cadastrar</button>
        </form>
        <div class="text-center mt-4">
            <p class="mb-0">Já tem conta? <a href="/login" class="auth-link">Entrar</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/esportec-ui.js"></script>
    <script>
        document.getElementById('createAccountForm').addEventListener('submit', event => {
            event.preventDefault();
            if (document.getElementById('senha').value !== document.getElementById('confirmarSenha').value) {
                esportecToast('As senhas precisam ser iguais.', 'warning');
                return;
            }
            esportecToast('Conta criada com sucesso.', 'success');
            setTimeout(() => window.location.href = '/painel', 800);
        });
    </script>
</body>
</html>
