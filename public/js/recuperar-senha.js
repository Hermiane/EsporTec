(() => {
    let email = '';
    let codigoValidado = '';
    let intervalo;

    function exibirPasso(passo) {
        document.querySelectorAll('.step-content, .step-dot').forEach(elemento => elemento.classList.remove('active'));
        document.getElementById(`step-${passo}`).classList.add('active');
        document.getElementById(`dot-${passo}`).classList.add('active');
        if (passo === 2) iniciarCronometro();
    }

    function iniciarCronometro() {
        clearInterval(intervalo);
        let segundos = 15 * 60;
        const elemento = document.getElementById('timer');
        const atualizar = () => {
            elemento.textContent = segundos < 0 ? 'Expirado' : `${String(Math.floor(segundos / 60)).padStart(2, '0')}:${String(segundos % 60).padStart(2, '0')}`;
            if (segundos-- < 0) clearInterval(intervalo);
        };
        atualizar();
        intervalo = setInterval(atualizar, 1000);
    }

    function obterCodigo() {
        return [...document.querySelectorAll('.otp-input')].map(input => input.value).join('');
    }

    window.nextStep = async passo => {
        try {
            if (passo === 2) {
                email = document.querySelector('#form-step-1 input[type="email"]').value.trim().toLowerCase();
                if (!email) throw new Error('Informe seu e-mail.');
                const resposta = await EsporTecApi.request('/api/auth/recuperar-senha', { method: 'POST', body: JSON.stringify({ email }) });
                esportecToast(resposta.message, 'success');
            }
            if (passo === 3) {
                const codigo = obterCodigo();
                if (!/^\d{6}$/.test(codigo)) throw new Error('Digite os seis números do código.');
                await EsporTecApi.request('/api/auth/verificar-codigo', { method: 'POST', body: JSON.stringify({ email, codigo }) });
                codigoValidado = codigo;
            }
            exibirPasso(passo);
        } catch (erro) {
            esportecToast(erro.message, 'warning');
        }
    };

    window.resendCode = async () => {
        try {
            const resposta = await EsporTecApi.request('/api/auth/recuperar-senha', { method: 'POST', body: JSON.stringify({ email }) });
            document.querySelectorAll('.otp-input').forEach(input => { input.value = ''; });
            codigoValidado = '';
            iniciarCronometro();
            esportecToast(resposta.message, 'success');
        } catch (erro) {
            esportecToast(erro.message, 'warning');
        }
    };

    document.querySelectorAll('.otp-input').forEach((input, indice, inputs) => {
        input.inputMode = 'numeric';
        input.addEventListener('input', () => {
            input.value = input.value.replace(/\D/g, '').slice(0, 1);
            if (input.value && indice < inputs.length - 1) inputs[indice + 1].focus();
        });
        input.addEventListener('keydown', evento => {
            if (evento.key === 'Backspace' && !input.value && indice > 0) inputs[indice - 1].focus();
        });
        input.addEventListener('paste', evento => {
            const digitos = evento.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            if (digitos.length !== 6) return;
            evento.preventDefault();
            inputs.forEach((campo, posicao) => { campo.value = digitos[posicao] || ''; });
            inputs[5].focus();
        });
    });

    document.getElementById('form-step-3').addEventListener('submit', async evento => {
        evento.preventDefault();
        const campos = [...document.querySelectorAll('#form-step-3 input[type="password"]')];
        if (campos[0].value.length < 8) return esportecToast('A senha deve ter pelo menos oito caracteres.', 'warning');
        if (campos[0].value !== campos[1].value) return esportecToast('A confirmação da senha não corresponde.', 'warning');
        try {
            const resposta = await EsporTecApi.request('/api/auth/redefinir-senha', { method: 'POST', body: JSON.stringify({ email, codigo: codigoValidado, senha: campos[0].value, senha_confirmation: campos[1].value }) });
            esportecToast(resposta.message, 'success');
            setTimeout(() => { window.location.href = '/login'; }, 1200);
        } catch (erro) {
            esportecToast(erro.message, 'warning');
        }
    });
})();
