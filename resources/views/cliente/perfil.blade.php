<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; --bg: #F8FAFC; --gray: #64748B; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .container-perfil { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .header { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
        .btn-back { width: 40px; height: 40px; border-radius: 10px; background: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-decoration: none; color: inherit; }
        .btn-back:hover { background: var(--light); }

        .profile-card { background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .profile-header { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; flex-wrap: wrap; }
        .avatar-upload { position: relative; width: 100px; height: 100px; }
        .avatar { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid var(--light); }
        .avatar-btn { position: absolute; bottom: 0; right: 0; width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.9rem; }
        .avatar-btn:hover { background: var(--dark); }
        .profile-info h3 { font-weight: 700; margin: 0 0 0.3rem 0; }
        .profile-info p { color: var(--gray); margin: 0; }
        .badge-member { background: var(--light); color: var(--primary); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; margin-top: 0.5rem; }

        .form-section { margin-bottom: 2rem; }
        .form-section-title { font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #E2E8F0; }
        .form-control { border-radius: 10px; padding: 0.8rem; border: 1px solid #E2E8F0; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(45,129,93,0.15); }
        .form-text { font-size: 0.8rem; color: var(--gray); }

        .form-check-switch { display: flex; align-items: center; justify-content: space-between; padding: 0.8rem 0; border-bottom: 1px solid #F1F5F9; }
        .form-check-switch:last-child { border-bottom: none; }
        .form-check-input { width: 40px; height: 22px; margin: 0; }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }

        .btn-save { background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-save:hover { background: var(--dark); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(45,129,93,0.3); }
        .btn-cancel { background: #F1F5F9; color: var(--gray); border: none; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; cursor: pointer; margin-right: 0.5rem; }
        .btn-cancel:hover { background: #E2E8F0; }

        .btn-actions { display: flex; gap: 0.5rem; justify-content: flex-end; margin-top: 2rem; }

        #perfilLoading { text-align: center; padding: 3rem 0; color: var(--gray); }
        #perfilConteudo { display: none; }
        #perfilNaoLogado { display: none; text-align: center; margin-top: 3rem; }

        @media (max-width: 576px) {
            .profile-header { flex-direction: column; text-align: center; }
            .btn-actions { flex-direction: column; }
            .btn-save, .btn-cancel { width: 100%; }
        }
    </style>
</head>
<body>

<div class="container-perfil">
    <div class="header">
        <a href="/painel" class="btn-back"><i class="bi bi-arrow-left"></i></a>
        <h2 class="fw-bold mb-0">Meu Perfil</h2>
    </div>

    <div id="perfilLoading">
        <i class="bi bi-hourglass-split me-2"></i>Carregando seu perfil...
    </div>

    <div id="perfilNaoLogado">
        <h3>Você precisa estar logado para ver o perfil.</h3>
        <a href="/login?redirect=/perfil" class="btn btn-save mt-3">Ir para Login</a>
    </div>

    <div class="profile-card" id="perfilConteudo">
        <div id="perfilAlerta" class="alert" style="background: var(--light); color: var(--primary); border-radius: 10px; margin-bottom: 1rem; display:none;">
            <i class="bi bi-check-circle me-2"></i><span id="perfilAlertaTexto"></span>
        </div>

        <div class="profile-header">
            <div class="avatar-upload">
                <img id="perfilAvatar" src="" alt="Avatar" class="avatar">
                <button class="avatar-btn" title="Alterar foto"><i class="bi bi-camera"></i></button>
            </div>
            <div class="profile-info">
                <h3 id="perfilNome"></h3>
                <p id="perfilEmail"></p>
                <span class="badge-member"><i class="bi bi-calendar-check me-1"></i>Membro desde <span id="perfilMembroDesde"></span></span>
            </div>
        </div>

        <form id="formPerfil">
            <div class="form-section">
                <h4 class="form-section-title">Dados Pessoais</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nome Completo</label>
                        <input type="text" name="nome_completo" id="inputNomeCompleto" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nome de usuário</label>
                        <input type="text" name="nome_usuario" id="inputNomeUsuario" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Data de Nascimento</label>
                        <input type="date" name="data_nascimento" id="inputDataNascimento" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Telefone</label>
                        <input type="tel" name="telefone" id="inputTelefone" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="form-section-title">Dados de Acesso</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">E-mail</label>
                        <input type="email" id="inputEmailReadonly" class="form-control" readonly style="background: #f8f9fa;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nova Senha</label>
                        <input type="password" name="nova_senha" id="inputNovaSenha" class="form-control" placeholder="Deixe em branco para manter a atual">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Confirmar Nova Senha</label>
                        <input type="password" name="nova_senha_confirmation" id="inputNovaSenhaConfirmation" class="form-control" placeholder="Repita a nova senha">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="form-section-title">Preferências e Privacidade</h4>
                <div class="form-check-switch">
                    <div>
                        <label class="fw-medium d-block">Receber ofertas por e-mail</label>
                        <small class="form-text">Promoções exclusivas e novidades</small>
                    </div>
                    <input type="checkbox" name="email_marketing" id="inputEmailMarketing" class="form-check-input">
                </div>
                <div class="alert mt-3" style="background: var(--light); color: var(--primary); border-radius: 10px; font-size: 0.9rem;">
                    <i class="bi bi-shield-check me-2"></i> Seus dados são protegidos pela <strong>LGPD</strong>.
                </div>
            </div>

            <div class="btn-actions">
                <button type="button" class="btn-cancel" onclick="window.location.href='/painel'">Cancelar</button>
                <button type="submit" class="btn-save"><i class="bi bi-check-lg me-2"></i>Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    let usuarioAtual = null;

    function preencherFormulario(usuario) {
        usuarioAtual = usuario;

        document.getElementById('perfilAvatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(usuario.nome_completo)}&background=2D815D&color=fff&size=200`;
        document.getElementById('perfilNome').textContent = usuario.nome_completo;
        document.getElementById('perfilEmail').textContent = usuario.email;
        document.getElementById('perfilMembroDesde').textContent = usuario.created_at ? new Date(usuario.created_at).getFullYear() : '';

        document.getElementById('inputNomeCompleto').value = usuario.nome_completo || '';
        document.getElementById('inputNomeUsuario').value = usuario.nome_usuario || '';
        document.getElementById('inputDataNascimento').value = usuario.data_nascimento ? usuario.data_nascimento.substring(0, 10) : '';
        document.getElementById('inputTelefone').value = usuario.telefone || '';
        document.getElementById('inputEmailReadonly').value = usuario.email || '';
        document.getElementById('inputEmailMarketing').checked = !!usuario.email_marketing;
    }

    async function carregarPerfil() {
        if (!EsporTecApi.token()) {
            document.getElementById('perfilLoading').style.display = 'none';
            document.getElementById('perfilNaoLogado').style.display = 'block';
            return;
        }

        try {
            const data = await EsporTecApi.request('/api/auth/me');
            preencherFormulario(data.usuario);
            document.getElementById('perfilLoading').style.display = 'none';
            document.getElementById('perfilConteudo').style.display = 'block';
        } catch (erro) {
            document.getElementById('perfilLoading').style.display = 'none';
            document.getElementById('perfilNaoLogado').style.display = 'block';
        }
    }

    document.getElementById('formPerfil').addEventListener('submit', async (event) => {
        event.preventDefault();

        const novaSenha = document.getElementById('inputNovaSenha').value;
        const novaSenhaConfirmation = document.getElementById('inputNovaSenhaConfirmation').value;

        if (novaSenha && novaSenha !== novaSenhaConfirmation) {
            esportecToast('As senhas não coincidem.', 'warning');
            return;
        }

        const payload = {
            nome_completo: document.getElementById('inputNomeCompleto').value,
            nome_usuario: document.getElementById('inputNomeUsuario').value,
            telefone: document.getElementById('inputTelefone').value,
            data_nascimento: document.getElementById('inputDataNascimento').value || null,
            email_marketing: document.getElementById('inputEmailMarketing').checked,
        };

        if (novaSenha) {
            payload.nova_senha = novaSenha;
            payload.nova_senha_confirmation = novaSenhaConfirmation;
        }

        try {
            const data = await EsporTecApi.request('/api/auth/perfil', {
                method: 'PUT',
                body: JSON.stringify(payload),
            });

            preencherFormulario(data.usuario);

            // Atualiza o cache local (usado pelo painel, menu, etc) para refletir
            // as mudanças sem precisar deslogar e logar novamente.
            const usuarioSalvo = JSON.parse(localStorage.getItem('esportec_user') || '{}');
            localStorage.setItem('esportec_user', JSON.stringify({ ...usuarioSalvo, ...data.usuario }));

            document.getElementById('inputNovaSenha').value = '';
            document.getElementById('inputNovaSenhaConfirmation').value = '';

            const alerta = document.getElementById('perfilAlerta');
            document.getElementById('perfilAlertaTexto').textContent = data.message;
            alerta.style.display = 'block';

            esportecToast(data.message, 'success');
        } catch (erro) {
            esportecToast(erro.message, 'warning');
        }
    });

    document.querySelector('.avatar-btn')?.addEventListener('click', function() {
        esportecToast('Funcionalidade de upload em desenvolvimento.', 'info');
    });

    carregarPerfil();
</script>
</body>
</html>