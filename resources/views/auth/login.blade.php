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
        .auth-card { background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); padding: 2.5rem; width: 100%; max-width: 440px; }
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
        <form>
            @csrf
            <div class="mb-3">
                <label class="form-label fw-medium">E-mail</label>
                <input type="email" class="form-control" placeholder="seu@email.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Senha</label>
                <input type="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Lembrar de mim</label>
                </div>
                <a href="/recuperar-senha" class="auth-link small">Esqueci a senha</a>
            </div>
            <button type="submit" class="btn btn-primary-custom text-white">Entrar</button>
        </form>
        <div class="text-center mt-4">
            <p class="mb-0">Não tem conta? <a href="/cadastro" class="auth-link">Criar conta</a></p>
        </div>
    </div>
</body>
</html>