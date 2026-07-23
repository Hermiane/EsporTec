<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nova Reserva - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; --bg: #F8FAFC; --gray: #64748B; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .container-reserva { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
        .header-reserva { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
        .btn-back { width: 40px; height: 40px; border-radius: 10px; background: white; border: 1px solid rgba(45,129,93,0.25); color: var(--primary); display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 12px rgba(45,129,93,0.12); }
        .btn-back:hover { background: var(--primary); color: white; }
        .progress-bar-custom { display: flex; justify-content: space-between; margin-bottom: 2.5rem; position: relative; }
        .progress-bar-custom::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 3px; background: #E2E8F0; transform: translateY(-50%); z-index: 0; }
        .progress-step { width: 40px; height: 40px; border-radius: 50%; background: white; border: 3px solid #E2E8F0; display: flex; align-items: center; justify-content: center; font-weight: 600; position: relative; z-index: 1; transition: all 0.3s; }
        .progress-step.active { border-color: var(--primary); background: var(--primary); color: white; transform: scale(1.1); }
        .progress-step.completed { border-color: var(--primary); background: var(--light); color: var(--primary); }
        .step-label { position: absolute; top: 45px; left: 50%; transform: translateX(-50%); font-size: 0.75rem; font-weight: 500; color: var(--gray); white-space: nowrap; }
        .progress-step.active .step-label { color: var(--primary); font-weight: 600; }
        .step-content { display: none; animation: fadeIn 0.4s; }
        .step-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .card-step { background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .form-control, .form-select { border-radius: 10px; padding: 0.8rem; border: 1px solid #E2E8F0; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(45,129,93,0.15); }
        .time-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); gap: 0.8rem; margin-top: 1rem; }
        .time-slot { padding: 0.8rem; border-radius: 8px; text-align: center; font-weight: 500; cursor: pointer; border: 2px solid transparent; transition: all 0.2s; }
        .time-available { background: var(--light); color: var(--primary); border-color: var(--light); }
        .time-available:hover { background: var(--primary); color: white; }
        .time-selected { background: var(--primary); color: white; border-color: var(--dark); transform: scale(1.05); }
        .time-busy { background: #F1F5F9; color: #94A3B8; cursor: not-allowed; }
        .pix-container { text-align: center; padding: 1.5rem; background: #F8FAFC; border-radius: 12px; border: 2px dashed #CBD5E1; }
        .qr-code { width: 180px; height: 180px; background: white; margin: 1rem auto; display: flex; align-items: center; justify-content: center; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .pix-code { background: white; padding: 0.8rem; border-radius: 8px; font-family: monospace; word-break: break-all; margin: 1rem 0; border: 1px solid #E2E8F0; }
        .btn-copy { background: var(--primary); color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-copy:hover { background: var(--dark); }
        .payment-options { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .payment-option input { display: none; }
        .payment-card { height: 100%; border: 2px solid #E2E8F0; border-radius: 12px; padding: 1rem; cursor: pointer; display: flex; align-items: center; gap: 0.8rem; transition: all 0.2s; background: white; }
        .payment-card i { font-size: 1.6rem; color: var(--primary); }
        .payment-card strong { display: block; color: #334155; }
        .payment-card small { color: var(--gray); }
        .payment-option input:checked + .payment-card { border-color: var(--primary); background: var(--light); box-shadow: 0 6px 16px rgba(45,129,93,0.14); }
        .payment-info { background: var(--light); color: var(--primary); border-radius: 10px; padding: 1rem; }
        .success-panel { display: none; background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); text-align: center; }
        .success-panel.active { display: block; animation: fadeIn 0.4s; }
        .success-icon { width: 74px; height: 74px; border-radius: 50%; background: var(--light); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; font-size: 2.4rem; margin-bottom: 1rem; }
        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin: 1.5rem 0; text-align: left; }
        .summary-item { background: #F8FAFC; border-radius: 12px; padding: 1rem; }
        .summary-item small { color: var(--gray); display: block; margin-bottom: 0.25rem; }
        .success-actions { display: flex; justify-content: center; flex-wrap: wrap; gap: 0.75rem; }
        .nav-buttons { display: flex; justify-content: space-between; margin-top: 2rem; }
        .btn-nav { padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; }
        .btn-prev { background: var(--light); color: var(--primary); border: 1px solid rgba(45,129,93,0.35); }
        .btn-prev:hover { background: var(--primary); color: white; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(45,129,93,0.22); }
        .btn-next { background: var(--primary); color: white; }
        .btn-next:hover { background: var(--dark); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(45,129,93,0.3); }
        .btn-next:disabled { background: #CBD5E1; cursor: not-allowed; transform: none; box-shadow: none; }
        #btn-confirmar-reserva:disabled { background: #CBD5E1 !important; }
        .date-actions { display: flex; justify-content: flex-end; margin-bottom: 1rem; }
        .btn-date-confirm { background: var(--primary); color: white; border: none; border-radius: 10px; padding: 0.75rem 1.4rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-date-confirm:hover { background: var(--dark); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(45,129,93,0.3); }
        .btn-date-confirm:disabled { background: #CBD5E1; cursor: not-allowed; transform: none; box-shadow: none; }
        .total-box { background: var(--light); padding: 1.2rem; border-radius: 12px; margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        .total-price { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
        @media (max-width: 768px) {
            .progress-bar-custom { margin-bottom: 3.5rem; }
            .step-label { font-size: 0.65rem; }
            .time-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>

<div class="container-reserva">
    <div class="header-reserva">
        <a href="/painel" class="btn-back"><i class="bi bi-arrow-left"></i></a>
        <h2 class="fw-bold mb-0">Nova Reserva</h2>
    </div>

    <div class="progress-bar-custom">
        <div class="progress-step active" data-step="1">1<span class="step-label">Quadra</span></div>
        <div class="progress-step" data-step="2">2<span class="step-label">Data/Hora</span></div>
        <div class="progress-step" data-step="3">3<span class="step-label">Jogadores</span></div>
        <div class="progress-step" data-step="4">4<span class="step-label">Pagamento</span></div>
    </div>

    <!-- Passo 1 -->
    <div class="step-content active" id="step-1">
        <div class="card-step">
            <h4 class="fw-bold mb-3">Escolha a Quadra</h4>
            <div class="mb-3">
                <label class="form-label fw-medium">Selecione a Arena</label>
                <select class="form-select" id="arena">
                    <option value="">Carregando arenas...</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Selecione a Quadra</label>
                <select class="form-select" id="quadra">
                    <option value="">Carregando quadras...</option>
                </select>
            </div>
            <div class="alert" style="background: var(--light); color: var(--primary); border-radius: 10px;">
                <i class="bi bi-info-circle me-2"></i> Valor por hora: <strong id="preco-hora">R$ 0,00</strong>
            </div>
        </div>
        <div class="nav-buttons">
            <div></div>
            <button class="btn-nav btn-next" onclick="nextStep(2)">Próximo <i class="bi bi-arrow-right ms-2"></i></button>
        </div>
    </div>

    <!-- Passo 2 -->
    <div class="step-content" id="step-2">
        <div class="card-step">
            <h4 class="fw-bold mb-3">Escolha Data e Horário</h4>
            <div class="mb-3">
                <label class="form-label fw-medium">Data</label>
                <input type="date" class="form-control" id="data-reserva">
            </div>
            <div class="date-actions">
                <button type="button" class="btn-date-confirm" id="btn-ver-horarios" disabled>
                    <i class="bi bi-search me-2"></i>Ver horários
                </button>
            </div>
            <div id="aviso-data" class="alert" style="background: var(--light); color: var(--primary); border-radius: 10px;">
                <i class="bi bi-calendar-event me-2"></i> Selecione uma data para ver os horários disponíveis.
            </div>
            <label class="form-label fw-medium">Horários Disponíveis</label>
            <div id="horarios-container" class="d-none">
                <div class="time-grid" id="grade-horarios"></div>
                <div class="total-box">
                    <span class="fw-semibold">Tempo Selecionado</span>
                    <span class="total-price" id="tempo-total">0h</span>
                </div>
                <div class="total-box mt-2" style="background: white; border: 2px solid var(--primary);">
                    <span class="fw-bold">Valor Total</span>
                    <span class="total-price" id="valor-total">R$ 0,00</span>
                </div>
            </div>
        </div>
        <div class="nav-buttons">
            <button class="btn-nav btn-prev" onclick="prevStep(1)"><i class="bi bi-arrow-left me-2"></i> Voltar</button>
            <button class="btn-nav btn-next" id="btn-step-2" disabled onclick="nextStep(3)">Próximo <i class="bi bi-arrow-right ms-2"></i></button>
        </div>
    </div>

    <!-- Passo 3 -->
    <div class="step-content" id="step-3">
        <div class="card-step">
            <h4 class="fw-bold mb-3">Dados do Jogador</h4>
            <div class="mb-3">
                <label class="form-label fw-medium">Nome do Responsável</label>
                <input type="text" class="form-control" id="nome-responsavel" placeholder="Seu nome completo">
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Telefone para Contato</label>
                <input type="tel" class="form-control" id="telefone-contato" placeholder="(00) 00000-0000">
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Quantidade de Jogadores</label>
                <select class="form-select" id="qtd-jogadores">
                    <option value="">Selecione uma quadra primeiro</option>
                </select>
                <small class="text-muted" id="limite-jogadores">A quantidade máxima depende da capacidade da quadra.</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Observações (opcional)</label>
                <textarea class="form-control" id="observacoes" rows="3" placeholder="Ex: Precisamos de bolas extras..."></textarea>
            </div>
        </div>
        <div class="nav-buttons">
            <button class="btn-nav btn-prev" onclick="prevStep(2)"><i class="bi bi-arrow-left me-2"></i> Voltar</button>
            <button class="btn-nav btn-next" onclick="nextStep(4)">Ir para Pagamento <i class="bi bi-arrow-right ms-2"></i></button>
        </div>
    </div>

    <!-- Passo 4 -->
    <div class="step-content" id="step-4">
        <div class="card-step">
            <h4 class="fw-bold mb-3">Pagamento</h4>
            <p class="text-muted mb-3">Escolha como deseja pagar a reserva.</p>
            <div class="payment-options">
                <label class="payment-option">
                    <input type="radio" name="forma-pagamento" value="dinheiro">
                    <span class="payment-card"><i class="bi bi-cash-coin"></i><span><strong>Dinheiro</strong><small>Pagar na arena</small></span></span>
                </label>
                <label class="payment-option">
                    <input type="radio" name="forma-pagamento" value="pix">
                    <span class="payment-card"><i class="bi bi-qr-code"></i><span><strong>PIX</strong><small>QR Code na tela</small></span></span>
                </label>
                <label class="payment-option">
                    <input type="radio" name="forma-pagamento" value="cartao_credito">
                    <span class="payment-card"><i class="bi bi-credit-card"></i><span><strong>Cartão crédito</strong><small>Presencial na arena</small></span></span>
                </label>
                <label class="payment-option">
                    <input type="radio" name="forma-pagamento" value="cartao_debito">
                    <span class="payment-card"><i class="bi bi-credit-card-2-front"></i><span><strong>Cartão débito</strong><small>Presencial na arena</small></span></span>
                </label>
            </div>
            <div id="pagamento-info" class="payment-info">
                <i class="bi bi-info-circle me-2"></i> Selecione uma forma de pagamento para continuar.
            </div>
            <div id="pix-section" class="d-none">
                <div class="pix-container">
                    <p class="fw-semibold mb-2">Escaneie o QR Code ou copie o código</p>
                    <div class="qr-code"><i class="bi bi-qr-code" style="font-size: 4rem; color: var(--primary);"></i></div>
                    <div class="pix-code" id="pix-code">00020126580014BR.GOV.BCB.PIX0136a1b2c3d4-e5f6-7890-abcd-ef12345678905204000053039865406120.005802BR5913ESPORTEC LTDA6009SAO PAULO62070503***63041D3F</div>
                    <button class="btn-copy" onclick="copiarPix()"><i class="bi bi-clipboard me-2"></i>Copiar Código PIX</button>
                </div>
                <div class="mt-4">
                    <label class="form-label fw-medium">Enviar Comprovante (opcional)</label>
                    <input type="file" class="form-control" accept="image/*,.pdf">
                    <small class="text-muted">Envie o comprovante para agilizar a confirmação</small>
                </div>
                <div class="alert" style="background: var(--light); color: var(--primary); border-radius: 10px; margin-top: 1.5rem;">
                    <i class="bi bi-shield-check me-2"></i> Sua reserva será confirmada em até <strong>15 minutos</strong> após o pagamento.
                </div>
            </div>
            <div id="dinheiro-section" class="payment-info mt-4 d-none">
                <i class="bi bi-cash-coin me-2"></i> Reserva confirmada em até <strong>5 minutos</strong>. O pagamento em dinheiro ficará pendente e será feito diretamente na arena.
            </div>
            <div id="cartao-section" class="payment-info mt-4 d-none">
                <i class="bi bi-credit-card me-2"></i> O pagamento no cartão será feito presencialmente na arena.
            </div>
        </div>
        <div class="nav-buttons">
            <button class="btn-nav btn-prev" onclick="prevStep(3)"><i class="bi bi-arrow-left me-2"></i> Voltar</button>
            <button class="btn-nav btn-next" id="btn-confirmar-reserva" style="background: #10B981;" disabled onclick="finalizarReserva()">Confirmar Reserva</button>
        </div>
    </div>

    <!-- Sucesso -->
    <div class="success-panel" id="reserva-confirmada">
        <div class="success-icon"><i class="bi bi-check2-circle"></i></div>
        <h3 class="fw-bold">Reserva registrada</h3>
        <p class="text-muted mb-0" id="confirmacao-texto">Sua reserva foi registrada com sucesso.</p>
        <div class="summary-grid">
            <div class="summary-item"><small>Arena</small><strong id="resumo-arena">-</strong></div>
            <div class="summary-item"><small>Quadra</small><strong id="resumo-quadra">-</strong></div>
            <div class="summary-item"><small>Data e horário</small><strong id="resumo-data-hora">-</strong></div>
            <div class="summary-item"><small>Status</small><strong class="text-success">Confirmada</strong></div>
            <div class="summary-item"><small>Pagamento</small><strong id="resumo-pagamento">-</strong></div>
        </div>
        <div class="success-actions">
            <a href="/minhas-reservas" class="btn btn-success"><i class="bi bi-list-check me-2"></i>Ver histórico</a>
            <a href="/painel" class="btn btn-light"><i class="bi bi-grid me-2"></i>Voltar ao painel</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/esportec-ui.js"></script>
    <script src="/js/esportec-api.js"></script>
<script>
    //  CONFIGURAÇÃO - API PURA, SEM FALLBACK
    const API_BASE = '/api';
    
    let currentStep = 1;
    let selectedSlots = [];
    let pricePerHour = 0;
    let selectedQuadraId = null;
    const params = new URLSearchParams(window.location.search);

    const arenaSelect = document.getElementById('arena');
    const quadraSelect = document.getElementById('quadra');
    const dataReserva = document.getElementById('data-reserva');
    const btnVerHorarios = document.getElementById('btn-ver-horarios');
    const horariosContainer = document.getElementById('horarios-container');
    const avisoData = document.getElementById('aviso-data');
    const horariosLabel = horariosContainer.previousElementSibling;
    const paymentMethods = document.querySelectorAll('input[name="forma-pagamento"]');
    const quantidadeJogadores = document.getElementById('qtd-jogadores');
    const limiteJogadores = document.getElementById('limite-jogadores');
    const pagamentoInfo = document.getElementById('pagamento-info');
    const pixSection = document.getElementById('pix-section');
    const dinheiroSection = document.getElementById('dinheiro-section');
    const cartaoSection = document.getElementById('cartao-section');
    const btnConfirmarReserva = document.getElementById('btn-confirmar-reserva');
    const confirmationPanel = document.getElementById('reserva-confirmada');
    horariosLabel.classList.add('d-none');

    //  CARREGAR QUADRAS DA API (SEM FALLBACK)
    async function carregarQuadras() {
        let quadras;
        try { quadras = await EsporTecApi.request(`${API_BASE}/cliente/quadras`); } catch (error) {
            console.error(' Erro ao carregar quadras:', error.message);
            quadraSelect.innerHTML = '<option value="">Erro ao carregar quadras</option>';
            return;
        }
        
        const arenas = new Map();
        quadras.forEach(quadra => {
            if (quadra.arena?.id) arenas.set(String(quadra.arena.id), quadra.arena.nome);
        });
        arenaSelect.innerHTML = arenas.size ? [...arenas].map(([id, nome]) => `<option value="${id}">${nome}</option>`).join('') : '<option value="">Nenhuma arena disponível</option>';

        quadraSelect.innerHTML = '<option value="">Selecione uma quadra</option>';
        quadras.filter(q => q.ativo !== false).forEach(quadra => {
            const option = document.createElement('option');
            option.value = quadra.id;
            option.textContent = `${quadra.nome} (R$ ${parseFloat(quadra.preco_hora).toFixed(2).replace('.', ',')}/h)`;
            option.dataset.arena = String(quadra.arenas_id || quadra.arena?.id || '');
            option.dataset.price = quadra.preco_hora;
            option.dataset.nome = quadra.nome;
            option.dataset.capacity = quadra.capacidade_jogador;
            quadraSelect.appendChild(option);
        });

        const arenaSolicitada = params.get('arena');
        const quadraSolicitada = params.get('quadra');
        if (arenaSolicitada && [...arenaSelect.options].some(option => option.value === arenaSolicitada)) {
            arenaSelect.value = arenaSolicitada;
        }
        updateQuadrasByArena();
        if (quadraSolicitada && [...quadraSelect.options].some(option => option.value === quadraSolicitada && !option.disabled)) {
            quadraSelect.value = quadraSolicitada;
            updatePriceFromQuadra();
        }
        console.log(' Quadras carregadas da API');
    }

    //  CARREGAR HORÁRIOS DA API (SEM FALLBACK)
    async function carregarHorarios(quadraId, data) {
        try {
            const dados = await EsporTecApi.request(`${API_BASE}/cliente/quadras/${quadraId}/horarios?data=${data}`);
            console.log(' Horários carregados da API:', dados);
            return Array.isArray(dados) ? { horarios_disponiveis: dados, bloqueios: [] } : dados;
        } catch (error) {
            console.error(' Erro ao carregar horários:', error.message);
            return {
                horarios_disponiveis: [],
                bloqueios: [],
                erro: error.message || 'Não foi possível consultar os horários. Verifique sua conexão e tente novamente.'
            };
        }
    }

    function updateQuadrasByArena() {
        const selectedArena = arenaSelect.value;
        const options = [...quadraSelect.options];
        let currentOptionIsAvailable = false;

        options.forEach(option => {
            const isFromArena = option.dataset.arena === selectedArena;
            option.hidden = !isFromArena;
            option.disabled = !isFromArena;
            if (isFromArena && option.value === quadraSelect.value) currentOptionIsAvailable = true;
        });

        if (!currentOptionIsAvailable) {
            const firstAvailable = options.find(option => !option.disabled);
            if (firstAvailable) quadraSelect.value = firstAvailable.value;
        }
        updatePriceFromQuadra();
        hideTimeGridUntilDateConfirmed();
    }

    function updatePriceFromQuadra() {
        const selected = quadraSelect.options[quadraSelect.selectedIndex];
        if (selected && selected.getAttribute('data-price')) {
            pricePerHour = parseFloat(selected.getAttribute('data-price'));
            document.getElementById('preco-hora').textContent = `R$ ${pricePerHour.toFixed(2).replace('.', ',')}`;
            selectedQuadraId = selected.value;
        }
        atualizarQuantidadeJogadores(selected);
        updateTotal();
    }

    function atualizarQuantidadeJogadores(selected) {
        const capacidade = Number(selected?.dataset?.capacity || 0);
        quantidadeJogadores.innerHTML = capacidade > 0
            ? Array.from({ length: capacidade }, (_, indice) => {
                const quantidade = indice + 1;
                return `<option value="${quantidade}">${quantidade} ${quantidade === 1 ? 'jogador' : 'jogadores'}</option>`;
            }).join('')
            : '<option value="">Selecione uma quadra primeiro</option>';
        quantidadeJogadores.disabled = capacidade === 0;
        limiteJogadores.textContent = capacidade > 0
            ? `Capacidade máxima desta quadra: ${capacidade} jogadores.`
            : 'A quantidade máxima depende da capacidade da quadra.';
    }

    //  Carrega quadras ao iniciar
    document.addEventListener('DOMContentLoaded', () => {
        carregarQuadras();
    });

    arenaSelect.addEventListener('change', updateQuadrasByArena);
    quadraSelect.addEventListener('change', () => {
        updatePriceFromQuadra();
        hideTimeGridUntilDateConfirmed();
    });
    updateQuadrasByArena();

    //  Gera grade de horários via API
    async function generateTimeGrid() {
        const grid = document.getElementById('grade-horarios');
        grid.innerHTML = '';
        selectedSlots = [];
        
        const quadraId = quadraSelect.value || selectedQuadraId;
        if (!quadraId) {
            grid.innerHTML = '<p class="text-muted">Selecione uma quadra antes de consultar os horários.</p>';
            return;
        }
        selectedQuadraId = quadraId;
        const dadosHorarios = await carregarHorarios(quadraId, dataReserva.value);
        const horarios = dadosHorarios.horarios_disponiveis || [];
        const bloqueios = dadosHorarios.bloqueios || [];

        if (dadosHorarios.erro) {
            const mensagem = document.createElement('div');
            mensagem.className = 'alert alert-danger mb-0';
            mensagem.style.gridColumn = '1 / -1';
            mensagem.textContent = dadosHorarios.erro;
            grid.appendChild(mensagem);
            return;
        }

        if (bloqueios.length) {
            const aviso = document.createElement('div');
            aviso.className = 'alert alert-warning mb-2';
            aviso.style.gridColumn = '1 / -1';
            aviso.textContent = `Bloqueio(s) nesta data: ${bloqueios.map(b => `${b.hora_inicio}–${b.hora_fim}${b.motivo ? ` (${b.motivo})` : ''}`).join(', ')}.`;
            grid.appendChild(aviso);
        }
        
        if (horarios.length === 0) {
            grid.insertAdjacentHTML('beforeend', '<p class="text-muted" style="grid-column: 1 / -1;">Nenhum horário livre nesta data.</p>');
            return;
        }

        horarios.forEach(hour => {
            const slot = document.createElement('div');
            slot.className = 'time-slot time-available';
            slot.textContent = hour;
            slot.onclick = () => toggleSlot(slot, hour);
            grid.appendChild(slot);
        });
        updateTotal();
    }

    function isCompleteDate(value) { return /^\d{4}-\d{2}-\d{2}$/.test(value); }
    function updateDateButtonState() { btnVerHorarios.disabled = !isCompleteDate(dataReserva.value); }

    function hideTimeGridUntilDateConfirmed() {
        horariosContainer.classList.add('d-none');
        horariosLabel.classList.add('d-none');
        avisoData.classList.remove('d-none');
        document.getElementById('grade-horarios').innerHTML = '';
        selectedSlots = [];
        updateDateButtonState();
        updateTotal();
    }

    async function showTimeGridForDate() {
        if (!isCompleteDate(dataReserva.value)) {
            hideTimeGridUntilDateConfirmed();
            dataReserva.focus();
            return;
        }
        avisoData.classList.add('d-none');
        horariosContainer.classList.remove('d-none');
        horariosLabel.classList.remove('d-none');
        await generateTimeGrid();
    }

    dataReserva.addEventListener('input', hideTimeGridUntilDateConfirmed);
    dataReserva.addEventListener('change', hideTimeGridUntilDateConfirmed);
    dataReserva.addEventListener('keydown', event => {
        if (event.key === 'Enter') { event.preventDefault(); showTimeGridForDate(); }
    });
    btnVerHorarios.addEventListener('click', showTimeGridForDate);
    updateDateButtonState();

    function toggleSlot(element, hour) {
        if (element.classList.contains('time-selected')) {
            element.classList.remove('time-selected');
            element.classList.add('time-available');
            selectedSlots = selectedSlots.filter(h => h !== hour);
        } else {
            element.classList.remove('time-available');
            element.classList.add('time-selected');
            selectedSlots.push(hour);
        }
        updateTotal();
    }

    function updateTotal() {
        const hours = selectedSlots.length;
        const total = hours * pricePerHour;
        document.getElementById('tempo-total').textContent = `${hours}h`;
        document.getElementById('valor-total').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
        document.getElementById('btn-step-2').disabled = hours === 0;
    }

    function nextStep(step) {
        document.getElementById(`step-${currentStep}`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.add('completed');
        currentStep = step;
        document.getElementById(`step-${currentStep}`).classList.add('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.add('active');
    }

    function prevStep(step) {
        document.getElementById(`step-${currentStep}`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.remove('active');
        currentStep = step;
        document.getElementById(`step-${currentStep}`).classList.add('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.add('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.remove('completed');
    }

    function updatePaymentMethod() {
        const selectedPayment = document.querySelector('input[name="forma-pagamento"]:checked');
        const method = selectedPayment ? selectedPayment.value : '';
        pagamentoInfo.classList.toggle('d-none', Boolean(method));
        pixSection.classList.toggle('d-none', method !== 'pix');
        dinheiroSection.classList.toggle('d-none', method !== 'dinheiro');
        cartaoSection.classList.toggle('d-none', !method.startsWith('cartao_'));
        btnConfirmarReserva.disabled = !method;
    }
    paymentMethods.forEach(method => method.addEventListener('change', updatePaymentMethod));
    updatePaymentMethod();

    function copiarPix() {
        const code = document.getElementById('pix-code').textContent;
        navigator.clipboard.writeText(code).then(() => esportecToast('Código PIX copiado.', 'success'));
    }

    function minutosDoHorario(horario) {
        const [hora, minuto] = horario.split(':').map(Number);
        return (hora * 60) + minuto;
    }

    function horarioApos(horario, minutos) {
        const total = (minutosDoHorario(horario) + minutos) % (24 * 60);
        return `${String(Math.floor(total / 60)).padStart(2, '0')}:${String(total % 60).padStart(2, '0')}`;
    }

    // CRIAR RESERVA VIA API (SEM FALLBACK)
    async function finalizarReserva() {
        const selectedPayment = document.querySelector('input[name="forma-pagamento"]:checked');
        if (!selectedPayment) {
            esportecToast('Selecione uma forma de pagamento.', 'warning');
            return;
        }

        const selectedCourtOption = quadraSelect.options[quadraSelect.selectedIndex];
        const selectedCourt = selectedCourtOption.dataset.nome || selectedCourtOption.textContent.replace(/\s*\(R\$.*/, '');
        const selectedArena = arenaSelect.options[arenaSelect.selectedIndex].textContent;
        const horariosSelecionados = [...selectedSlots].sort((a, b) => minutosDoHorario(a) - minutosDoHorario(b));

        if (!horariosSelecionados.length) {
            esportecToast('Selecione pelo menos um horário.', 'warning');
            return;
        }

        if (horariosSelecionados.some((horario, indice) => indice > 0 && minutosDoHorario(horario) !== minutosDoHorario(horariosSelecionados[indice - 1]) + 60)) {
            esportecToast('Selecione horários contínuos para realizar uma única reserva.', 'warning');
            return;
        }

        const payload = {
            usuario_id: 1,
            quadra_id: selectedQuadraId || selectedCourtOption.value,
            data: dataReserva.value,
            hora_inicio: horariosSelecionados[0],
            hora_fim: horarioApos(horariosSelecionados[horariosSelecionados.length - 1], 60),
            valor_total: pricePerHour * horariosSelecionados.length,
            quantidade_jogadores: Number(quantidadeJogadores.value),
            observacao: document.getElementById('observacoes').value || null,
            metodo_pagamento: selectedPayment.value
        };

        try {
            const response = await fetch(`${API_BASE}/reservas`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${EsporTecApi.token()}`
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                const err = await response.json().catch(() => ({}));
                throw new Error(err.message || `Erro ${response.status}`);
            }

            const reserva = await response.json();
            await EsporTecApi.request(`${API_BASE}/cliente/pagamentos`, {
                method: 'POST',
                body: JSON.stringify({
                    reserva_id: reserva.id,
                    valor: payload.valor_total,
                    metodo: selectedPayment.value,
                    pix_copia_cola: selectedPayment.value === 'pix' ? document.getElementById('pix-code').textContent : undefined
                })
            });
            console.log(' Reserva criada:', reserva);
            
        } catch (error) {
            console.error(' Erro ao criar reserva:', error);
            esportecToast(`Erro: ${error.message}`, 'error');
            return;
        }

        // Mostra painel de sucesso
        document.getElementById('resumo-arena').textContent = selectedArena;
        document.getElementById('resumo-quadra').textContent = selectedCourt;
        document.getElementById('resumo-data-hora').textContent = `${dataReserva.value} - ${selectedSlots.join(', ')}`;
        document.getElementById('resumo-pagamento').textContent = selectedPayment.value;
        document.getElementById('confirmacao-texto').textContent = 'Reserva confirmada.';

        document.querySelectorAll('.step-content').forEach(step => step.classList.remove('active'));
        document.querySelector('.progress-bar-custom').classList.add('d-none');
        confirmationPanel.classList.add('active');
        confirmationPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        esportecToast('Reserva registrada com sucesso.', 'success');
    }

    const today = new Date();
    today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
    dataReserva.min = today.toISOString().split('T')[0];

    if (params.get('etapa') === 'data') nextStep(2);
</script>
</body>
</html>
