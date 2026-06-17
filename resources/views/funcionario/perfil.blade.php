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
        :root { --primary: #0F172A; --secondary: #3B82F6; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--primary); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .profile-card { background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); max-width: 800px; margin: 0 auto; }
        .profile-header { text-align: center; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 2px solid #F1F5F9; }
        .avatar { width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, var(--secondary), #60A5FA); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white; margin: 0 auto 1rem; font-weight: 700; }
        .badge-role { background: var(--secondary); color: white; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
        .info-row { display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #F1F5F9; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-weight: 500; color: #64748B; }
        .info-value { font-weight: 600; }
        .btn-edit { background: var(--secondary); color: white; border: none; padding: 0.8rem 2rem; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 1.5rem; width: 100%; }
        .btn-edit:hover { background: #2563EB; }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/painel-funcionario" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.6;">STAFF</span></a>
        <nav>
            <a href="/painel-funcionario" class="nav-link"><i class="bi bi-grid"></i> Agenda do Dia</a>
            <a href="/funcionario/perfil" class="nav-link active"><i class="bi bi-person"></i> Meu Perfil</a>
            <a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a>
        </nav>
    </aside>
    
    <main class="main">
        <div class="profile-card">
            <div class="profile-header">
                <div class="avatar">MS</div>
                <h2 class="fw-bold mb-2">Maria Silva</h2>
                <span class="badge-role">👨‍💼 Funcionário</span>
                <p class="text-muted mt-2 mb-0">Matrícula: FUNC-2024-089</p>
            </div>
            
            <div class="info-row">
                <span class="info-label">📧 E-mail</span>
                <span class="info-value">maria.silva@esportec.com.br</span>
            </div>
            <div class="info-row">
                <span class="info-label">📱 Telefone</span>
                <span class="info-value">(11) 98765-4321</span>
            </div>
            <div class="info-row">
                <span class="info-label">🎂 Data de Nascimento</span>
                <span class="info-value">15/03/1995</span>
            </div>
            <div class="info-row">
                <span class="info-label">🏢 Arena</span>
                <span class="info-value">EsporTec - Unidade Principal</span>
            </div>
            <div class="info-row">
                <span class="info-label">🕐 Turno</span>
                <span class="info-value">Tarde (12:00 - 20:00)</span>
            </div>
            <div class="info-row">
                <span class="info-label">📅 Data de Admissão</span>
                <span class="info-value">10/01/2024</span>
            </div>
            <div class="info-row">
                <span class="info-label">✅ Status</span>
                <span class="info-value" style="color: #10B981;">Ativo</span>
            </div>
            <div class="info-row">
                <span class="info-label">🔐 Permissões</span>
                <span class="info-value">Agendar, Confirmar, Cancelar</span>
            </div>
            
            <button class="btn-edit" onclick="alert('✏️ Edição de perfil será implementada com o backend')">
                <i class="bi bi-pencil me-2"></i>Editar Perfil
            </button>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>