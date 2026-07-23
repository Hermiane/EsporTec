<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Reservas - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; --bg: #F8FAFC; --gray: #64748B; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .container-reservas { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
        .header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
        .btn-back { width: 40px; height: 40px; border-radius: 10px; background: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-decoration: none; color: inherit; }
        .btn-back:hover { background: var(--light); }

        /* Abas */
        .tabs-container { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; background: white; padding: 0.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .tab-btn { flex: 1; padding: 0.8rem; border: none; background: transparent; border-radius: 8px; font-weight: 600; color: var(--gray); cursor: pointer; transition: all 0.2s; font-family: inherit; }
        .tab-btn.active { background: var(--primary); color: white; box-shadow: 0 2px 6px rgba(45,129,93,0.3); }

        /* Cards de Reserva */
        .reserva-card { background: white; border-radius: 12px; padding: 1.2rem; margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.04); display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; }
        .reserva-info { flex: 1; min-width: 200px; }
        .reserva-title { font-weight: 700; font-size: 1.1rem; margin-bottom: 0.3rem; }
        .reserva-meta { font-size: 0.9rem; color: var(--gray); display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 0.5rem; }
        .reserva-meta i { margin-right: 0.3rem; }

        /* Badges de Status */
        .badge-status { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
        .badge-pendente { background: rgba(249,168,37,0.15); color: #F9A825; }
        .badge-confirmada { background: rgba(45,129,93,0.15); color: var(--primary); }
        .badge-pago { background: rgba(21,101,192,0.15); color: #1565C0; }
        .badge-cancelada { background: rgba(239,68,68,0.15); color: #EF4444; }
        .badge-concluida { background: rgba(21,101,192,0.15); color: #1565C0; }

        .reserva-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 0.5rem; }
        .btn-action { padding: 0.5rem 0.9rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.4rem; text-decoration: none; white-space: nowrap; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--dark); }
        .btn-outline { background: white; border: 1px solid #E2E8F0; color: var(--gray); }
        .btn-outline:hover { background: #F1F5F9; }
        .btn-danger { background: rgba(239,68,68,0.1); color: #EF4444; }
        .btn-danger:hover { background: rgba(239,68,68,0.2); }

        .tab-content { display: none; animation: fadeIn 0.3s; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--gray); }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.3; }
        
        @media (max-width: 576px) {
            .reserva-card { flex-direction: column; align-items: flex-start; }
            .reserva-actions { width: 100%; justify-content: flex-start; }
            .btn-action { flex: 1; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="container-reservas">
    <div class="header">
        <a href="/painel" class="btn-back"><i class="bi bi-arrow-left"></i></a>
        <h2 class="fw-bold mb-0">Minhas Reservas</h2>
    </div>

    <!-- Abas -->
    <div class="tabs-container">
        <button class="tab-btn active" onclick="switchTab('proximas', this)">Próximas</button>
        <button class="tab-btn" onclick="switchTab('passadas', this)">Passadas</button>
        <button class="tab-btn" onclick="switchTab('canceladas', this)">Canceladas</button>
    </div>

    <!-- Conteúdo -->
    <div id="proximas" class="tab-content active"></div>
    <div id="passadas" class="tab-content"></div>
    <div id="canceladas" class="tab-content"></div>
    
    <div id="emptyState" class="empty-state d-none">
        <i class="bi bi-calendar-x"></i>
        <p class="mb-0">Nenhuma reserva encontrada nesta categoria.</p>
    </div>
</div>

<!-- Modal Detalhes -->
<div class="modal fade" id="modalDetalhes" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-clipboard me-2"></i>Detalhes da Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Quadra</small>
                            <strong class="fs-5" id="detalhe-quadra">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Data</small>
                            <strong class="fs-5" id="detalhe-data">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Responsável</small>
                            <strong class="fs-5" id="detalhe-responsavel">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Horário</small>
                            <strong class="fs-5" id="detalhe-horario">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Valor Total</small>
                            <strong class="fs-5 text-success" id="detalhe-valor">-</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge bg-success bg-opacity-10 text-success fs-6" id="detalhe-status">-</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Pagamento</small>
                            <strong id="detalhe-pagamento">-</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Observações</small>
                            <p class="mb-0 mt-1" id="detalhe-observacoes">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-outline-success" onclick="abrirRemarcacao(reservaEmDetalhe)">
                    <i class="bi bi-calendar2-week me-2"></i>Remarcar
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmarCancelamento(reservaEmDetalhe)">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Avaliação -->
<div class="modal fade" id="modalAvaliacao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-star-fill me-2"></i>Avaliar Partida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p class="text-muted mb-3">Como foi sua experiência na <strong id="avaliar-quadra">Quadra</strong>?</p>
                <div class="mb-4">
                    <div class="d-flex justify-content-center gap-2 mb-3" id="stars">
                        <i class="bi bi-star fs-1 text-warning" style="cursor: pointer;" onclick="setRating(1)"></i>
                        <i class="bi bi-star fs-1 text-warning" style="cursor: pointer;" onclick="setRating(2)"></i>
                        <i class="bi bi-star fs-1 text-warning" style="cursor: pointer;" onclick="setRating(3)"></i>
                        <i class="bi bi-star fs-1 text-warning" style="cursor: pointer;" onclick="setRating(4)"></i>
                        <i class="bi bi-star fs-1 text-warning" style="cursor: pointer;" onclick="setRating(5)"></i>
                    </div>
                    <input type="hidden" id="rating" value="0">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Comentário (opcional)</label>
                    <textarea class="form-control" rows="3" placeholder="Conte-nos como foi..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submitAvaliacao()">
                    <i class="bi bi-check-lg me-2"></i>Enviar
                </button>
            </div>
        </div>
    </div>
</div>

<!--  MODAL REMARCAÇÃO ATUALIZADO -->
<div class="modal fade" id="modalRemarcacao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Remarcar reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success bg-success bg-opacity-10 text-success border-0">
                    Escolha uma nova data e horário. A alteração fica registrada no histórico.
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Quadra</label>
                    <input type="text" class="form-control" id="remarcarQuadraNome" readonly>
                    <input type="hidden" id="remarcarQuadraId">
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Nova data <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="novaDataReserva" min="">
                    <small class="text-muted">Horários disponíveis serão carregados automaticamente</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Novo horário <span class="text-danger">*</span></label>
                    <select class="form-select" id="novoHorarioReserva" disabled>
                        <option value="">Selecione uma data primeiro</option>
                    </select>
                    <div id="loadingHorarios" class="text-muted small mt-1 d-none">
                        <i class="bi bi-hourglass-split"></i> Carregando horários...
                    </div>
                </div>
                
                <div class="mb-0">
                    <label class="form-label fw-medium">Motivo da remarcação</label>
                    <textarea class="form-control" id="motivoRemarcacao" rows="3" placeholder="Ex: precisei alterar o horário"></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="confirmarRemarcacao()" id="btnConfirmarRemarcacao" disabled>Confirmar remarcação</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    const API_BASE = '/api/cliente';
    let reservaEmRemarcacao = null;
    let reservaEmDetalhe = null;

    const MOCK_RESERVAS = [
        { id: 101, data: '2026-07-20', hora_inicio: '19:00', hora_fim: '20:30', status: 'confirmada', quadra: { nome: 'Society Premium', id: 2 }, pagamento: { status: 'pendente', valor: 225.00, metodo: 'Dinheiro' }, responsavel: 'João Silva', observacoes: 'Campeonato interno' },
        { id: 102, data: '2026-07-18', hora_inicio: '16:00', hora_fim: '17:00', status: 'confirmada', quadra: { nome: 'Futsal Arena', id: 1 }, pagamento: { status: 'pago', valor: 120.00, metodo: 'Cartão' }, responsavel: 'João Silva', observacoes: '' },
        { id: 103, data: '2026-07-10', hora_inicio: '10:00', hora_fim: '11:00', status: 'concluida', quadra: { nome: 'Society Descoberta', id: 3 }, pagamento: { status: 'pago', valor: 100.00, metodo: 'PIX' }, responsavel: 'João Silva', observacoes: '' },
        { id: 104, data: '2026-07-05', hora_inicio: '20:00', hora_fim: '21:30', status: 'cancelada', quadra: { nome: 'Society Premium', id: 2 }, pagamento: { status: 'cancelado', valor: 0, metodo: 'Dinheiro' }, responsavel: 'João Silva', observacoes: '' }
    ];

    async function carregarReservas() {
        try {
            const response = await fetch(`${API_BASE}/reservas`);
            if (!response.ok) throw new Error('Erro');
            const reservas = await response.json();
            renderizarTodasReservas(reservas);
        } catch (error) {
            console.log('Usando dados de teste');
            renderizarTodasReservas(MOCK_RESERVAS);
        }
    }

    function renderizarTodasReservas(reservas) {
        renderizarAba('proximas', reservas.filter(r => {
            const hoje = new Date().toISOString().split('T')[0];
            return r.data >= hoje && r.status !== 'cancelada';
        }));
        renderizarAba('passadas', reservas.filter(r => {
            const hoje = new Date().toISOString().split('T')[0];
            return r.data < hoje && r.status === 'concluida';
        }));
        renderizarAba('canceladas', reservas.filter(r => r.status === 'cancelada'));
        
        const todasVazias = ['proximas', 'passadas', 'canceladas'].every(id => document.getElementById(id).children.length === 0);
        document.getElementById('emptyState').classList.toggle('d-none', !todasVazias);
    }

    function renderizarAba(abaId, reservas) {
        const container = document.getElementById(abaId);
        container.innerHTML = '';
        if (reservas.length === 0) return;

        reservas.forEach(reserva => {
            const card = document.createElement('div');
            card.className = 'reserva-card';
            card.dataset.reserva = JSON.stringify(reserva).replace(/"/g, '&quot;');
            
            let badges = '';
            if (reserva.status === 'confirmada') badges += '<span class="badge-status badge-confirmada">Confirmada</span>';
            else if (reserva.status === 'concluida') badges += '<span class="badge-status badge-concluida">Concluída</span>';
            else if (reserva.status === 'cancelada') badges += '<span class="badge-status badge-cancelada">Cancelada</span>';
            
            if (reserva.pagamento?.status === 'pago') badges += '<span class="badge-status badge-pago ms-2">Pago</span>';
            else if (reserva.pagamento?.status === 'pendente') badges += '<span class="badge-status badge-pendente ms-2">Pendente</span>';
            
            let actions = `<button class="btn-action btn-primary" onclick="abrirDetalhesReserva(this)"><i class="bi bi-eye"></i> Detalhes</button>`;
            
            if (abaId === 'passadas' && reserva.status === 'concluida') {
                actions += `<button class="btn-action btn-outline" data-bs-toggle="modal" data-bs-target="#modalAvaliacao" onclick="prepararAvaliacao('${reserva.quadra?.nome}')"><i class="bi bi-star"></i> Avaliar</button>`;
            }
            if (abaId === 'proximas' && reserva.status !== 'cancelada') {
                actions += `<button class="btn-action btn-outline" onclick="abrirRemarcacao(this)"><i class="bi bi-calendar2-week"></i> Remarcar</button>`;
                actions += `<button class="btn-action btn-danger" onclick="confirmarCancelamento(this)"><i class="bi bi-x-circle"></i> Cancelar</button>`;
            }
            if (abaId === 'canceladas') {
                actions += `<a href="/nova-reserva" class="btn-action btn-outline"><i class="bi bi-arrow-repeat"></i> Nova reserva</a>`;
            }
            
            card.innerHTML = `
                <div class="reserva-info">
                    <div class="reserva-title">${reserva.quadra?.nome || 'Quadra'}</div>
                    <div class="reserva-meta">
                        <span><i class="bi bi-calendar3"></i> ${formatarData(reserva.data)}</span>
                        <span><i class="bi bi-clock"></i> ${formatarHora(reserva.hora_inicio)} - ${formatarHora(reserva.hora_fim)}</span>
                        <span><i class="bi bi-cash-stack"></i> R$ ${formatarValor(reserva.pagamento?.valor)}</span>
                    </div>
                    ${badges}
                </div>
                <div class="reserva-actions">${actions}</div>
            `;
            container.appendChild(card);
        });
    }

    function formatarData(dataISO) {
        if (!dataISO) return '-';
        const [ano, mes, dia] = String(dataISO).slice(0, 10).split('-');
        return `${dia}/${mes}/${ano}`;
    }
    function formatarHora(hora) { return hora ? String(hora).slice(0, 5) : '-'; }
    function formatarValor(valor) { return Number(valor || 0).toFixed(2).replace('.', ','); }

    function switchTab(tabId, btn) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        btn.classList.add('active');
    }

    function abrirDetalhesReserva(trigger) {
        const card = trigger.closest('.reserva-card');
        const reserva = JSON.parse(card.dataset.reserva.replace(/&quot;/g, '"'));
        reservaEmDetalhe = card;

        document.getElementById('detalhe-quadra').textContent = reserva.quadra?.nome || '-';
        document.getElementById('detalhe-data').textContent = formatarData(reserva.data);
        document.getElementById('detalhe-horario').textContent = `${formatarHora(reserva.hora_inicio)} - ${formatarHora(reserva.hora_fim)}`;
        document.getElementById('detalhe-valor').textContent = `R$ ${formatarValor(reserva.pagamento?.valor)}`;
        document.getElementById('detalhe-responsavel').textContent = reserva.responsavel || '-';
        document.getElementById('detalhe-status').textContent = reserva.status;
        document.getElementById('detalhe-pagamento').textContent = `${reserva.pagamento?.metodo || '-'} - ${reserva.pagamento?.status || '-'}`;
        document.getElementById('detalhe-observacoes').textContent = reserva.observacoes || 'Sem observações.';

        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetalhes')).show();
    }

    async function confirmarCancelamento(trigger) {
        if(!confirm('Tem certeza que deseja cancelar?')) return;
        
        const card = trigger.closest ? trigger.closest('.reserva-card') : trigger;
        if (!card) return;
        
        const reserva = JSON.parse(card.dataset.reserva.replace(/&quot;/g, '"'));
        
        try {
            await EsporTecApi.request(`${API_BASE}/reservas/${reserva.id}/cancelar`, { method: 'PATCH' });
            if (typeof esportecToast === 'function') esportecToast('Reserva cancelada!', 'success');
            await carregarReservas();
        } catch (error) {
            if (typeof esportecToast === 'function') esportecToast(error.message || 'Erro ao cancelar.', 'error');
        }
        bootstrap.Modal.getInstance(document.getElementById('modalDetalhes'))?.hide();
    }

    // ABRIR REMARCAÇÃO - Carrega dados
    function abrirRemarcacao(trigger) {
        const card = trigger.closest('.reserva-card');
        reservaEmRemarcacao = card;
        
        const reserva = JSON.parse(card.dataset.reserva.replace(/&quot;/g, '"'));
        
        document.getElementById('remarcarQuadraNome').value = reserva.quadra?.nome || 'Quadra';
        document.getElementById('remarcarQuadraId').value = reserva.quadra?.id || '';
        document.getElementById('motivoRemarcacao').value = '';
        document.getElementById('novoHorarioReserva').innerHTML = '<option value="">Selecione uma data primeiro</option>';
        document.getElementById('novoHorarioReserva').disabled = true;
        document.getElementById('btnConfirmarRemarcacao').disabled = true;
        
        const hoje = new Date().toISOString().split('T')[0];
        document.getElementById('novaDataReserva').min = hoje;
        document.getElementById('novaDataReserva').value = '';
        
        bootstrap.Modal.getInstance(document.getElementById('modalDetalhes'))?.hide();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalRemarcacao')).show();
    }

    //  CARREGAR HORÁRIOS QUANDO MUDAR DATA
    document.getElementById('novaDataReserva')?.addEventListener('change', async function() {
        const data = this.value;
        const quadraId = document.getElementById('remarcarQuadraId').value;
        const selectHorarios = document.getElementById('novoHorarioReserva');
        const loading = document.getElementById('loadingHorarios');
        const btnConfirmar = document.getElementById('btnConfirmarRemarcacao');
        
        if (!data || !quadraId) {
            selectHorarios.innerHTML = '<option value="">Data inválida</option>';
            selectHorarios.disabled = true;
            btnConfirmar.disabled = true;
            return;
        }
        
        loading.classList.remove('d-none');
        selectHorarios.disabled = true;
        selectHorarios.innerHTML = '<option value="">Carregando...</option>';
        
        try {
            const response = await fetch(`/api/cliente/quadras/${quadraId}/horarios?data=${data}`);
            if (!response.ok) throw new Error('Erro ao carregar');
            
            const responseData = await response.json();
            
            //  CORREÇÃO: Acessar o array correto dentro do objeto
            const horarios = responseData.horarios_disponiveis || [];
            
            if (horarios.length === 0) {
                selectHorarios.innerHTML = '<option value="">Nenhum horário disponível</option>';
                selectHorarios.disabled = true;
                btnConfirmar.disabled = true;
            } else {
                selectHorarios.innerHTML = '<option value="">Selecione um horário</option>';
                
                horarios.forEach(horaInicio => {
                    // horaInicio é uma string "08:00", vamos calcular o fim (ex: +1 hora)
                    // Ajuste a duração aqui se for diferente (ex: 1.5h)
                    const [h, m] = horaInicio.split(':').map(Number);
                    const horaFimH = h + 1; // Duração de 1 hora
                    const horaFim = `${horaFimH.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
                    
                    const valor = `${horaInicio} - ${horaFim}`;
                    
                    const option = document.createElement('option');
                    option.value = valor;
                    option.textContent = `${horaInicio} às ${horaFim}`;
                    selectHorarios.appendChild(option);
                });
                
                selectHorarios.disabled = false;
                btnConfirmar.disabled = false;
            }
        } catch (error) {
            console.error('Erro:', error);
            selectHorarios.innerHTML = '<option value="">Erro ao carregar</option>';
            selectHorarios.disabled = true;
            btnConfirmar.disabled = true;
        } finally {
            loading.classList.add('d-none');
        }
    });
    //  CONFIRMAR REMARCAÇÃO
    async function confirmarRemarcacao() {
        const data = document.getElementById('novaDataReserva').value;
        const horario = document.getElementById('novoHorarioReserva').value;
        const motivo = document.getElementById('motivoRemarcacao').value.trim();
        
        if (!data || !horario) {
            if (typeof esportecToast === 'function') esportecToast('Escolha data e horário.', 'warning');
            return;
        }
        
        if (!reservaEmRemarcacao) return;
        const reserva = JSON.parse(reservaEmRemarcacao.dataset.reserva.replace(/&quot;/g, '"'));
        const [hInicio, hFim] = horario.split(' - ');
        
        const btn = document.getElementById('btnConfirmarRemarcacao');
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Remarcando...';
        
        try {
            await EsporTecApi.request(`${API_BASE}/reservas/${reserva.id}/remarcar`, {
                method: 'PATCH',
                body: JSON.stringify({
                    data: data,
                    hora_inicio: hInicio,
                    hora_fim: hFim,
                    motivo: motivo || 'Remarcação'
                })
            });
            
            if (typeof esportecToast === 'function') esportecToast('Reserva remarcada!', 'success');
            await carregarReservas();
            bootstrap.Modal.getInstance(document.getElementById('modalRemarcacao')).hide();
            
        } catch (error) {
            console.error('Erro:', error);
            if (typeof esportecToast === 'function') esportecToast(error.message || 'Erro ao remarcar.', 'error');
            btn.disabled = false;
            btn.innerHTML = 'Confirmar remarcação';
        }
    }

    function prepararAvaliacao(quadraNome) {
        document.getElementById('avaliar-quadra').textContent = quadraNome || 'Quadra';
    }

    function setRating(n) {
        document.getElementById('rating').value = n;
        document.querySelectorAll('#stars i').forEach((star, i) => {
            star.classList.toggle('bi-star-fill', i < n);
            star.classList.toggle('bi-star', i >= n);
        });
    }

    function submitAvaliacao() {
        if (document.getElementById('rating').value == 0) {
            if (typeof esportecToast === 'function') esportecToast('Selecione uma nota.', 'warning');
            return;
        }
        if (typeof esportecToast === 'function') esportecToast('Avaliação enviada!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('modalAvaliacao')).hide();
    }

    document.addEventListener('DOMContentLoaded', () => {
        carregarReservas();
    });
</script>
</body>
</html>