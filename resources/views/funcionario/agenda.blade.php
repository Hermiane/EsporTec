<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agenda - EsporTec Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --light:#E8F5EE; --bg:#F8FAFC; --text:#334155; }
        body { margin:0; font-family:'Poppins',sans-serif; background:var(--bg); color:var(--text); }
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:250px; background:var(--dark); color:white; padding:1.5rem; flex-shrink:0; }
        .sidebar-brand { color:white; font-size:1.4rem; font-weight:700; text-decoration:none; display:block; margin-bottom:2rem; }
        .nav-link { color:rgba(255,255,255,.76); border-radius:8px; padding:.75rem 1rem; margin-bottom:.4rem; display:flex; gap:.75rem; align-items:center; text-decoration:none; }
        .nav-link:hover,.nav-link.active { background:rgba(255,255,255,.12); color:white; }
        .main { flex:1; padding:2rem; overflow-x:hidden; }
        .card-soft { background:white; border:0; border-radius:12px; box-shadow:0 4px 16px rgba(15,23,42,.06); }
        .agenda-grid { display:grid; grid-template-columns:120px repeat(3,minmax(180px,1fr)); min-width:720px; border:1px solid #E2E8F0; border-radius:12px; overflow:hidden; }
        .cell { padding:.85rem; border-right:1px solid #E2E8F0; border-bottom:1px solid #E2E8F0; min-height:76px; background:white; }
        .cell:nth-child(4n) { border-right:0; }
        .head { background:var(--light); font-weight:700; color:var(--dark); }
        .hour { color:#64748B; font-weight:600; background:#F8FAFC; }
        .booking { border-radius:10px; padding:.65rem; font-size:.85rem; cursor:pointer; transition:all 0.2s; }
        .booking:hover { transform:translateY(-2px); box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        .booking.cancelled { background:#FEE2E2; color:#991B1B; border:1px solid #FCA5A5; }
        .confirmed { background:rgba(45,129,93,.14); color:var(--dark); border:1px solid rgba(45,129,93,.24); }
        .pending { background:rgba(249,168,37,.18); color:#8A5A00; border:1px solid rgba(249,168,37,.28); }
        .busy { background:#F1F5F9; color:#64748B; }
        .btn-success { background:var(--primary); border-color:var(--primary); }
        @media (max-width: 992px) { .layout { display:block; } .sidebar { width:100%; } .main { padding:1rem; } }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/painel-funcionario" class="sidebar-brand">EsporTec <small class="opacity-75">FUNCIONÁRIO</small></a>
        <nav>
            <a href="/painel-funcionario" class="nav-link"><i class="bi bi-grid"></i> Painel</a>
            <a href="/funcionario/agenda" class="nav-link active"><i class="bi bi-calendar-week"></i> Agenda</a>
            <a href="/funcionario/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/funcionario/perfil" class="nav-link"><i class="bi bi-person"></i> Perfil</a>
        </nav>
    </aside>

    <main class="main">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Agenda</h1>
                <p class="text-muted mb-0">Toque em uma reserva para ver detalhes, pagamento e ações.</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <input type="date" class="form-control" id="dataSelecionada" value="">
                <div class="btn-group" role="group" aria-label="Tipo de visão">
                    <button class="btn btn-success active" id="btnDia">Dia</button>
                    <button class="btn btn-outline-success" id="btnSemana">Semana</button>
                </div>
            </div>
        </div>

        <section class="row g-3 mb-4">
            <div class="col-md-3"><div class="card-soft p-3"><span class="text-muted small">Reservas hoje</span><h3 class="fw-bold mb-0" id="countReservas">-</h3></div></div>
            <div class="col-md-3"><div class="card-soft p-3"><span class="text-muted small">Pagamentos pendentes</span><h3 class="fw-bold mb-0 text-warning" id="countPendentes">-</h3></div></div>
            <div class="col-md-3"><div class="card-soft p-3"><span class="text-muted small">Quadras ativas</span><h3 class="fw-bold mb-0 text-success" id="countQuadras">-</h3></div></div>
            <div class="col-md-3"><div class="card-soft p-3"><span class="text-muted small">Próxima reserva</span><h3 class="fw-bold mb-0" id="proximaReserva">-</h3></div></div>
        </section>

        <section class="card-soft p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0" id="agendaTitulo">Grade por quadra - visão do dia</h5>
                <span class="text-muted small">Somente dados reais da arena</span>
            </div>
            <div class="table-responsive">
                <div class="agenda-grid" id="agendaGrid">
                    <!-- Preenchido via JS -->
                    <div class="cell hour">Carregando...</div>
                </div>
            </div>
        </section>

        <section class="card-soft p-4">
            <h5 class="fw-bold mb-3">Alertas do dia</h5>
            <div class="list-group list-group-flush" id="alertasDia">
                <div class="list-group-item px-0"><i class="bi bi-hourglass-split text-muted me-2"></i>Carregando alertas...</div>
            </div>
        </section>
    </main>
</div>

<div class="modal fade" id="modalDetalhes" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">Detalhes da reserva</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body" id="modalDetalhesContent">
            <p><strong>Cliente:</strong> Carregando...</p>
            <p><strong>Quadra:</strong> -</p>
            <p><strong>Data/Hora:</strong> -</p>
            <p><strong>Pagamento:</strong> -</p>
        </div>
        <div class="modal-footer flex-wrap">
            <button class="btn btn-success" id="btnConfirmarPagamentoModal"><i class="bi bi-check-circle me-1"></i>Confirmar pagamento</button>
            <button class="btn btn-outline-danger" id="btnCancelarReservaModal"><i class="bi bi-x-circle me-1"></i>Cancelar</button>
        </div>
    </div></div>
</div>

<div class="modal fade" id="modalReserva" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">Nova reserva manual</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <input class="form-control mb-3" id="reservaManualCliente" placeholder="Nome do cliente">
            <select class="form-select mb-3" id="reservaManualQuadra"><option value="">Selecione...</option><option value="1">Futsal Arena</option><option value="2">Society Premium</option><option value="3">Society Descoberta</option></select>
            <div class="row g-3"><div class="col-6"><input type="date" class="form-control" id="reservaManualData"></div><div class="col-6"><input type="time" class="form-control" id="reservaManualHora"></div></div>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-success" id="btnCriarReservaManual">Criar</button></div>
    </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script type="text/plain" id="legacyAgendaScript">
    
    //  INTEGRAÇÃO COM API - AGENDA FUNCIONÁRIO
   
    const API_BASE = '/api';
    const HOJE = new Date().toISOString().split('T')[0];
    
    // Mock data para fallback
    const MOCK_AGENDA = [
        { id: 1, data: HOJE, hora_inicio: '09:00', hora_fim: '10:00', status: 'confirmada', quadra: { id: 1, nome: 'Futsal Arena' }, usuario: { nome: 'Pedro Santos' }, pagamento: { status: 'pago', metodo: 'pix', valor: 120.00 } },
        { id: 2, data: HOJE, hora_inicio: '10:00', hora_fim: '11:30', status: 'pendente', quadra: { id: 3, nome: 'Society Descoberta' }, usuario: { nome: 'Ana Lima' }, pagamento: { status: 'pendente', metodo: 'dinheiro', valor: 100.00 } },
        { id: 3, data: HOJE, hora_inicio: '14:00', hora_fim: '15:30', status: 'confirmada', quadra: { id: 2, nome: 'Society Premium' }, usuario: { nome: 'Grupo Unidos' }, pagamento: { status: 'pago', metodo: 'cartao_credito', valor: 150.00 } },
        { id: 4, data: HOJE, hora_inicio: '19:00', hora_fim: '20:30', status: 'agendada', quadra: { id: 2, nome: 'Society Premium' }, usuario: { nome: 'João Silva' }, pagamento: { status: 'pendente', metodo: 'pix', valor: 150.00 } }
    ];

    let selectedBooking = null;
    let currentView = 'dia'; // 'dia' ou 'semana'

    //  CARREGAR AGENDA - API: GET /api/funcionario/agenda/semana (ou /dia)
    async function carregarAgenda() {
        try {
            const url = currentView === 'semana' ? 
                `${API_BASE}/funcionario/agenda/semana` : 
                `${API_BASE}/funcionario/agenda/dia`;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            const agenda = await response.json();
            renderizarGrade(agenda);
            atualizarStats(agenda);
            console.log(' Agenda carregada da API');
        } catch (error) {
            console.log(' Usando dados de teste:', error.message);
            renderizarGrade(MOCK_AGENDA);
            atualizarStats(MOCK_AGENDA);
        }
    }

    function renderizarGrade(reservas) {
        const grid = document.getElementById('agendaGrid');
        grid.innerHTML = '';

        // Cabeçalho
        grid.innerHTML += `
            <div class="cell head">Horário</div>
            <div class="cell head">Futsal Arena</div>
            <div class="cell head">Society Premium</div>
            <div class="cell head">Society Descoberta</div>
        `;

        // Horários fixos (09:00 às 21:00)
        const horarios = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00'];
        const quadras = [1, 2, 3];

        horarios.forEach(hora => {
            grid.innerHTML += `<div class="cell hour">${hora}</div>`;
            
            quadras.forEach(quadraId => {
                const reserva = reservas.find(r => {
                    const quadraMatch = r.quadra?.id === quadraId;
                    const horaMatch = r.hora_inicio.startsWith(hora);
                    return quadraMatch && horaMatch;
                });

                if (reserva) {
                    const classe = getStatusClass(reserva.status);
                    const pagamentoInfo = getPagamentoInfo(reserva.pagamento);
                    grid.innerHTML += `
                        <div class="cell">
                            <div class="booking ${classe}" data-reserva-id="${reserva.id}" onclick="abrirDetalhes(${reserva.id})">
                                <strong>${reserva.usuario?.nome || 'Cliente'}</strong><br>
                                <small>${pagamentoInfo}</small>
                            </div>
                        </div>
                    `;
                } else {
                    grid.innerHTML += `<div class="cell busy">Livre</div>`;
                }
            });
        });
    }

    function getStatusClass(status) {
        const map = {
            'confirmada': 'confirmed',
            'pendente': 'pending',
            'agendada': 'pending',
            'cancelada': 'cancelled',
            'concluida': 'confirmed'
        };
        return map[status] || 'busy';
    }

    function getPagamentoInfo(pagamento) {
        if (!pagamento) return '-';
        if (pagamento.status === 'pago') return `Pago (${formatarMetodo(pagamento.metodo)})`;
        return `${formatarMetodo(pagamento.metodo)} pendente`;
    }

    function formatarMetodo(metodo) {
        const map = { 'pix': 'PIX', 'dinheiro': 'Dinheiro', 'cartao_credito': 'Cartão', 'cartao_debito': 'Débito' };
        return map[metodo] || metodo;
    }

   function atualizarStats(reservas) {
    const hoje = new Date().toISOString().split('T')[0];
    const reservasHoje = reservas.filter(r => r.data === hoje);
    
    document.getElementById('countReservas').textContent = reservasHoje.length;
    document.getElementById('countPendentes').textContent = reservasHoje.filter(r => r.pagamento?.status === 'pendente').length;
    
    const proxima = reservasHoje.filter(r => r.status !== 'cancelada')
        .sort((a, b) => a.hora_inicio.localeCompare(b.hora_inicio))[0];
    document.getElementById('proximaReserva').textContent = proxima ? proxima.hora_inicio : '-';

    //  ALERTAS DO DIA
    const alertasContainer = document.getElementById('alertasDia');
    alertasContainer.innerHTML = '';
    
    const alertas = [];
    
    // Alerta: Pagamentos pendentes
    const pendentes = reservasHoje.filter(r => r.pagamento?.status === 'pendente');
    if (pendentes.length > 0) {
        alertas.push({
            icon: 'bi-exclamation-triangle text-warning',
            text: `${pendentes.length} pagamento${pendentes.length > 1 ? 's' : ''} ainda precisa${pendentes.length > 1 ? 'm' : ''} ser conferido${pendentes.length > 1 ? 's' : ''}.`
        });
    }
    
    // Alerta: Aniversariantes (mock - quando backend tiver API)
    alertas.push({
        icon: 'bi-gift text-success',
        text: 'Maria Oliveira faz aniversário hoje.'
    });
    
    // Alerta: Cliente fiel
    alertas.push({
        icon: 'bi-star text-primary',
        text: 'João Silva completou 10 visitas no mês.'
    });
    
    // Renderiza alertas
    if (alertas.length > 0) {
        alertas.forEach(alerta => {
            alertasContainer.innerHTML += `
                <div class="list-group-item px-0">
                    <i class="bi ${alerta.icon} me-2"></i>${alerta.text}
                </div>
            `;
        });
    } else {
        alertasContainer.innerHTML = '<div class="list-group-item px-0 text-muted"><i class="bi bi-check-circle me-2"></i>Tudo em ordem!</div>';
    }
}

    //  ABRIR DETALHES - API: GET /api/reservas/{id} (opcional)
    async function abrirDetalhes(reservaId) {
        selectedBooking = reservaId;
        
        try {
            const response = await fetch(`${API_BASE}/reservas/${reservaId}`);
            if (!response.ok) throw new Error('Erro');
            const reserva = await response.json();
            preencherModalDetalhes(reserva);
        } catch (error) {
            // Fallback: busca no mock
            const reserva = MOCK_AGENDA.find(r => r.id === reservaId) || { id: reservaId };
            preencherModalDetalhes(reserva);
        }
        
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetalhes')).show();
    }

    function preencherModalDetalhes(reserva) {
        const content = document.getElementById('modalDetalhesContent');
        content.innerHTML = `
            <p><strong>Cliente:</strong> ${reserva.usuario?.nome || 'Cliente'}</p>
            <p><strong>Quadra:</strong> ${reserva.quadra?.nome || '-'}</p>
            <p><strong>Data/Hora:</strong> ${formatarData(reserva.data)} ${reserva.hora_inicio} - ${reserva.hora_fim}</p>
            <p><strong>Status:</strong> ${reserva.status}</p>
            <p><strong>Pagamento:</strong> ${getPagamentoInfo(reserva.pagamento)}</p>
            <p><strong>Valor:</strong> R$ ${(reserva.pagamento?.valor || 0).toFixed(2).replace('.', ',')}</p>
        `;

        // Configura botões
        const btnPagamento = document.getElementById('btnConfirmarPagamentoModal');
        const btnCancelar = document.getElementById('btnCancelarReservaModal');
        
        if (reserva.pagamento?.status === 'pago') {
            btnPagamento.disabled = true;
            btnPagamento.innerHTML = '<i class="bi bi-check2-circle me-1"></i>Pago';
        } else {
            btnPagamento.disabled = false;
            btnPagamento.innerHTML = '<i class="bi bi-check-circle me-1"></i>Confirmar pagamento';
            btnPagamento.onclick = () => confirmarPagamento(reserva.pagamento?.id || reserva.id);
        }

        if (reserva.status === 'cancelada') {
            btnCancelar.disabled = true;
            btnCancelar.innerHTML = '<i class="bi bi-x-circle me-1"></i>Cancelada';
        } else {
            btnCancelar.disabled = false;
            btnCancelar.innerHTML = '<i class="bi bi-x-circle me-1"></i>Cancelar';
            btnCancelar.onclick = () => cancelarReserva(reserva.id);
        }

        document.getElementById('btnAlterarHorarioModal').onclick = () => {
            esportecToast('Horário liberado para alteração. Escolha outro horário na grade.', 'info');
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
        };
    }

    function formatarData(dataISO) {
        if (!dataISO) return '-';
        const [ano, mes, dia] = dataISO.split('-');
        return `${dia}/${mes}/${ano}`;
    }

    //  CONFIRMAR PAGAMENTO - API: PATCH /api/funcionario/pagamentos/{id}/confirmar
    async function confirmarPagamento(pagamentoId) {
        if (!confirm('Confirmar recebimento do pagamento?')) return;
        
        try {
            const response = await fetch(`${API_BASE}/funcionario/pagamentos/${pagamentoId}/confirmar`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            if (!response.ok) throw new Error('Erro');
            
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
            esportecToast('Pagamento confirmado.', 'success');
            carregarAgenda(); // Recarrega a grade
        } catch (error) {
            console.error('Erro ao confirmar pagamento:', error);
            // Fallback visual
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
            esportecToast('Pagamento confirmado (simulado).', 'success');
            carregarAgenda();
        }
    }

    //  CANCELAR RESERVA - API: PATCH /api/agendamentos/{id}/cancelar
    async function cancelarReserva(reservaId) {
        if (!confirm('Cancelar esta reserva?')) return;
        
        try {
            const response = await fetch(`${API_BASE}/agendamentos/${reservaId}/cancelar`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            if (!response.ok) throw new Error('Erro');
            
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
            esportecToast('Reserva cancelada.', 'success');
            carregarAgenda();
        } catch (error) {
            console.error('Erro ao cancelar:', error);
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
            esportecToast('Reserva cancelada (simulado).', 'success');
            carregarAgenda();
        }
    }

    //  CRIAR RESERVA MANUAL - API: POST /api/reservas
    document.getElementById('btnCriarReservaManual').addEventListener('click', async () => {
        const payload = {
            usuario_id: 1,
            quadra_id: document.getElementById('reservaManualQuadra').value,
            data: document.getElementById('reservaManualData').value,
            hora_inicio: document.getElementById('reservaManualHora').value,
            hora_fim: '21:00', // Simplificado
            valor_total: 100.00, // Simplificado
            observacao: 'Reserva manual'
        };

        if (!payload.quadra_id || !payload.data || !payload.hora_inicio) {
            esportecToast('Preencha todos os campos.', 'warning');
            return;
        }

        try {
            const response = await fetch(`${API_BASE}/reservas`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) throw new Error('Erro');
            
            bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
            esportecToast('Reserva criada.', 'success');
            carregarAgenda();
        } catch (error) {
            console.error('Erro ao criar reserva:', error);
            bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
            esportecToast('Reserva criada (simulado).', 'success');
            carregarAgenda();
        }
    });

    // Toggle Dia/Semana
    document.getElementById('btnDia').addEventListener('click', () => {
        currentView = 'dia';
        document.getElementById('btnDia').className = 'btn btn-success active';
        document.getElementById('btnSemana').className = 'btn btn-outline-success';
        document.getElementById('agendaTitulo').textContent = 'Grade por quadra - visão do dia';
        carregarAgenda();
    });

    document.getElementById('btnSemana').addEventListener('click', () => {
        currentView = 'semana';
        document.getElementById('btnSemana').className = 'btn btn-success active';
        document.getElementById('btnDia').className = 'btn btn-outline-success';
        document.getElementById('agendaTitulo').textContent = 'Grade por quadra - visão semanal';
        carregarAgenda();
    });

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('dataSelecionada').value = HOJE;
        carregarAgenda();
    });
</script>
<script src="/js/funcionario-agenda.js"></script>
</body>
</html>
