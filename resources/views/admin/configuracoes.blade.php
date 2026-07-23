<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Configurações - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --success: #10B981; --warning: #F59E0B; --danger: #EF4444; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        
        
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, var(--dark) 0%, #154030 100%);
            color: white;
            padding: 1.5rem;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
        }
        .sidebar-brand {
            font-size: 1.6rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand i { font-size: 2rem; color: #4ADE80; }
        .sidebar-brand span { font-size: 0.75rem; opacity: 0.7; margin-top: -0.2rem; font-weight: 400; }
        .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 0.9rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
        }
        
        .main { flex: 1; margin-left: 250px; padding: 2rem; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; color: var(--dark); margin: 0; }
        .settings-container { max-width: 1000px; }
        .settings-card { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .settings-title { font-weight: 600; font-size: 1.2rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #F1F5F9; display: flex; align-items: center; gap: 0.5rem; }
        .form-label { font-weight: 500; margin-bottom: 0.5rem; }
        .form-control, .form-select { border-radius: 8px; padding: 0.7rem; border: 1px solid #E2E8F0; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(45,129,93,0.15); }
        .help-text { font-size: 0.85rem; color: #64748B; margin-top: 0.3rem; }
        .btn-save { background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; margin-left: auto; }
        .btn-save:hover { background: var(--dark); }
        .toggle-switch { display: flex; align-items: center; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #F1F5F9; }
        .toggle-switch:last-child { border-bottom: none; }
        .form-check-input { width: 48px; height: 24px; cursor: pointer; }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
        
        @media (max-width: 992px) { .sidebar { width: 100%; position: relative; height: auto; } .main { margin-left: 0; } }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">
            <i class="bi bi-trophy"></i>
            <div>
                EsporTec
                <span>Admin da arena</span>
            </div>
        </a>
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
                        <input type="text" class="form-control" id="configNomeArena" value="EsporTec Arena">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CNPJ</label>
                        <input type="text" class="form-control" id="configCnpj" placeholder="00.000.000/0001-00">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Logradouro</label>
                        <input type="text" class="form-control" id="configLogradouro" value="Rua dos Esportes">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Número</label>
                        <input type="text" class="form-control" id="configNumero" value="123">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="configBairro" value="Centro">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="configCidade" value="São Paulo">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">UF</label>
                        <input type="text" class="form-control" id="configUf" value="SP" maxlength="2">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Ponto de referência</label>
                        <input type="text" class="form-control" id="configReferencia" placeholder="Ex: próximo ao ginásio">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="configTelefone" value="(11) 99999-9999">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">E-mail de Contato</label>
                        <input type="email" class="form-control" id="configEmail" value="contato@esportec.com.br">
                    </div>
                </div>
            </div>

            <!-- Horários de Funcionamento -->
            <div class="settings-card">
                <div class="settings-title"><i class="bi bi-clock"></i> Horários de Funcionamento</div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Horário de Abertura</label>
                        <input type="time" class="form-control" id="configHoraAbertura" value="07:00">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Horário de Fechamento</label>
                        <input type="time" class="form-control" id="configHoraFechamento" value="23:00">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dias de Funcionamento</label>
                    <select class="form-select" id="configDiasFuncionamento" multiple size="3">
                        <option value="domingo">Domingo</option>
                        <option value="segunda-feira">Segunda-feira</option>
                        <option value="terca-feira">Terça-feira</option>
                        <option value="quarta-feira">Quarta-feira</option>
                        <option value="quinta-feira">Quinta-feira</option>
                        <option value="sexta-feira">Sexta-feira</option>
                        <option value="sabado">Sábado</option>
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
                        <input type="number" class="form-control" id="configAntecedenciaMinima" value="1" min="0">
                        <div class="help-text">Quanto tempo antes o cliente pode reservar</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Multa por Cancelamento (%)</label>
                        <input type="number" class="form-control" id="configMultaCancelamento" value="10" min="0" max="100">
                        <div class="help-text">Porcentagem cobrada em cancelamentos tardios</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Duração Padrão da Reserva (minutos)</label>
                        <input type="number" class="form-control" id="configDuracaoPadrao" value="60" step="30">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Máximo de Reservas por Cliente</label>
                        <input type="number" class="form-control" id="configMaxReservas" value="3" min="1">
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
                    <input type="checkbox" class="form-check-input" id="configPix" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Aceitar Cartão de Crédito</div>
                        <div class="help-text">Pagamento presencial ou online</div>
                    </div>
                    <input type="checkbox" class="form-check-input" id="configCartaoCredito" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Aceitar Cartão de Débito</div>
                        <div class="help-text">Pagamento presencial na arena</div>
                    </div>
                    <input type="checkbox" class="form-check-input" id="configCartaoDebito" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Aceitar Dinheiro</div>
                        <div class="help-text">Pagamento em espécie no local</div>
                    </div>
                    <input type="checkbox" class="form-check-input" id="configDinheiro" checked>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Tipo da chave PIX</label>
                        <select class="form-select" id="configPixTipo">
                            <option value="cnpj">CNPJ</option>
                            <option value="cpf">CPF</option>
                            <option value="email">E-mail</option>
                            <option value="telefone">Telefone</option>
                            <option value="aleatoria">Aleatória</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Chave PIX</label>
                        <input type="text" class="form-control" id="configPixChave" placeholder="CNPJ, e-mail ou telefone">
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
                    <input type="checkbox" class="form-check-input" id="configEmailConfirmacao" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Lembrete Automático</div>
                        <div class="help-text">Enviar lembrete antes da partida</div>
                    </div>
                    <input type="checkbox" class="form-check-input" id="configLembrete" checked>
                </div>
                <div class="toggle-switch">
                    <div>
                        <div class="fw-medium">Solicitar Feedback Pós-Jogo</div>
                        <div class="help-text">Envia formulário de avaliação após a partida</div>
                    </div>
                    <input type="checkbox" class="form-check-input" id="configFeedback" checked>
                </div>
            </div>

            <!-- Segurança -->
            <div class="settings-card">
                <div class="settings-title"><i class="bi bi-shield-lock"></i> Segurança e Acesso</div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tempo de Expiração do Código (minutos)</label>
                        <input type="number" class="form-control" id="configExpiracaoCodigo" value="15" min="5" max="60">
                        <div class="help-text">Tempo válido para redefinição de senha</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Máximo de Tentativas de Login</label>
                        <input type="number" class="form-control" id="configMaxTentativas" value="5" min="1" max="10">
                        <div class="help-text">Bloqueia a conta após X tentativas falhas</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tempo de Bloqueio (minutos)</label>
                        <input type="number" class="form-control" id="configTempoBloqueio" value="15" min="5">
                        <div class="help-text">Duração do bloqueio após muitas tentativas</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Duração da Sessão (dias)</label>
                        <input type="number" class="form-control" id="configDuracaoSessao" value="30" min="1">
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
<script src="/js/esportec-api.js"></script>
<script>
    
    //  INTEGRAÇÃO COM API - ADMIN CONFIGURAÇÕES
    
    const API_BASE = '/api';
    
    // Mock data para fallback (valores padrão)
    const MOCK_CONFIG = {
        arena: {
            nome: 'EsporTec Arena',
            cnpj: '',
            logradouro: 'Rua dos Esportes',
            numero: '123',
            bairro: 'Centro',
            cidade: 'São Paulo',
            uf: 'SP',
            referencia: '',
            telefone: '(11) 99999-9999',
            email: 'contato@esportec.com.br'
        },
        horarios: {
            abertura: '07:00',
            fechamento: '23:00',
            dias: ['domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado']
        },
        regras: {
            antecedencia_minima: 1,
            multa_cancelamento: 10,
            duracao_padrao: 60,
            max_reservas_cliente: 3
        },
        pagamentos: {
            aceitar_pix: true,
            aceitar_cartao_credito: true,
            aceitar_cartao_debito: true,
            aceitar_dinheiro: true,
            pix_tipo: 'cnpj',
            pix_chave: ''
        },
        notificacoes: {
            email_confirmacao: true,
            lembrete_automatico: true,
            solicitar_feedback: true
        },
        seguranca: {
            expiracao_codigo: 15,
            max_tentativas_login: 5,
            tempo_bloqueio: 15,
            duracao_sessao: 30
        }
    };

    //  CARREGAR CONFIGURAÇÕES - API: GET /api/admin/configuracoes
    async function carregarConfiguracoes() {
        try {
            const response = await fetch(`${API_BASE}/admin/configuracoes`);
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            const config = await response.json();
            
            if (config.arena) {
                preencherFormulario(config);
                console.log(' Configurações carregadas da API');
                return;
            }
            
            throw new Error('Estrutura inesperada');
            
        } catch (error) { esportecToast(error.message, 'danger'); }
    }

    function preencherFormulario(config) {
        // Dados da Arena
        if (config.arena) {
            document.getElementById('configNomeArena').value = config.arena.nome || '';
            document.getElementById('configCnpj').value = config.arena.cnpj || '';
            document.getElementById('configLogradouro').value = config.arena.logradouro || '';
            document.getElementById('configNumero').value = config.arena.numero || '';
            document.getElementById('configBairro').value = config.arena.bairro || '';
            document.getElementById('configCidade').value = config.arena.cidade || '';
            document.getElementById('configUf').value = config.arena.uf || '';
            document.getElementById('configReferencia').value = config.arena.referencia || '';
            document.getElementById('configTelefone').value = config.arena.telefone || '';
            document.getElementById('configEmail').value = config.arena.email || '';
        }
        
        // Horários
        if (config.horarios) {
            document.getElementById('configHoraAbertura').value = config.horarios.abertura || '07:00';
            document.getElementById('configHoraFechamento').value = config.horarios.fechamento || '23:00';
            
            // Selecionar dias no multiselect
            const selectDias = document.getElementById('configDiasFuncionamento');
            Array.from(selectDias.options).forEach(opt => opt.selected = false);
            if (config.horarios.dias) {
                config.horarios.dias.forEach(dia => {
                    const option = Array.from(selectDias.options).find(o => o.value === dia);
                    if (option) option.selected = true;
                });
            }
        }
        
        // Regras
        if (config.regras) {
            document.getElementById('configAntecedenciaMinima').value = config.regras.antecedencia_minima ?? 1;
            document.getElementById('configMultaCancelamento').value = config.regras.multa_cancelamento ?? 10;
            document.getElementById('configDuracaoPadrao').value = config.regras.duracao_padrao ?? 60;
            document.getElementById('configMaxReservas').value = config.regras.max_reservas_cliente ?? 3;
        }
        
        // Pagamentos
        if (config.pagamentos) {
            document.getElementById('configPix').checked = config.pagamentos.aceitar_pix ?? true;
            document.getElementById('configCartaoCredito').checked = config.pagamentos.aceitar_cartao_credito ?? true;
            document.getElementById('configCartaoDebito').checked = config.pagamentos.aceitar_cartao_debito ?? true;
            document.getElementById('configDinheiro').checked = config.pagamentos.aceitar_dinheiro ?? true;
            document.getElementById('configPixTipo').value = config.pagamentos.pix_tipo || 'cnpj';
            document.getElementById('configPixChave').value = config.pagamentos.pix_chave || '';
        }
        
        // Notificações
        if (config.notificacoes) {
            document.getElementById('configEmailConfirmacao').checked = config.notificacoes.email_confirmacao ?? true;
            document.getElementById('configLembrete').checked = config.notificacoes.lembrete_automatico ?? true;
            document.getElementById('configFeedback').checked = config.notificacoes.solicitar_feedback ?? true;
        }
        
        // Segurança
        if (config.seguranca) {
            document.getElementById('configExpiracaoCodigo').value = config.seguranca.expiracao_codigo ?? 15;
            document.getElementById('configMaxTentativas').value = config.seguranca.max_tentativas_login ?? 5;
            document.getElementById('configTempoBloqueio').value = config.seguranca.tempo_bloqueio ?? 15;
            document.getElementById('configDuracaoSessao').value = config.seguranca.duracao_sessao ?? 30;
        }
    }

    //  SALVAR CONFIGURAÇÕES - API: PUT /api/admin/configuracoes
    document.getElementById('btnSalvarConfiguracoes').addEventListener('click', async () => {
        const button = document.getElementById('btnSalvarConfiguracoes');
        const original = button.innerHTML;
        
        button.disabled = true;
        button.innerHTML = '<i class="bi bi-hourglass-split"></i> Salvando...';
        
        // Coleta dados do formulário
        const payload = {
            arena: {
                nome: document.getElementById('configNomeArena').value.trim(),
                cnpj: document.getElementById('configCnpj').value.trim(),
                logradouro: document.getElementById('configLogradouro').value.trim(),
                numero: document.getElementById('configNumero').value.trim(),
                bairro: document.getElementById('configBairro').value.trim(),
                cidade: document.getElementById('configCidade').value.trim(),
                uf: document.getElementById('configUf').value.trim().toUpperCase(),
                referencia: document.getElementById('configReferencia').value.trim(),
                telefone: document.getElementById('configTelefone').value.trim(),
                email: document.getElementById('configEmail').value.trim()
            },
            horarios: {
                abertura: document.getElementById('configHoraAbertura').value,
                fechamento: document.getElementById('configHoraFechamento').value,
                dias: Array.from(document.getElementById('configDiasFuncionamento').selectedOptions).map(opt => opt.value)
            },
            regras: {
                antecedencia_minima: parseInt(document.getElementById('configAntecedenciaMinima').value) || 1,
                multa_cancelamento: parseInt(document.getElementById('configMultaCancelamento').value) || 0,
                duracao_padrao: parseInt(document.getElementById('configDuracaoPadrao').value) || 60,
                max_reservas_cliente: parseInt(document.getElementById('configMaxReservas').value) || 1
            },
            pagamentos: {
                aceitar_pix: document.getElementById('configPix').checked,
                aceitar_cartao_credito: document.getElementById('configCartaoCredito').checked,
                aceitar_cartao_debito: document.getElementById('configCartaoDebito').checked,
                aceitar_dinheiro: document.getElementById('configDinheiro').checked,
                pix_tipo: document.getElementById('configPixTipo').value,
                pix_chave: document.getElementById('configPixChave').value.trim()
            },
            notificacoes: {
                email_confirmacao: document.getElementById('configEmailConfirmacao').checked,
                lembrete_automatico: document.getElementById('configLembrete').checked,
                solicitar_feedback: document.getElementById('configFeedback').checked
            },
            seguranca: {
                expiracao_codigo: parseInt(document.getElementById('configExpiracaoCodigo').value) || 15,
                max_tentativas_login: parseInt(document.getElementById('configMaxTentativas').value) || 5,
                tempo_bloqueio: parseInt(document.getElementById('configTempoBloqueio').value) || 15,
                duracao_sessao: parseInt(document.getElementById('configDuracaoSessao').value) || 30
            }
        };
        
        try {
            const response = await fetch(`${API_BASE}/admin/configuracoes`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify(payload)
            });
            
            if (!response.ok) throw new Error('Erro ao salvar');
            
            button.disabled = false;
            button.innerHTML = original;
            document.getElementById('configResumo').classList.remove('d-none');
            esportecToast('Configurações salvas com sucesso.', 'success');
            
            // Esconde mensagem após 3 segundos
            setTimeout(() => {
                document.getElementById('configResumo').classList.add('d-none');
            }, 3000);
            
        } catch (error) { button.disabled = false; button.innerHTML = original; esportecToast('Não foi possível salvar as configurações.', 'danger'); }
    });

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        carregarConfiguracoes();
    });
</script>
</body>
</html>