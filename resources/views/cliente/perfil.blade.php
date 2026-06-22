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

        /* Card de Perfil */
        .profile-card { background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .profile-header { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; flex-wrap: wrap; }
        .avatar-upload { position: relative; width: 100px; height: 100px; }
        .avatar { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid var(--light); }
        .avatar-btn { position: absolute; bottom: 0; right: 0; width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.9rem; }
        .avatar-btn:hover { background: var(--dark); }
        .profile-info h3 { font-weight: 700; margin: 0 0 0.3rem 0; }
        .profile-info p { color: var(--gray); margin: 0; }
        .badge-member { background: var(--light); color: var(--primary); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; margin-top: 0.5rem; }

        /* Formulário */
        .form-section { margin-bottom: 2rem; }
        .form-section-title { font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #E2E8F0; }
        .form-control, .form-select { border-radius: 10px; padding: 0.8rem; border: 1px solid #E2E8F0; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(45,129,93,0.15); }
        .form-text { font-size: 0.8rem; color: var(--gray); }

        /* Toggle Switch */
        .form-check-switch { display: flex; align-items: center; justify-content: space-between; padding: 0.8rem 0; border-bottom: 1px solid #F1F5F9; }
        .form-check-switch:last-child { border-bottom: none; }
        .form-check-input { width: 40px; height: 22px; margin: 0; }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }

        /* Botões */
        .btn-save { background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-save:hover { background: var(--dark); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(45,129,93,0.3); }
        .btn-cancel { background: #F1F5F9; color: var(--gray); border: none; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; cursor: pointer; margin-right: 0.5rem; }
        .btn-cancel:hover { background: #E2E8F0; }

        .btn-actions { display: flex; gap: 0.5rem; justify-content: flex-end; margin-top: 2rem; }

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

    <!-- Card de Perfil -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="avatar-upload">
                <img src="https://ui-avatars.com/api/?name=João+Silva&background=2D815D&color=fff&size=200" alt="Avatar" class="avatar">
                <button class="avatar-btn" title="Alterar foto"><i class="bi bi-camera"></i></button>
            </div>
            <div class="profile-info">
                <h3>João Silva</h3>
                <p>joao.silva@email.com</p>
                <span class="badge-member">🎖️ Membro desde 2024</span>
            </div>
        </div>

        <!-- Dados Pessoais -->
        <div class="form-section">
            <h4 class="form-section-title">Dados Pessoais</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Nome Completo</label>
                    <input type="text" class="form-control" value="João Silva">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Data de Nascimento</label>
                    <input type="date" class="form-control" value="1990-05-15">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Telefone</label>
                    <input type="tel" class="form-control" value="(11) 99999-9999">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">CPF</label>
                    <input type="text" class="form-control" value="123.456.789-00" disabled>
                    <small class="form-text">CPF não pode ser alterado por segurança</small>
                </div>
            </div>
        </div>

        <!-- Dados de Acesso -->
        <div class="form-section">
            <h4 class="form-section-title">Dados de Acesso</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">E-mail</label>
                    <input type="email" class="form-control" value="joao.silva@email.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Nova Senha</label>
                    <input type="password" class="form-control" placeholder="Deixe em branco para manter a atual">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" placeholder="Repita a nova senha">
                </div>
            </div>
        </div>

        <!-- Preferências e LGPD -->
        <div class="form-section">
            <h4 class="form-section-title">Preferências e Privacidade</h4>
            <div class="form-check-switch">
                <div>
                    <label class="fw-medium d-block">Receber ofertas por e-mail</label>
                    <small class="form-text">Promoções exclusivas e novidades</small>
                </div>
                <input type="checkbox" class="form-check-input" checked>
            </div>
            <div class="form-check-switch">
                <div>
                    <label class="fw-medium d-block">Receber notificações por WhatsApp</label>
                    <small class="form-text">Lembretes de reserva e confirmações</small>
                </div>
                <input type="checkbox" class="form-check-input" checked>
            </div>
            <div class="form-check-switch">
                <div>
                    <label class="fw-medium d-block">Perfil público para outros jogadores</label>
                    <small class="form-text">Permitir que outros usuários vejam seu nome em partidas</small>
                </div>
                <input type="checkbox" class="form-check-input">
            </div>
            <div class="alert mt-3" style="background: var(--light); color: var(--primary); border-radius: 10px; font-size: 0.9rem;">
                <i class="bi bi-shield-check me-2"></i> Seus dados são protegidos pela <strong>LGPD</strong>. Você pode solicitar exclusão a qualquer momento.
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="btn-actions">
            <button class="btn-cancel" onclick="window.location.href='/painel'">Cancelar</button>
            <button class="btn-save" onclick="salvarPerfil()"><i class="bi bi-check-lg me-2"></i>Salvar Alterações</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    function salvarPerfil() {
        // Simulação de salvamento
        const btn = document.querySelector('.btn-save');
        const originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Salvando...';

        setTimeout(() => {
            esportecToast('Perfil atualizado com sucesso.', 'success');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }, 1200);
    }

    // Simular upload de avatar
    document.querySelector('.avatar-btn').addEventListener('click', function() {
        const avatar = document.querySelector('.avatar-circle, .avatar');
        if (avatar) {
            avatar.src = 'https://ui-avatars.com/api/?name=Foto+Atualizada&background=1F5C42&color=fff&size=200';
        }
        esportecToast('Foto de perfil selecionada para pré-visualização.', 'success');
    });
</script>
</body>
</html>
