<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Meu Perfil - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0f2a26; --secondary: #3b9cf6; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--primary); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; }
        .sidebar-brand i { font-size: 1.8rem; }
        .sidebar-brand span { font-size: 0.7rem; opacity: 0.6; display: block; margin-top: -0.2rem; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .profile-card { background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); max-width: 800px; margin: 0 auto; }
        .profile-header { text-align: center; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 2px solid #F1F5F9; }
        .avatar { width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, var(--secondary), #60A5FA); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white; margin: 0 auto 1rem; font-weight: 700; }
        .badge-role { background: var(--secondary); color: white; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; }
        .info-row { display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #F1F5F9; align-items: center; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-weight: 500; color: #64748B; display: flex; align-items: center; gap: 0.4rem; }
        .info-value { font-weight: 600; }
        .btn-edit { background: var(--secondary); color: white; border: none; padding: 0.8rem 2rem; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 1.5rem; width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .btn-edit:hover { background: #2563EB; }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/painel-funcionario" class="sidebar-brand"><i class="bi bi-trophy"></i><div>EsporTec</div></a>
        <nav>
            <a href="/painel-funcionario" class="nav-link"><i class="bi bi-grid"></i> Agenda do Dia</a>
            <a href="/funcionario/perfil" class="nav-link active"><i class="bi bi-person"></i> Meu Perfil</a>
            <a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a>
        </nav>
    </aside>
    <main class="main">
        <div class="profile-card">
            <div class="profile-header">
                <div class="avatar" id="perfilAvatar">--</div>
                <h2 class="fw-bold mb-2" id="perfilNome">Carregando...</h2>
                <span class="badge-role"><i class="bi bi-person-badge"></i> <span id="perfilCargo">Funcionário</span></span>
                <p class="text-muted mt-2 mb-0">Matrícula: <span id="perfilMatricula">N/A</span></p>
            </div>
            <div class="info-row"><span class="info-label"><i class="bi bi-envelope"></i> E-mail</span><span class="info-value" id="perfilEmail">-</span></div>
            <div class="info-row"><span class="info-label"><i class="bi bi-phone"></i> Telefone</span><span class="info-value" id="perfilTelefone">-</span></div>
            <div class="info-row"><span class="info-label"><i class="bi bi-building"></i> Arena</span><span class="info-value" id="perfilArena">-</span></div>
            <div class="info-row"><span class="info-label"><i class="bi bi-clock"></i> Turno</span><span class="info-value" id="perfilTurno">-</span></div>
            <div class="info-row"><span class="info-label"><i class="bi bi-calendar-check"></i> Data de Admissão</span><span class="info-value" id="perfilAdmissao">-</span></div>
            <div class="info-row"><span class="info-label"><i class="bi bi-check-circle"></i> Status</span><span class="info-value" id="perfilStatus">-</span></div>
            <div class="info-row"><span class="info-label"><i class="bi bi-lock"></i> Permissões</span><span class="info-value" id="perfilPermissoes">-</span></div>
            <!--  BOTÃO EDITAR PERFIL -->
            <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditarPerfil"><i class="bi bi-pencil"></i>Editar Perfil</button>
        </div>
    </main>
</div>

<!--  MODAL DE EDIÇÃO -->
<div class="modal fade" id="modalEditarPerfil" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold"><i class="bi bi-person-gear me-2"></i>Editar perfil profissional</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <label class="form-label"><i class="bi bi-phone me-1"></i>Telefone</label>
            <input class="form-control mb-3" id="editTelefone" placeholder="(00) 00000-0000">
            <label class="form-label"><i class="bi bi-clock me-1"></i>Turno</label>
            <select class="form-select mb-3" id="editTurno">
                <option value="manha">Manhã (07:00 - 15:00)</option>
                <option value="tarde">Tarde (12:00 - 20:00)</option>
                <option value="noite">Noite (15:00 - 23:00)</option>
                <option value="integral">Integral</option>
            </select>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-primary" id="btnSalvarPerfil"><i class="bi bi-check-lg me-1"></i>Salvar</button></div>
    </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    const formatarTelefone = tel => tel?.length === 11 ? tel.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3') : (tel || '-');
    const formatarData = data => data ? new Date(`${data}T00:00:00`).toLocaleDateString('pt-BR') : '-';
    const rotuloTurno = { manha: 'Manhã (07:00 - 15:00)', tarde: 'Tarde (12:00 - 20:00)', noite: 'Noite (15:00 - 23:00)', integral: 'Integral' };

    async function carregarPerfil() {
        try {
            const dados = await EsporTecApi.request('/api/funcionario/perfil');
            const vinculos = dados.vinculos || [];
            const permissoes = [...new Set(vinculos.flatMap(v => v.permissoes || []))];
            const primeiroVinculo = vinculos[0] || {};

            document.getElementById('perfilNome').textContent = dados.usuario?.nome_completo || dados.usuario?.nome || 'Funcionário';
            document.getElementById('perfilAvatar').textContent = (dados.usuario?.nome_completo || dados.usuario?.nome || 'F').split(' ').map(p => p[0]).join('').slice(0, 2).toUpperCase();
            document.getElementById('perfilCargo').textContent = primeiroVinculo.cargo || 'Funcionário';
            document.getElementById('perfilMatricula').textContent = primeiroVinculo.matricula || 'N/A';
            document.getElementById('perfilEmail').textContent = dados.usuario?.email || '-';
            document.getElementById('perfilTelefone').textContent = formatarTelefone(dados.usuario?.telefone);
            document.getElementById('perfilArena').textContent = vinculos.map(v => v.arena?.nome).filter(Boolean).join(', ') || '-';
            document.getElementById('perfilTurno').textContent = rotuloTurno[primeiroVinculo.turno] || primeiroVinculo.turno || '-';
            document.getElementById('perfilAdmissao').textContent = formatarData(primeiroVinculo.data_entrada);
            document.getElementById('perfilStatus').textContent = (dados.usuario?.ativo && vinculos.some(v => v.ativo)) ? 'Ativo' : 'Inativo';
            document.getElementById('perfilStatus').style.color = dados.usuario?.ativo ? '#10B981' : '#DC2626';
            document.getElementById('perfilPermissoes').textContent = permissoes.join(', ') || 'Permissões padrão';

            // Preenche modal com valores atuais
            document.getElementById('editTelefone').value = dados.usuario?.telefone || '';
            document.getElementById('editTurno').value = primeiroVinculo.turno || 'tarde';
        } catch (error) {
            console.error('Erro ao carregar perfil:', error);
            esportecToast('Não foi possível carregar o perfil.', 'error');
        }
    }

    //  SALVAR PERFIL NO BANCO
    document.getElementById('btnSalvarPerfil').addEventListener('click', async () => {
        const telefone = document.getElementById('editTelefone').value;
        const turno = document.getElementById('editTurno').value;
        
        try {
            await EsporTecApi.request('/api/funcionario/perfil', {
                method: 'PATCH',
                body: JSON.stringify({ telefone, turno })
            });
            bootstrap.Modal.getInstance(document.getElementById('modalEditarPerfil')).hide();
            esportecToast('Perfil atualizado com sucesso!', 'success');
            carregarPerfil(); // Recarrega com dados atualizados
        } catch (error) {
            console.error('Erro ao salvar:', error);
            esportecToast('Erro ao salvar. Tente novamente.', 'error');
        }
    });

    document.addEventListener('DOMContentLoaded', carregarPerfil);
</script>
</body>
</html>