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

        .tabs-container { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; background: white; padding: 0.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .tab-btn { flex: 1; padding: 0.8rem; border: none; background: transparent; border-radius: 8px; font-weight: 600; color: var(--gray); cursor: pointer; transition: all 0.2s; font-family: inherit; }
        .tab-btn.active { background: var(--primary); color: white; box-shadow: 0 2px 6px rgba(45,129,93,0.3); }

        .reserva-card { background: white; border-radius: 12px; padding: 1.2rem; margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.04); display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; }
        .reserva-info { flex: 1; min-width: 200px; }
        .reserva-title { font-weight: 700; font-size: 1.1rem; margin-bottom: 0.3rem; }
        .reserva-meta { font-size: 0.9rem; color: var(--gray); display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 0.5rem; }
        .reserva-meta i { margin-right: 0.3rem; }

        .badge-status { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
        .badge-pendente { background: rgba(249,168,37,0.15); color: #F9A825; }
        .badge-confirmada { background: rgba(45,129,93,0.15); color: var(--primary); }
        .badge-pago { background: rgba(21,101,192,0.15); color: #1565C0; }
        .badge-cancelada { background: rgba(211,47,47,0.15); color: #D32F2F; }
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

    <div class="tabs-container">
        <button class="tab-btn active" onclick="switchTab('proximas', this)">Próximas</button>
        <button class="tab-btn" onclick="switchTab('passadas', this)">Passadas</button>
        <button class="tab-btn" onclick="switchTab('canceladas', this)">Canceladas</button>
    </div>

    <div id="proximas" class="tab-content active"></div>
    <div id="passadas" class="tab-content"></div>
    <div id="canceladas" class="tab-content"></div>

    <div id="emptyState" class="empty-state d-none">
        <i class="bi bi-calendar-x"></i>
        <p class="mb-0">Nenhuma reserva encontrada nesta categoria.</p>
    </div>
</div>

<!-- Modal Detalhes da Reserva -->
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
                            <strong class="fs-5" id="detalhe-quadra">Society Premium</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Data</small>
                            <strong class="fs-5" id="detalhe-data">14/06/2026</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Responsável pela reserva</small>
                            <strong class="fs-5" id="detalhe-responsavel">João Silva</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Horário</small>
                            <strong class="fs-5" id="detalhe-horario">19:00 - 20:30</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Valor Total</small>
                            <strong class="fs-5 text-success" id="detalhe-valor">R$ 225,00</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge bg-success bg-opacity-10 text-success fs-6" id="detalhe-status">Confirmada</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Forma de Pagamento</small>
                            <strong><i class="bi bi-cash-coin me-2"></i><span id="detalhe-pagamento">Dinheiro - pagamento pendente</span></strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Observações</small>
                            <p class="mb-0 mt-1" id="detalhe-observacoes">Reserva para campeonato interno. Precisamos de 2 bolas extras.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 p-3 border rounded">
                    <strong class="d-block mb-2"><i class="bi bi-geo-alt me-2"></i>Localização:</strong>
                    <p class="mb-1">Rua dos Esportes, 123 - São Paulo, SP</p>
                    <small class="text-muted">Chegar com 10 minutos de antecedência</small>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-outline-success" onclick="abrirRemarcacao(reservaEmDetalhe)">
                    <i class="bi bi-calendar2-week me-2"></i>Remarcar
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmarCancelamento(reservaEmDetalhe)">
                    <i class="bi bi-x-circle me-2"></i>Cancelar Reserva
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
                <p class="text-muted mb-3">Como foi sua experiência na <strong id="avaliar-quadra">Society Premium</strong>?</p>
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
                    <textarea class="form-control" id="comentario-avaliacao" rows="3" maxlength="2000" placeholder="Conte-nos como foi sua experiência..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submitAvaliacao()">
                    <i class="bi bi-check-lg me-2"></i>Enviar Avaliação
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Remarcação -->
<div class="modal fade" id="modalRemarcacao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Remarcar reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success bg-success bg-opacity-10 text-success border-0">
                    Escolha uma nova data e horário. A alteração fica registrada como remarcação no histórico.
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Nova data</label>
                    <input type="date" class="form-control" id="novaDataReserva">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Novo horário</label>
                    <select class="form-select" id="novoHorarioReserva">
                        <option value="">Selecione</option>
                        <option>16:00 - 17:00</option>
                        <option>18:00 - 19:00</option>
                        <option>20:00 - 21:30</option>
                    </select>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-medium">Motivo da remarcação</label>
                    <textarea class="form-control" id="motivoRemarcacao" rows="3" placeholder="Ex: precisei alterar o horário do grupo"></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="confirmarRemarcacao()">Confirmar remarcação</button>
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
    let reservaEmAvaliacao = null;
    let botaoAvaliacaoAtual = null;

    async function carregarReservas() {
        try {
            const reservas = await EsporTecApi.request(`${API_BASE}/reservas`);
            renderizarTodasReservas(reservas);
        } catch (error) {
            console.log('Erro ao carregar reservas da API.', error);
            renderizarTodasReservas([]);
        }
    }

    function renderizarTodasReservas(reservas) {
        const agora = new Date();
        const hoje = `${agora.getFullYear()}-${String(agora.getMonth() + 1).padStart(2, '0')}-${String(agora.getDate()).padStart(2, '0')}`;
        const dataReserva = reserva => String(reserva.data || '').slice(0, 10);

        renderizarAba('proximas', reservas.filter(r =>
            dataReserva(r) >= hoje && r.status !== 'cancelada'
        ));
        renderizarAba('passadas', reservas.filter(r =>
            dataReserva(r) < hoje && r.status !== 'cancelada'
        ));
        renderizarAba('canceladas', reservas.filter(r => r.status === 'cancelada'));

        const todasVazias = ['proximas', 'passadas', 'canceladas'].every(id =>
            document.getElementById(id).children.length === 0
        );
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
            card.dataset.responsavel = reserva.responsavel || 'João Silva';
            card.dataset.pagamento = `${reserva.pagamento?.metodo || 'Não informado'} - ${formatarStatusPagamento(reserva.pagamento?.status)}`;
            card.dataset.observacoes = reserva.observacoes || 'Sem observações.';

            const badges = getBadgesHTML(reserva);
            const actions = getActionsHTML(reserva, abaId);

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
                <div class="reserva-actions">
                    ${actions}
                </div>
            `;
            container.appendChild(card);
        });
    }

    function getBadgesHTML(reserva) {
        let html = '';
        if (reserva.status === 'confirmada') {
            html += `<span class="badge-status badge-confirmada">Reserva confirmada</span>`;
        } else if (reserva.status === 'pendente') {
            html += `<span class="badge-status badge-pendente">Reserva pendente</span>`;
        } else if (reserva.status === 'concluida') {
            html += `<span class="badge-status badge-concluida">Concluída</span>`;
        } else if (reserva.status === 'cancelada') {
            html += `<span class="badge-status badge-cancelada">Cancelada</span>`;
        }
        if (reserva.pagamento?.status === 'pago') {
            html += `<span class="badge-status badge-pago ms-2">Pagamento pago</span>`;
        } else if (reserva.pagamento?.status === 'pendente') {
            html += `<span class="badge-status badge-pendente ms-2">Pagamento pendente</span>`;
        }
        return html;
    }

    function getActionsHTML(reserva, abaId) {
        let html = `<button class="btn-action btn-primary" onclick="abrirDetalhesReserva(this)"><i class="bi bi-eye"></i> Detalhes</button>`;

        if (abaId === 'passadas' && reserva.status === 'concluida') {
            const jaAvaliada = reserva.feedbacks?.some(feedback => feedback.momento === 'pos_jogo');
            html += jaAvaliada
                ? `<button class="btn-action btn-outline" type="button" disabled><i class="bi bi-check2"></i> Avaliada</button>`
                : `<button class="btn-action btn-outline" type="button" onclick="prepararAvaliacao(this)"><i class="bi bi-star"></i> Avaliar</button>`;
        }
        if (abaId === 'proximas' && reserva.status !== 'cancelada') {
            if (reserva.status === 'confirmada') {
                html += `<button class="btn-action btn-primary" onclick="abrirListaPartida(this)"><i class="bi bi-people"></i> Ver lista do jogo</button>`;
                html += `<button class="btn-action btn-outline" onclick="compartilharPartida(this)"><i class="bi bi-share"></i> Compartilhar lista</button>`;
            }
            html += `<button class="btn-action btn-outline" onclick="abrirRemarcacao(this)"><i class="bi bi-calendar2-week"></i> Remarcar</button>`;
            html += `<button class="btn-action btn-danger" onclick="confirmarCancelamento(this)"><i class="bi bi-x-circle"></i> Cancelar</button>`;
        }
        if (abaId === 'canceladas') {
            html += `<a href="/nova-reserva" class="btn-action btn-outline"><i class="bi bi-arrow-repeat"></i> Nova reserva</a>`;
        }
        return html;
    }

    function formatarData(dataISO) {
        if (!dataISO) return '-';
        const [ano, mes, dia] = String(dataISO).slice(0, 10).split('-');
        return `${dia}/${mes}/${ano}`;
    }
    function formatarHora(hora) { return hora ? String(hora).slice(0, 5) : '-'; }
    function formatarValor(valor) { return Number(valor || 0).toFixed(2).replace('.', ','); }
    function formatarStatus(status) {
        const map = { 'pendente': 'Pendente', 'confirmada': 'Confirmada', 'concluida': 'Concluída', 'cancelada': 'Cancelada' };
        return map[status] || status;
    }
    function formatarStatusPagamento(status) {
        const map = { 'pago': 'pago', 'pendente': 'pagamento pendente', 'cancelado': 'cancelado' };
        return map[status] || 'pendente';
    }

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
        document.getElementById('detalhe-status').textContent = formatarStatus(reserva.status);
        document.getElementById('detalhe-pagamento').textContent = `${reserva.pagamento?.metodo || '-'} - ${formatarStatusPagamento(reserva.pagamento?.status)}`;
        document.getElementById('detalhe-observacoes').textContent = reserva.observacoes || 'Sem observações.';

        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetalhes')).show();
    }

    async function obterLinkPartida(trigger) {
        const card = trigger.closest('.reserva-card');
        const reserva = JSON.parse(card.dataset.reserva.replace(/&quot;/g, '"'));
        const dados = await EsporTecApi.request(`/api/cliente/reservas/${reserva.id}/partida`, { method: 'POST' });

        return {
            link: `${window.location.origin}${dados.caminho}`,
            reserva
        };
    }

    async function abrirListaPartida(trigger) {
        try {
            const { link } = await obterLinkPartida(trigger);
            window.location.href = link;
        } catch (erro) {
            esportecToast(erro.message || 'Não foi possível abrir a lista do jogo.', 'warning');
        }
    }

    async function compartilharPartida(trigger) {
        try {
            const { link, reserva } = await obterLinkPartida(trigger);
            if (navigator.share) await navigator.share({ title: 'Lista de participantes do jogo', text: `Entre na lista do jogo em ${reserva.quadra?.nome || 'EsporTec'}`, url: link });
            else { await navigator.clipboard.writeText(link); esportecToast('Link da lista copiado.', 'success'); }
        } catch (erro) {
            if (erro.name !== 'AbortError') esportecToast(erro.message, 'warning');
        }
    }

    async function confirmarCancelamento(trigger) {
        if (!confirm('Tem certeza que deseja cancelar esta reserva?')) return;
        const card = trigger.closest ? trigger.closest('.reserva-card') : trigger;
        if (!card) return;
        const reserva = JSON.parse(card.dataset.reserva.replace(/&quot;/g, '"'));
        if (!reserva.id) {
            esportecToast('Não foi possível identificar a reserva.', 'warning');
            return;
        }

        if (trigger.disabled !== undefined) trigger.disabled = true;
        try {
            await EsporTecApi.request(`/api/reservas/${reserva.id}/cancelar`, {
                method: 'PATCH',
                body: JSON.stringify({ observacao: reserva.observacao || null })
            });
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes'))?.hide();
            await carregarReservas();
            switchTab('canceladas', document.querySelectorAll('.tab-btn')[2]);
            esportecToast('Reserva cancelada.', 'success');
        } catch (erro) {
            esportecToast(erro.message || 'Não foi possível cancelar a reserva.', 'warning');
        } finally {
            if (trigger.disabled !== undefined) trigger.disabled = false;
        }
    }

    function abrirRemarcacao(trigger) {
        reservaEmRemarcacao = trigger.closest ? trigger.closest('.reserva-card') : trigger;
        bootstrap.Modal.getInstance(document.getElementById('modalDetalhes'))?.hide();
        document.getElementById('novaDataReserva').value = '';
        document.getElementById('novoHorarioReserva').value = '';
        document.getElementById('motivoRemarcacao').value = '';
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalRemarcacao')).show();
    }

    async function confirmarRemarcacao() {
        const data = document.getElementById('novaDataReserva').value;
        const horario = document.getElementById('novoHorarioReserva').value;
        const motivo = document.getElementById('motivoRemarcacao').value.trim();

        if (!data || !horario) {
            if (typeof esportecToast === 'function') esportecToast('Escolha data e horário.', 'warning');
            return;
        }
        if (!reservaEmRemarcacao) {
            esportecToast('Não foi possível identificar a reserva.', 'warning');
            return;
        }

        const reserva = JSON.parse(reservaEmRemarcacao.dataset.reserva.replace(/&quot;/g, '"'));
        if (!reserva.id) {
            esportecToast('Não foi possível identificar a reserva.', 'warning');
            return;
        }

        const [horaInicio, horaFim] = horario.split(' - ').map(h => h.trim());

        const btnConfirmar = document.querySelector('#modalRemarcacao .btn-success');
        if (btnConfirmar) btnConfirmar.disabled = true;

        try {
            await EsporTecApi.request(`/api/cliente/reservas/${reserva.id}/remarcar`, {
                method: 'PATCH',
                body: JSON.stringify({
                    data: data,
                    hora_inicio: horaInicio,
                    hora_fim: horaFim,
                    motivo: motivo || null
                })
            });

            bootstrap.Modal.getInstance(document.getElementById('modalRemarcacao')).hide();
            await carregarReservas();
            if (typeof esportecToast === 'function') esportecToast('Reserva remarcada com sucesso.', 'success');
        } catch (erro) {
            if (typeof esportecToast === 'function') esportecToast(erro.message || 'Não foi possível remarcar a reserva.', 'warning');
        } finally {
            if (btnConfirmar) btnConfirmar.disabled = false;
        }
    }

    function prepararAvaliacao(trigger) {
        const card = trigger.closest('.reserva-card');
        reservaEmAvaliacao = JSON.parse(card.dataset.reserva.replace(/&quot;/g, '"'));
        botaoAvaliacaoAtual = trigger;
        document.getElementById('avaliar-quadra').textContent = reservaEmAvaliacao.quadra?.nome || 'Quadra';
        document.getElementById('rating').value = '0';
        document.getElementById('comentario-avaliacao').value = '';
        document.querySelectorAll('#stars i').forEach(star => {
            star.classList.remove('bi-star-fill');
            star.classList.add('bi-star');
        });
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalAvaliacao')).show();
    }

    function setRating(n) {
        document.getElementById('rating').value = n;
        const stars = document.querySelectorAll('#stars i');
        stars.forEach((star, index) => {
            star.classList.toggle('bi-star-fill', index < n);
            star.classList.toggle('bi-star', index >= n);
        });
    }

    async function submitAvaliacao() {
        const rating = Number(document.getElementById('rating').value);
        if (rating == 0) {
            if (typeof esportecToast === 'function') esportecToast('Selecione uma nota.', 'warning');
            return;
        }
        if (!reservaEmAvaliacao?.id) {
            esportecToast('Não foi possível identificar a reserva.', 'warning');
            return;
        }

        const enviar = document.querySelector('#modalAvaliacao .btn-primary');
        enviar.disabled = true;
        try {
            const resposta = await EsporTecApi.request(`/api/cliente/reservas/${reservaEmAvaliacao.id}/avaliacao`, {
                method: 'POST',
                body: JSON.stringify({
                    nota: rating,
                    comentario: document.getElementById('comentario-avaliacao').value.trim() || null
                })
            });
            if (botaoAvaliacaoAtual) {
                botaoAvaliacaoAtual.innerHTML = '<i class="bi bi-check2"></i> Avaliada';
                botaoAvaliacaoAtual.disabled = true;
                botaoAvaliacaoAtual.removeAttribute('onclick');
            }
            bootstrap.Modal.getInstance(document.getElementById('modalAvaliacao')).hide();
            esportecToast(resposta.message || 'Avaliação enviada!', 'success');
        } catch (erro) {
            esportecToast(erro.message || 'Não foi possível enviar a avaliação.', 'warning');
        } finally {
            enviar.disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        carregarReservas();
    });
</script>
</body>
</html>