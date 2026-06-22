<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partida - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --light:#E8F5EE; --bg:#F8FAFC; }
        body { font-family:'Poppins',sans-serif; background:var(--bg); color:#334155; min-height:100vh; }
        .hero { background:linear-gradient(135deg,rgba(45,129,93,.94),rgba(31,92,66,.94)),url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1600&q=80') center/cover; color:white; padding:3.5rem 1rem; }
        .page { max-width:850px; margin:-2rem auto 2rem; padding:0 1rem; }
        .card-soft { background:white; border:0; border-radius:12px; box-shadow:0 8px 24px rgba(15,23,42,.10); }
        .player { display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid #EEF2F7; padding:1rem 0; }
        .player:last-child { border-bottom:0; }
        .avatar { width:40px; height:40px; border-radius:50%; background:var(--light); color:var(--primary); display:flex; align-items:center; justify-content:center; font-weight:700; }
        .btn-success { background:var(--primary); border-color:var(--primary); }
    </style>
</head>
<body>
    <section class="hero text-center">
        <h1 class="fw-bold">Partida Society Premium</h1>
        <p class="mb-0">Hoje, 19:00 • Quadra Society Premium • Link público</p>
    </section>

    <main class="page">
        <section class="card-soft p-4 mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <h5 class="fw-bold mb-1">Confirmados</h5>
                    <p class="text-muted mb-0">O jogador entra sem login e informa apenas o nome.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-success fs-6" id="playerCounter">8/14 jogadores</span>
                </div>
            </div>
        </section>

        <section class="card-soft p-4 mb-4">
            <form id="joinForm" class="row g-2">
                <div class="col-md-9"><input id="playerName" class="form-control form-control-lg" placeholder="Digite seu nome"></div>
                <div class="col-md-3"><button class="btn btn-success btn-lg w-100" type="submit">Confirmar</button></div>
            </form>
        </section>

        <section class="card-soft p-4">
            <h5 class="fw-bold mb-3">Lista de jogadores</h5>
            <div id="players">
                <div class="player"><div class="d-flex align-items-center gap-3"><div class="avatar">JS</div><strong>João Silva</strong></div><span class="badge bg-success">Confirmado</span></div>
                <div class="player"><div class="d-flex align-items-center gap-3"><div class="avatar">PM</div><strong>Pedro Martins</strong></div><span class="badge bg-success">Confirmado</span></div>
                <div class="player"><div class="d-flex align-items-center gap-3"><div class="avatar">AL</div><strong>Ana Lima</strong></div><span class="badge bg-success">Confirmado</span></div>
            </div>
        </section>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    let confirmedPlayers = 8;

    document.getElementById('joinForm').addEventListener('submit', event => {
        event.preventDefault();
        const input = document.getElementById('playerName');
        const name = input.value.trim();
        if (!name) return;
        if (confirmedPlayers >= 14) {
            esportecToast('A partida já atingiu o limite de jogadores.', 'warning');
            return;
        }
        const initials = name.split(' ').slice(0, 2).map(part => part[0]).join('').toUpperCase();
        const item = document.createElement('div');
        item.className = 'player';
        item.innerHTML = `<div class="d-flex align-items-center gap-3"><div class="avatar">${initials}</div><strong>${name}</strong></div><span class="badge bg-success">Confirmado</span>`;
        document.getElementById('players').appendChild(item);
        confirmedPlayers++;
        document.getElementById('playerCounter').textContent = `${confirmedPlayers}/14 jogadores`;
        input.value = '';
        esportecToast(`${name} confirmado na partida.`, 'success');
    });
</script>
</body>
</html>
