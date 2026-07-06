<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .booking { border-radius:10px; padding:.65rem; font-size:.85rem; cursor:pointer; }
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
                <input type="date" class="form-control" value="2026-06-21">
                <div class="btn-group" role="group" aria-label="Tipo de visão">
                    <button class="btn btn-success active" id="btnDia">Dia</button>
                    <button class="btn btn-outline-success" id="btnSemana">Semana</button>
                </div>
            </div>
        </div>

        <section class="row g-3 mb-4">
            <div class="col-md-3"><div class="card-soft p-3"><span class="text-muted small">Reservas hoje</span><h3 class="fw-bold mb-0">12</h3></div></div>
            <div class="col-md-3"><div class="card-soft p-3"><span class="text-muted small">Pagamentos pendentes</span><h3 class="fw-bold mb-0 text-warning">4</h3></div></div>
            <div class="col-md-3"><div class="card-soft p-3"><span class="text-muted small">Aniversariantes</span><h3 class="fw-bold mb-0 text-success">2</h3></div></div>
            <div class="col-md-3"><div class="card-soft p-3"><span class="text-muted small">Próxima reserva</span><h3 class="fw-bold mb-0">19:00</h3></div></div>
        </section>

        <section class="card-soft p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0" id="agendaTitulo">Grade por quadra - visão do dia</h5>
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalReserva">Nova reserva manual</button>
            </div>
            <div class="table-responsive">
                <div class="agenda-grid" id="agendaGrid">
                    <div class="cell head">Horário</div>
                    <div class="cell head">Futsal Arena</div>
                    <div class="cell head">Society Premium</div>
                    <div class="cell head">Society Descoberta</div>

                    <div class="cell hour">09:00</div>
                    <div class="cell"><div class="booking confirmed" data-bs-toggle="modal" data-bs-target="#modalDetalhes"><strong>Pedro Santos</strong><br>Pago PIX</div></div>
                    <div class="cell busy">Livre</div>
                    <div class="cell busy">Livre</div>

                    <div class="cell hour">10:00</div>
                    <div class="cell busy">Livre</div>
                    <div class="cell"><div class="booking pending" data-bs-toggle="modal" data-bs-target="#modalDetalhes"><strong>Ana Lima</strong><br>Dinheiro pendente</div></div>
                    <div class="cell busy">Livre</div>

                    <div class="cell hour">14:00</div>
                    <div class="cell busy">Livre</div>
                    <div class="cell"><div class="booking confirmed" data-bs-toggle="modal" data-bs-target="#modalDetalhes"><strong>Grupo Unidos</strong><br>Confirmada</div></div>
                    <div class="cell busy">Manutenção</div>

                    <div class="cell hour">19:00</div>
                    <div class="cell busy">Livre</div>
                    <div class="cell"><div class="booking pending" data-bs-toggle="modal" data-bs-target="#modalDetalhes"><strong>João Silva</strong><br>PIX pendente</div></div>
                    <div class="cell busy">Livre</div>
                </div>
            </div>
        </section>

        <section class="card-soft p-4">
            <h5 class="fw-bold mb-3">Alertas do dia</h5>
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0"><i class="bi bi-gift text-success me-2"></i>Maria Oliveira faz aniversário hoje.</div>
                <div class="list-group-item px-0"><i class="bi bi-exclamation-triangle text-warning me-2"></i>4 pagamentos ainda precisam ser conferidos.</div>
                <div class="list-group-item px-0"><i class="bi bi-star text-primary me-2"></i>João Silva completou 10 visitas no mês.</div>
            </div>
        </section>
    </main>
</div>

<div class="modal fade" id="modalDetalhes" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">Detalhes da reserva</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <p><strong>Cliente:</strong> João Silva</p>
            <p><strong>Quadra:</strong> Society Premium</p>
            <p><strong>Data/Hora:</strong> 21/06/2026, 19:00 - 20:30</p>
            <p><strong>Pagamento:</strong> PIX pendente</p>
            <button class="btn btn-outline-success btn-sm" id="btnVerComprovante"><i class="bi bi-file-earmark-image me-1"></i>Ver comprovante</button>
        </div>
        <div class="modal-footer flex-wrap">
            <button class="btn btn-success" data-staff-detail-action="pagamento">Confirmar pagamento</button>
            <button class="btn btn-outline-primary" data-staff-detail-action="horario">Alterar horário</button>
            <button class="btn btn-outline-danger" data-staff-detail-action="cancelar">Cancelar</button>
        </div>
    </div></div>
</div>

<div class="modal fade" id="modalReserva" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">Nova reserva manual</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <input class="form-control mb-3" placeholder="Nome do cliente">
            <select class="form-select mb-3"><option>Society Premium</option><option>Futsal Arena</option></select>
            <div class="row g-3"><div class="col-6"><input type="date" class="form-control"></div><div class="col-6"><input type="time" class="form-control"></div></div>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-success" id="btnCriarReservaManual">Criar</button></div>
    </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    const btnDia = document.getElementById('btnDia');
    const btnSemana = document.getElementById('btnSemana');
    const agendaTitulo = document.getElementById('agendaTitulo');
    let selectedBooking = null;

    document.querySelectorAll('.booking').forEach(booking => {
        booking.addEventListener('click', () => {
            selectedBooking = booking;
        });
    });

    btnDia.addEventListener('click', () => {
        btnDia.className = 'btn btn-success active';
        btnSemana.className = 'btn btn-outline-success';
        agendaTitulo.textContent = 'Grade por quadra - visão do dia';
    });
    btnSemana.addEventListener('click', () => {
        btnSemana.className = 'btn btn-success active';
        btnDia.className = 'btn btn-outline-success';
        agendaTitulo.textContent = 'Grade por quadra - visão semanal';
        esportecToast('Visão semanal selecionada.', 'info');
    });

    document.getElementById('btnVerComprovante').addEventListener('click', () => {
        esportecToast('Comprovante exibido na área de detalhes da reserva.', 'info');
    });

    document.querySelectorAll('[data-staff-detail-action]').forEach(button => {
        button.addEventListener('click', () => {
            if (!selectedBooking) {
                selectedBooking = document.querySelector('.booking.pending');
            }

            const action = button.dataset.staffDetailAction;
            if (action === 'pagamento') {
                selectedBooking.classList.remove('pending');
                selectedBooking.classList.add('confirmed');
                selectedBooking.innerHTML = '<strong>João Silva</strong><br>Pagamento confirmado';
                esportecToast('Pagamento confirmado.', 'success');
            }
            if (action === 'horario') {
                esportecToast('Horário liberado para alteração. Escolha outro horário na grade.', 'info');
            }
            if (action === 'cancelar' && confirm('Cancelar esta reserva?')) {
                selectedBooking.className = 'booking cancelled';
                selectedBooking.innerHTML = '<strong>Reserva cancelada</strong><br>Horário liberado';
                bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
                esportecToast('Reserva cancelada.', 'success');
            }
        });
    });

    document.getElementById('btnCriarReservaManual').addEventListener('click', () => {
        bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
        esportecToast('Reserva manual criada na agenda.', 'success');
    });
</script>
</body>
</html>
