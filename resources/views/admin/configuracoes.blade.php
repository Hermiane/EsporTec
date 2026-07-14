<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-dark: #0F172A; --primary: #3B82F6; --success: #10B981; --warning: #F59E0B; --danger: #EF4444; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; color: var(--admin-dark); margin: 0; }
        .settings-container { max-width: 1000px; }
        .settings-card { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .settings-title { font-weight: 600; font-size: 1.2rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #F1F5F9; display: flex; align-items: center; gap: 0.5rem; }
        .form-label { font-weight: 500; margin-bottom: 0.5rem; }
        .form-control, .form-select { border-radius: 8px; padding: 0.7rem; border: 1px solid #E2E8F0; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
        .help-text { font-size: 0.85rem; color: #64748B; margin-top: 0.3rem; }
        .btn-save { background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; margin-left: auto; }
        .btn-save:hover { background: #2563EB; }
        .toggle-switch { display: flex; align-items: center; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #F1F5F9; }
        .toggle-switch:last-child { border-bottom: none; }
        .form-check-input { width: 48px; height: 24px; cursor: pointer; }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.75;">Admin da arena</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link active"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1><i class="bi bi-gear-wide-connected me-2"></i>Configurações da Arena</h1>
                <p class="text-muted mb-0">Dados que o proprietário/gestor controla para a própria arena.</p>
            </div>
            <span class="badge bg-success">Admin da arena</span>
        </div>

        <div class="settings-container">
            <!-- Dados da Arena -->
            <div class="settings-card">
                <div class="settings-title"><i class="bi bi-building"></i> Dados da Arena</div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome da Arena</label>
                        <input type="text" class="form-control" value="EsporTec Arena">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CNPJ</label>
                        <input type="text" class="form-control" placeholder="00.000.000/0001-00">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Logradouro</label>
                        <input type="text" class="form-control" value="Rua dos Esportes">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Número</label>
                        <input type="text" class="form-control" value="123">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Bairro</label>
                        <input type="text" class="form-control" value="Centro">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Cidade</label>
                        <input type="text" class="form-control" value="São Paulo">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">UF</label>
                        <input type="text" class="form-control" value="SP" maxlength="2">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Ponto de referência</label>
                        <input type="text" class="form-control" placeholder="Ex: próximo ao ginásio">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control" value="(11) 99999-9999">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">E-mail de Contato</label>
                        <input type="email" class="form-control" value="contato@esportec.com.br">
                    </div>
                </div>
            </div>

            <!-- Horários de Funcionamento -->
            <div class="settings-card">
                <div class="settings-title"><i class="bi bi-clock"></i> Horários de Funcionamento</div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Horário de Abertura</label>
                        <input type="time" class="form-control" value="07:00">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Horário de Fechamento</label>
                        <input type="time" class="form-control" value="23:00">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dias de Funcionamento</label>
                    <select class="form-select" multiple size="3">
                        <option selected>Domingo</option>
                        <option selected>Segunda-feira</option>
                        <option selected>Terça-feira</option>
                        <option selected>Quarta-feira</option>
                        <option selected>Quinta-feira</option>
                        <option selected>Sexta-feira</option>
                        <option selected>Sábado</option>
                    </select>
                    <div class="help-text">Segure Ctrl para selecionar múltiplos dias</div>
                </div>
            </div>

            <!-- Regras de Reserva -->
            <div class="settings-card">
                <div class="settings-title"><i class="bi bi-calendar3"></i> Regras de Reserva</div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Antecedência Mínima (horas)</label>
                        <input type="number" class="form-control" value="1" min="0">
                        <div class="help-text">Quanto tempo antes o cliente pode reservar</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Multa por Cancelamento (%)</label>
                        <input type="number" class="form-control" value="10" min="0" max="100">
                        <div class="help-text">Porcentagem cobrada em cancelamentos tardios</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Duração Padrão da Reserva (minutos)</label>
                        <input type="number" class="form-control" value="60" step="30">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Máximo de Reservas por Cliente</label>
                        <input type="number" class="form-control" value="3" min="1">
                        <div class="help-text">Limite de reservas simultâneas</div>
                    </div>
                </div>
            </div>

            <!-- Configurações Financeiras e Pagamento -->
            <div class="settings-card">
                <div class="settings-title"><i class="bi bi-credit-card"></i> Formas de Pagamento e PIX</div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Aceitar PIX</div>
                        <div class="help-text">Pagamento instantâneo via QR Code</div>
                    </div>
                    <input type="checkbox" class="form-check-input" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Aceitar Cartão de Crédito</div>
                        <div class="help-text">Pagamento presencial ou online</div>
                    </div>
                    <input type="checkbox" class="form-check-input" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Aceitar Cartão de Débito</div>
                        <div class="help-text">Pagamento presencial na arena</div>
                    </div>
                    <input type="checkbox" class="form-check-input" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Aceitar Dinheiro</div>
                        <div class="help-text">Pagamento em espécie no local</div>
                    </div>
                    <input type="checkbox" class="form-check-input" checked>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Tipo da chave PIX</label>
                        <select class="form-select">
                            <option>CNPJ</option>
                            <option>CPF</option>
                            <option>E-mail</option>
                            <option>Telefone</option>
                            <option>Aleatória</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Chave PIX</label>
                        <input type="text" class="form-control" placeholder="CNPJ, e-mail ou telefone">
                        <div class="help-text">Chave para recebimento via PIX</div>
                    </div>
                </div>
            </div>

            <!-- Notificações -->
            <div class="settings-card">
                <div class="settings-title"><i class="bi bi-bell"></i> Notificações e Feedback</div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Enviar Confirmação por E-mail</div>
                        <div class="help-text">Envia e-mail automático ao confirmar reserva</div>
                    </div>
                    <input type="checkbox" class="form-check-input" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Lembrete Automático</div>
                        <div class="help-text">Enviar lembrete antes da partida</div>
                    </div>
                    <input type="checkbox" class="form-check-input" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Solicitar Feedback Pós-Jogo</div>
                        <div class="help-text">Envia formulário de avaliação após a partida</div>
                    </div>
                    <input type="checkbox" class="form-check-input" checked>
                </div>
            </div>

            <!-- Segurança -->
            <div class="settings-card">
                <div class="settings-title"><i class="bi bi-shield-lock"></i> Segurança e Acesso</div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tempo de Expiração do Código (minutos)</label>
                        <input type="number" class="form-control" value="15" min="5" max="60">
                        <div class="help-text">Tempo válido para redefinição de senha</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Máximo de Tentativas de Login</label>
                        <input type="number" class="form-control" value="5" min="1" max="10">
                        <div class="help-text">Bloqueia a conta após X tentativas falhas</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tempo de Bloqueio (minutos)</label>
                        <input type="number" class="form-control" value="15" min="5">
                        <div class="help-text">Duração do bloqueio após muitas tentativas</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Duração da Sessão (dias)</label>
                        <input type="number" class="form-control" value="30" min="1">
                        <div class="help-text">Tempo até exigir novo login</div>
                    </div>
                </div>
            </div>

            <!-- Botão Salvar -->
            <div class="text-end mt-4">
                <button class="btn-save" id="btnSalvarConfiguracoes">
                    <i class="bi bi-check-lg"></i> Salvar Configurações
                </button>
            </div>
            <div class="alert alert-success mt-3 d-none" id="configResumo">
                <i class="bi bi-check-circle me-2"></i>Configurações aplicadas nesta tela.
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    document.getElementById('btnSalvarConfiguracoes').addEventListener('click', () => {
        const button = document.getElementById('btnSalvarConfiguracoes');
        const original = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="bi bi-hourglass-split"></i> Salvando...';
        setTimeout(() => {
            button.disabled = false;
            button.innerHTML = original;
            document.getElementById('configResumo').classList.remove('d-none');
            esportecToast('Configurações aplicadas.', 'success');
        }, 600);
    });
</script>
</body>
</html>
