<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lista da partida - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#2D815D; --dark:#1F5C42; --light:#E8F5EE; --bg:#F8FAFC; }
        body { font-family:'Poppins',sans-serif; background:var(--bg); color:#334155; min-height:100vh; }
        .hero { background:linear-gradient(135deg,var(--primary),var(--dark)); color:white; padding:3rem 1rem 4rem; }
        .page { max-width:900px; margin:-2rem auto 2rem; padding:0 1rem; }
        .card-soft { background:white; border:0; border-radius:16px; box-shadow:0 8px 24px rgba(15,23,42,.10); }
        .player { display:flex; align-items:center; justify-content:space-between; gap:1rem; border-bottom:1px solid #EEF2F7; padding:1rem 0; }
        .player:last-child { border-bottom:0; }
        .avatar { width:42px; height:42px; border-radius:50%; background:var(--light); color:var(--primary); display:flex; align-items:center; justify-content:center; font-weight:700; flex-shrink:0; }
        .btn-success { background:var(--primary); border-color:var(--primary); }
        .waiting { background:#FFF7E6; border-radius:12px; padding:0 1rem; }
        [data-owner-control] { display:none; }
    </style>
</head>
<body data-responsavel-id="{{ $partida->reserva->reservas_usuarios_id }}" data-partida-id="{{ $partida->id }}">
@php
    $confirmados = $partida->jogadores->where('status', 'confirmado')->values();
    $espera = $partida->jogadores->where('status', 'pendente')->values();
    $aceitaInscricoes = $partida->ativo && $partida->reserva->status === 'confirmada' && !$partida->reserva->data->isBefore(now()->startOfDay());
@endphp
    <section class="hero text-center">
        <h1 class="fw-bold">{{ $partida->reserva->quadra->nome }}</h1>
        <p class="mb-1">{{ $partida->reserva->quadra->arena->nome }}</p>
        <p class="mb-0"><i class="bi bi-calendar3 me-1"></i>{{ $partida->reserva->data->format('d/m/Y') }} · {{ substr($partida->reserva->hora_inicio, 0, 5) }} às {{ substr($partida->reserva->hora_fim, 0, 5) }}</p>
    </section>

    <main class="page">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

        <section class="card-soft p-4 mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-7">
                    <h5 class="fw-bold mb-1">Lista de participantes</h5>
                    <p class="text-muted mb-0">Não é necessário criar uma conta. Informe apenas seu nome.</p>
                </div>
                <div class="col-md-5 text-md-end">
                    <span class="badge bg-success fs-6">{{ $confirmados->count() }}/{{ $partida->max_jogador }} confirmados</span>
                    @if($espera->isNotEmpty())<span class="badge bg-warning text-dark fs-6">{{ $espera->count() }} na espera</span>@endif
                </div>
            </div>
            <div class="d-flex gap-2 mt-3 flex-wrap">
                <button class="btn btn-outline-success" id="btnCopiarLink" type="button"><i class="bi bi-share me-1"></i>Copiar link</button>
                <span class="text-muted small align-self-center" data-owner-control>Você é o responsável e pode retirar participantes.</span>
            </div>
        </section>

        @if($aceitaInscricoes)
            <section class="card-soft p-4 mb-4">
                <form action="{{ route('partida.entrar', $partida->link_partida) }}" method="POST" class="row g-2">
                    @csrf
                    <div class="col-md-9"><input name="nome_jogador" class="form-control form-control-lg" maxlength="100" placeholder="Digite seu nome" value="{{ old('nome_jogador') }}" required></div>
                    <div class="col-md-3"><button class="btn btn-success btn-lg w-100" type="submit">Participar</button></div>
                </form>
                @if($confirmados->count() >= $partida->max_jogador)<p class="text-warning mt-3 mb-0"><i class="bi bi-hourglass-split me-1"></i>As vagas estão preenchidas. Novos nomes entrarão na fila de espera.</p>@endif
            </section>
        @else
            <div class="alert alert-secondary">Esta partida não está aceitando novos participantes.</div>
        @endif

        <section class="card-soft p-4 mb-4">
            <h5 class="fw-bold mb-3">Confirmados</h5>
            <div>
                @forelse($confirmados as $jogador)
                    <div class="player">
                        <div class="d-flex align-items-center gap-3"><div class="avatar">{{ mb_strtoupper(mb_substr($jogador->nome_jogador, 0, 2)) }}</div><strong>{{ $jogador->nome_jogador }}</strong></div>
                        <div class="d-flex align-items-center gap-2"><span class="badge bg-success">Confirmado</span><button class="btn btn-sm btn-outline-danger" type="button" data-owner-control data-remover-jogador="{{ $jogador->id }}">Retirar</button></div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Nenhum participante confirmado ainda.</p>
                @endforelse
            </div>
        </section>

        @if($espera->isNotEmpty())
            <section class="card-soft p-4">
                <h5 class="fw-bold mb-1">Fila de espera</h5>
                <p class="text-muted">Quando uma vaga for liberada, o primeiro nome será confirmado automaticamente.</p>
                <div class="waiting">
                    @foreach($espera as $indice => $jogador)
                        <div class="player">
                            <div class="d-flex align-items-center gap-3"><div class="avatar">{{ $indice + 1 }}º</div><strong>{{ $jogador->nome_jogador }}</strong></div>
                            <div class="d-flex align-items-center gap-2"><span class="badge bg-warning text-dark">Em espera</span><button class="btn btn-sm btn-outline-danger" type="button" data-owner-control data-remover-jogador="{{ $jogador->id }}">Retirar</button></div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script src="/js/esportec-api.js"></script>
<script>
    document.getElementById('btnCopiarLink').addEventListener('click', async () => {
        try { await navigator.clipboard.writeText(window.location.href); esportecToast('Link copiado.', 'success'); }
        catch { window.prompt('Copie o link da partida:', window.location.href); }
    });

    async function identificarResponsavel() {
        if (!EsporTecApi.token()) return;
        try {
            const dados = await EsporTecApi.request('/api/auth/me');
            if (Number(dados.usuario.id) === Number(document.body.dataset.responsavelId)) document.querySelectorAll('[data-owner-control]').forEach(elemento => { elemento.style.display = ''; });
        } catch {}
    }

    document.addEventListener('click', async evento => {
        const botao = evento.target.closest('[data-remover-jogador]');
        if (!botao || !confirm('Retirar este nome da partida?')) return;
        try {
            const partida = document.body.dataset.partidaId;
            const resposta = await EsporTecApi.request(`/api/cliente/partidas/${partida}/jogadores/${botao.dataset.removerJogador}`, { method: 'DELETE' });
            esportecToast(resposta.message, 'success');
            setTimeout(() => window.location.reload(), 500);
        } catch (erro) { esportecToast(erro.message, 'warning'); }
    });
    identificarResponsavel();
</script>
</body>
</html>
