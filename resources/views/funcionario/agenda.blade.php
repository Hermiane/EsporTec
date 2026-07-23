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
        
    
        .sidebar {
            width:250px;
            background:linear-gradient(180deg, var(--dark) 0%, #154030 100%);
            color:white;
            padding:1.5rem;
            position:fixed;
            height:100vh;
            left:0;
            top:0;
            overflow-y:auto;
            z-index:1000;
        }
        .sidebar-brand {
            color:white;
            font-size:1.6rem;
            font-weight:700;
            text-decoration:none;
            display:flex;
            align-items:center;
            gap:0.75rem;
            margin-bottom:3rem;
            padding-bottom:1.5rem;
            border-bottom:1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand i { font-size:2rem; color:#4ADE80; }
        .sidebar-brand small { display:block; font-size:0.75rem; opacity:0.7; margin-top:-0.2rem; font-weight:400; }
        .nav-link {
            color:rgba(255,255,255,0.7);
            padding:0.9rem 1rem;
            border-radius:10px;
            margin-bottom:0.5rem;
            display:flex;
            align-items:center;
            gap:0.8rem;
            text-decoration:none;
            transition:all 0.3s;
            font-weight:500;
        }
        .nav-link:hover,.nav-link.active {
            background:rgba(255,255,255,0.15);
            color:white;
            transform:translateX(5px);
        }
        
        .main { flex:1; margin-left:250px; padding:2rem; overflow-x:hidden; }
        
    
        .page-header h1 {
            font-size: 1.3rem !important;
            font-weight: 600 !important;
        }
        .page-header p {
            font-size: 0.9rem !important;
            color: #64748B !important;
        }
        
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
        
        
        .btn-action {
            padding: 0.4rem 0.7rem;
            border-radius: 6px;
            font-size: 0.75rem;
            border: 1px solid;
            cursor: pointer;
            margin: 0.15rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            white-space: nowrap;
            background: white;
            transition: all 0.2s;
        }
        .btn-action:hover { transform: translateY(-1px); }
        .btn-confirm { background: #F0FDF4; color: #15803D; border-color: #BBF7D0; }
        .btn-confirm:hover { background: #DCFCE7; }
        .btn-cancel { background: #FEF2F2; color: #B91C1C; border-color: #FECACA; }
        .btn-cancel:hover { background: #FEE2E2; }
        .btn-edit { background: #EFF6FF; color: #1D4ED8; border-color: #BFDBFE; }
        .btn-edit:hover { background: #DBEAFE; }
        .btn-pay { background: #F0FDF4; color: #15803D; border-color: #BBF7D0; }
        .btn-pay:hover { background: #DCFCE7; }
        
        .btn-success { background:var(--primary); border-color:var(--primary); }
        @media (max-width: 992px) { .layout { display:block; } .sidebar { width:100%; position:relative; height:auto; } .main { margin-left:0; padding:1rem; } }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/painel-funcionario" class="sidebar-brand">
            <i class="bi bi-trophy"></i>
            <div>
                EsporTec
                <small>Área do Funcionário</small>
            </div>
        </a>
        <nav>
            <a href="/painel-funcionario" class="nav-link"><i class="bi bi-grid"></i> Painel</a>
            <a href="/funcionario/agenda" class="nav-link active"><i class="bi bi-calendar-week"></i> Agenda</a>
            <a href="/funcionario/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/funcionario/perfil" class="nav-link"><i class="bi bi-person"></i> Perfil</a>
        </nav>
    </aside>
    <main class="main">
        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 page-header">
            <div>
                <h1 class="fw-bold mb-1"><i class="bi bi-calendar-week me-2"></i>Agenda</h1>
                <p class="text-muted mb-0">Toque em uma reserva para ver detalhes e ações.</p>
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
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalReserva">Nova reserva manual</button>
            </div>
            <div class="table-responsive">
                <div class="agenda-grid" id="agendaGrid">
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

<!-- Modal Detalhes -->
<div class="modal fade" id="modalDetalhes" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">Detalhes da reserva</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body" id="modalDetalhesContent"><p><strong>Cliente:</strong> Carregando...</p><p><strong>Quadra:</strong> -</p><p><strong>Data/Hora:</strong> -</p><p><strong>Pagamento:</strong> -</p></div>
        <div class="modal-footer flex-wrap">
            <button class="btn btn-success" id="btnConfirmarPagamentoModal"><i class="bi bi-check-circle me-1"></i>Confirmar pagamento</button>
            <button class="btn btn-outline-danger" id="btnCancelarReservaModal"><i class="bi bi-x-circle me-1"></i>Cancelar</button>
        </div>
    </div></div>
</div>

<!-- MODAL NOVA RESERVA MANUAL -->
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
<script>
    const API_BASE = '/api';
    const HOJE = new Date().toISOString().split('T')[0];
    const MOCK_AGENDA = [
        { id: 1, data: HOJE, hora_inicio: '09:00', hora_fim: '10:00', status: 'confirmada', quadra: { id: 1, nome: 'Futsal Arena' }, usuario: { nome_completo: 'Pedro Santos', nome: 'Pedro Santos' }, pagamento: { status: 'pago', metodo: 'pix', valor: 120.00 } },
        { id: 2, data: HOJE, hora_inicio: '10:00', hora_fim: '11:30', status: 'pendente', quadra: { id: 3, nome: 'Society Descoberta' }, usuario: { nome_completo: 'Ana Lima', nome: 'Ana Lima' }, pagamento: { status: 'pendente', metodo: 'dinheiro', valor: 100.00 } },
        { id: 3, data: HOJE, hora_inicio: '14:00', hora_fim: '15:30', status: 'confirmada', quadra: { id: 2, nome: 'Society Premium' }, usuario: { nome_completo: 'Grupo Unidos', nome: 'Grupo Unidos' }, pagamento: { status: 'pago', metodo: 'cartao_credito', valor: 150.00 } }
    ];
    let currentView = 'dia';

    async function carregarAgenda() {
        try {
            const url = currentView === 'semana' ? `${API_BASE}/funcionario/agenda/semana` : `${API_BASE}/funcionario/agenda/dia`;
            const response = await fetch(url);
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            const agenda = await response.json();
            renderizarGrade(agenda);
            atualizarStats(agenda);
        } catch (error) {
            console.log('Usando dados de teste:', error.message);
            renderizarGrade(MOCK_AGENDA);
            atualizarStats(MOCK_AGENDA);
        }
    }

    function renderizarGrade(reservas) {
        const grid = document.getElementById('agendaGrid');
        grid.innerHTML = `<div class="cell head">Horário</div><div class="cell head">Futsal Arena</div><div class="cell head">Society Premium</div><div class="cell head">Society Descoberta</div>`;
        const horarios = ['09:00','10:00','11:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00'];
        const quadras = [1,2,3];
        horarios.forEach(hora => {
            grid.innerHTML += `<div class="cell hour">${hora}</div>`;
            quadras.forEach(qid => {
                const r = reservas.find(x => x.quadra?.id === qid && x.hora_inicio?.startsWith(hora));
                if (r) {
                    const cls = {'confirmada':'confirmed','pendente':'pending','agendada':'pending','cancelada':'cancelled','concluida':'confirmed'}[r.status] || 'busy';
                    const pag = r.pagamento?.status === 'pago' ? `Pago (${r.pagamento.metodo})` : `${r.pagamento?.metodo || '-'} pendente`;
                    const nome = r.usuario?.nome_completo || r.usuario?.nome || r.cliente_nome || 'Cliente';
                    grid.innerHTML += `<div class="cell"><div class="booking ${cls}" onclick="abrirDetalhes(${r.id})"><strong>${nome}</strong><br><small>${pag}</small></div></div>`;
                } else { grid.innerHTML += `<div class="cell busy">Livre</div>`; }
            });
        });
    }

    function atualizarStats(reservas) {
        const hoje = new Date().toISOString().split('T')[0];
        const hojeRes = reservas.filter(r => r.data === hoje);
        document.getElementById('countReservas').textContent = hojeRes.length;
        document.getElementById('countPendentes').textContent = hojeRes.filter(r => r.pagamento?.status === 'pendente').length;
        const prox = hojeRes.filter(r => r.status !== 'cancelada').sort((a,b) => a.hora_inicio.localeCompare(b.hora_inicio))[0];
        document.getElementById('proximaReserva').textContent = prox ? prox.hora_inicio : '-';
        const alertas = document.getElementById('alertasDia');
        const pend = hojeRes.filter(r => r.pagamento?.status === 'pendente');
        alertas.innerHTML = pend.length > 0 ? `<div class="list-group-item px-0"><i class="bi bi-exclamation-triangle text-warning me-2"></i>${pend.length} pagamento${pend.length>1?'s':''} pendente${pend.length>1?'s':''}.</div>` : '<div class="list-group-item px-0 text-muted"><i class="bi bi-check-circle me-2"></i>Tudo em ordem!</div>';
    }

    async function abrirDetalhes(id) {
        try {
            const r = await (await fetch(`${API_BASE}/reservas/${id}`)).json();
            const c = document.getElementById('modalDetalhesContent');
            const nome = r.usuario?.nome_completo || r.usuario?.nome || r.cliente_nome || 'Cliente';
            c.innerHTML = `<p><strong>Cliente:</strong> ${nome}</p><p><strong>Quadra:</strong> ${r.quadra?.nome||'-'}</p><p><strong>Data/Hora:</strong> ${r.data} ${r.hora_inicio}-${r.hora_fim}</p><p><strong>Status:</strong> ${r.status}</p><p><strong>Pagamento:</strong> ${r.pagamento?.status==='pago'?'Pago':'Pendente'}</p>`;
            const btnPag = document.getElementById('btnConfirmarPagamentoModal');
            if (r.pagamento?.status === 'pago') { btnPag.disabled=true; btnPag.innerHTML='<i class="bi bi-check2-circle me-1"></i>Pago'; }
            else { btnPag.disabled=false; btnPag.innerHTML='<i class="bi bi-check-circle me-1"></i>Confirmar pagamento'; btnPag.onclick=()=>confirmarPagamento(r.pagamento?.id||r.id); }
            const btnCan = document.getElementById('btnCancelarReservaModal');
            if (r.status==='cancelada') { btnCan.disabled=true; btnCan.innerHTML='<i class="bi bi-x-circle me-1"></i>Cancelada'; }
            else { btnCan.disabled=false; btnCan.innerHTML='<i class="bi bi-x-circle me-1"></i>Cancelar'; btnCan.onclick=()=>cancelarReserva(r.id); }
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetalhes')).show();
        } catch(e) { esportecToast('Erro ao carregar detalhes.', 'error'); }
    }

    async function confirmarPagamento(id) {
        if (!confirm('Confirmar pagamento?')) return;
        try {
            await fetch(`${API_BASE}/funcionario/pagamentos/${id}/confirmar`, { method:'PATCH', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content} });
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
            esportecToast('Pagamento confirmado!', 'success');
            carregarAgenda();
        } catch(e) { esportecToast('Erro ao confirmar.', 'error'); }
    }

    async function cancelarReserva(id) {
        if (!confirm('Cancelar reserva?')) return;
        try {
            await fetch(`${API_BASE}/agendamentos/${id}/cancelar`, { method:'PATCH', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content} });
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
            esportecToast('Reserva cancelada.', 'success');
            carregarAgenda();
        } catch(e) { esportecToast('Erro ao cancelar.', 'error'); }
    }

    document.getElementById('btnCriarReservaManual').addEventListener('click', async () => {
        const nome = document.getElementById('reservaManualCliente').value.trim();
        const quadra = document.getElementById('reservaManualQuadra').value;
        const data = document.getElementById('reservaManualData').value;
        const hora = document.getElementById('reservaManualHora').value;
        if (!nome || !quadra || !data || !hora) { esportecToast('Preencha todos os campos.', 'warning'); return; }
        try {
            await fetch(`${API_BASE}/reservas`, {
                method: 'POST',
                headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content },
                body: JSON.stringify({ cliente_nome: nome, quadra_id: quadra, data, hora_inicio: hora, hora_fim: '21:00', valor_total: 100, observacao: 'Reserva manual' })
            });
            bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
            esportecToast('Reserva criada!', 'success');
            setTimeout(() => { carregarAgenda(); document.getElementById('reservaManualCliente').value=''; document.getElementById('reservaManualQuadra').value=''; }, 500);
        } catch(e) { esportecToast('Erro ao criar reserva.', 'error'); }
    });

    document.getElementById('btnDia').onclick = () => { currentView='dia'; document.getElementById('btnDia').className='btn btn-success active'; document.getElementById('btnSemana').className='btn btn-outline-success'; document.getElementById('agendaTitulo').textContent='Grade por quadra - visão do dia'; carregarAgenda(); };
    document.getElementById('btnSemana').onclick = () => { currentView='semana'; document.getElementById('btnSemana').className='btn btn-success active'; document.getElementById('btnDia').className='btn btn-outline-success'; document.getElementById('agendaTitulo').textContent='Grade por quadra - visão semanal'; carregarAgenda(); };
    document.addEventListener('DOMContentLoaded', () => { document.getElementById('dataSelecionada').value = HOJE; carregarAgenda(); });
</script>
</body>
</html>