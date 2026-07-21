<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; }
        body { font-family: 'Poppins', sans-serif; background: var(--light); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .auth-card { background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); padding: 2.5rem; width: 100%; max-width: 480px; }
        .form-control { border-radius: 10px; padding: 0.9rem; border: 1px solid #e0e0e0; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(45, 129, 93, 0.15); }
        .btn-primary-custom { background: var(--primary); border: none; padding: 0.9rem; border-radius: 10px; font-weight: 600; width: 100%; }
        .btn-primary-custom:hover { background: var(--dark); }
        .auth-link { color: var(--primary); text-decoration: none; font-weight: 500; }
        .auth-link:hover { text-decoration: underline; }
        .step-indicator { display: flex; justify-content: center; gap: 8px; margin-bottom: 2rem; }
        .step-dot { width: 12px; height: 12px; border-radius: 50%; background: #ddd; transition: all 0.3s; }
        .step-dot.active { background: var(--primary); transform: scale(1.2); }
        .otp-inputs { display: flex; gap: 8px; justify-content: center; margin: 1.5rem 0; }
        .otp-input { width: 50px; height: 60px; text-align: center; font-size: 1.5rem; border-radius: 10px; border: 2px solid #e0e0e0; }
        .otp-input:focus { border-color: var(--primary); outline: none; }
        .step-content { display: none; }
        .step-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: var(--primary);">EsporTec</h2>
            <p class="text-muted">Recupere sua senha em 3 passos</p>
        </div>

        <!-- Indicador de passos -->
        <div class="step-indicator">
            <div class="step-dot active" id="dot-1"></div>
            <div class="step-dot" id="dot-2"></div>
            <div class="step-dot" id="dot-3"></div>
        </div>

        <!-- Passo 1: E-mail -->
        <div class="step-content active" id="step-1">
            <form id="form-step-1">
                <div class="mb-4">
                    <label class="form-label fw-medium">Digite seu e-mail</label>
                    <input type="email" class="form-control" placeholder="seu@email.com" required>
                    <small class="text-muted">Enviaremos um código de verificação</small>
                </div>
                <button type="button" class="btn btn-primary-custom text-white" onclick="nextStep(2)">Enviar Código</button>
            </form>
        </div>

        <!-- Passo 2: Código -->
        <div class="step-content" id="step-2">
            <form id="form-step-2">
                <div class="mb-4 text-center">
                    <label class="form-label fw-medium">Digite o código recebido</label>
                    <div class="otp-inputs">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                    </div>
                    <small class="text-muted">Código expira em <strong id="timer">02:00</strong></small>
                </div>
                <button type="button" class="btn btn-primary-custom text-white" onclick="nextStep(3)">Verificar Código</button>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-link auth-link small p-0" onclick="resendCode()">Reenviar código</button>
                </div>
            </form>
        </div>

        <!-- Passo 3: Nova Senha -->
        <div class="step-content" id="step-3">
            <form id="form-step-3">
                <div class="mb-3">
                    <label class="form-label fw-medium">Nova Senha</label>
                    <input type="password" class="form-control" placeholder="••••••••" required minlength="6">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-medium">Confirmar Senha</label>
                    <input type="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary-custom text-white">Salvar Nova Senha</button>
            </form>
        </div>

        <div class="text-center mt-4">
            <p class="mb-0">Lembrou a senha? <a href="/login" class="auth-link">Voltar para login</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/esportec-ui.js"></script>
    <script src="/js/esportec-api.js"></script>
    <script>
        function nextStep(step) {
            // Esconde todos os passos
            document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.step-dot').forEach(el => el.classList.remove('active'));

            // Mostra o passo atual
            document.getElementById('step-' + step).classList.add('active');
            document.getElementById('dot-' + step).classList.add('active');

            // Inicia timer se for passo 2
            if (step === 2) startTimer();
        }

        function startTimer() {
            let time = 120; // 2 minutos
            const timerEl = document.getElementById('timer');
            const interval = setInterval(() => {
                const mins = Math.floor(time / 60);
                const secs = time % 60;
                timerEl.textContent = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                time--;
                if (time < 0) {
                    clearInterval(interval);
                    timerEl.textContent = 'Expirado';
                }
            }, 1000);
        }

        function resendCode() {
            esportecToast('Código reenviado. Verifique seu e-mail.', 'success');
            startTimer();
        }

        // Auto-focus nos campos OTP
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', function() {
                if (this.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        // Submit do último passo
        document.getElementById('form-step-3').addEventListener('submit', function(e) {
            e.preventDefault();
            esportecToast('Senha alterada com sucesso. Redirecionando para login...', 'success');
            setTimeout(() => window.location.href = '/login', 1500);
        });
    </script>
    <script>
        let emailReset = '';
        const mudarPasso = step => {
            document.querySelectorAll('.step-content,.step-dot').forEach(el => el.classList.remove('active'));
            document.getElementById(`step-${step}`).classList.add('active'); document.getElementById(`dot-${step}`).classList.add('active');
            if (step === 2) startTimer();
        };
        window.nextStep = async step => {
            try {
                if (step === 2) { emailReset = document.querySelector('#form-step-1 input[type="email"]').value; if (!emailReset) throw new Error('Informe seu e-mail.'); await EsporTecApi.request('/api/auth/recuperar-senha',{method:'POST',body:JSON.stringify({email:emailReset})}); }
                if (step === 3) { const codigo=[...document.querySelectorAll('.otp-input')].map(i=>i.value).join(''); if (!/^\d{6}$/.test(codigo)) throw new Error('Digite os 6 números do código.'); await EsporTecApi.request('/api/auth/verificar-codigo',{method:'POST',body:JSON.stringify({email:emailReset,codigo})}); }
                mudarPasso(step);
            } catch (error) { esportecToast(error.message,'warning'); }
        };
        document.getElementById('form-step-3').addEventListener('submit', async event => { event.preventDefault(); event.stopImmediatePropagation(); const senhas=[...document.querySelectorAll('#form-step-3 input')]; const codigo=[...document.querySelectorAll('.otp-input')].map(i=>i.value).join(''); try { await EsporTecApi.request('/api/auth/redefinir-senha',{method:'POST',body:JSON.stringify({email:emailReset,codigo,senha:senhas[0].value,senha_confirmation:senhas[1].value})}); window.location.href='/login'; } catch(error) { esportecToast(error.message,'warning'); } }, true);
    </script>
</body>
</html>
