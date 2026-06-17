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
        .badge-cancelada { background: rgba(211,47,47,0.15); color: #D32F2F; }
        .badge-concluida { background: rgba(21,101,192,0.15); color: #1565C0; }
        
        .reserva-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .btn-action { padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.4rem; text-decoration: none; }
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

    <!-- Conteúdo: Próximas -->
    <div id="proximas" class="tab-content active">
        <div class="reserva-card">
            <div class="reserva-info">
                <div class="reserva-title">Quadra Society Premium</div>
                <div class="reserva-meta">
                    <span><i class="bi bi-calendar3"></i> 14/06/2026</span>
                    <span><i class="bi bi-clock"></i> 19:00 - 20:30</span>
                    <span><i class="bi bi-cash-stack"></i> R$ 225,00</span>
                </div>
                <span class="badge-status badge-pendente">Pendente</span>
            </div>
            <div class="reserva-actions">
                <button class="btn-action btn-primary" data-bs-toggle="modal" data-bs-target="#modalDetalhes"><i class="bi bi-eye"></i> Detalhes</button>
                <a href="#" class="btn-action btn-outline" onclick="compartilhar('Society Premium - 14/06 19:00')"><i class="bi bi-whatsapp"></i> Compartilhar</a>
                <button class="btn-action btn-danger" onclick="confirmarCancelamento()"><i class="bi bi-x-circle"></i> Cancelar</button>
            </div>
        </div>

        <div class="reserva-card">
            <div class="reserva-info">
                <div class="reserva-title">Quadra Futsal Arena</div>
                <div class="reserva-meta">
                    <span><i class="bi bi-calendar3"></i> 16/06/2026</span>
                    <span><i class="bi bi-clock"></i> 16:00 - 17:00</span>
                    <span><i class="bi bi-cash-stack"></i> R$ 120,00</span>
                </div>
                <span class="badge-status badge-confirmada">Confirmada</span>
            </div>
            <div class="reserva-actions">
                <button class="btn-action btn-primary" data-bs-toggle="modal" data-bs-target="#modalDetalhes"><i class="bi bi-eye"></i> Detalhes</button>
                <a href="#" class="btn-action btn-outline" onclick="compartilhar('Futsal Arena - 16/06 16:00')"><i class="bi bi-whatsapp"></i> Compartilhar</a>
            </div>
        </div>
    </div>

    <!-- Conteúdo: Passadas -->
    <div id="passadas" class="tab-content">
        <div class="reserva-card">
            <div class="reserva-info">
                <div class="reserva-title">Beach Tennis #2</div>
                <div class="reserva-meta">
                    <span><i class="bi bi-calendar3"></i> 10/06/2026</span>
                    <span><i class="bi bi-clock"></i> 10:00 - 11:00</span>
                    <span><i class="bi bi-cash-stack"></i> R$ 100,00</span>
                </div>
                <span class="badge-status badge-concluida">Concluída</span>
            </div>
            <div class="reserva-actions">
                <button class="btn-action btn-primary" data-bs-toggle="modal" data-bs-target="#modalDetalhes"><i class="bi bi-eye"></i> Detalhes</button>
                <button class="btn-action btn-outline" data-bs-toggle="modal" data-bs-target="#modalAvaliacao"><i class="bi bi-star"></i> Avaliar</button>
            </div>
        </div>
    </div>

    <!-- Conteúdo: Canceladas -->
    <div id="canceladas" class="tab-content">
        <div class="reserva-card">
            <div class="reserva-info">
                <div class="reserva-title">Quadra Society Premium</div>
                <div class="reserva-meta">
                    <span><i class="bi bi-calendar3"></i> 05/06/2026</span>
                    <span><i class="bi bi-clock"></i> 20:00 - 21:30</span>
                    <span><i class="bi bi-cash-stack"></i> R$ 225,00</span>
                </div>
                <span class="badge-status badge-cancelada">Cancelada</span>
            </div>
            <div class="reserva-actions">
                <button class="btn-action btn-primary" data-bs-toggle="modal" data-bs-target="#modalDetalhes"><i class="bi bi-eye"></i> Detalhes</button>
                <a href="#" class="btn-action btn-outline" onclick="alert('Reagendamento não disponível para reservas canceladas. Faça uma nova reserva.')"><i class="bi bi-arrow-repeat"></i> Reagendar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalhes da Reserva -->
<div class="modal fade" id="modalDetalhes" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">📋 Detalhes da Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Quadra</small>
                            <strong class="fs-5">Society Premium</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Data</small>
                            <strong class="fs-5">14/06/2026</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Horário</small>
                            <strong class="fs-5">19:00 - 20:30</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Valor Total</small>
                            <strong class="fs-5 text-success">R$ 225,00</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge bg-success bg-opacity-10 text-success fs-6">Confirmada</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Forma de Pagamento</small>
                            <strong><i class="bi bi-qr-code me-2"></i>PIX</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Observações</small>
                            <p class="mb-0 mt-1">Reserva para campeonato interno. Precisamos de 2 bolas extras.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 p-3 border rounded">
                    <strong class="d-block mb-2">📍 Localização:</strong>
                    <p class="mb-1">Rua dos Esportes, 123 - São Paulo, SP</p>
                    <small class="text-muted">Chegar com 10 minutos de antecedência</small>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" onclick="alert('Cancelar reserva')">
                    <i class="bi bi-x-circle me-2"></i>Cancelar Reserva
                </button>
                <button type="button" class="btn btn-success" onclick="alert('Compartilhar no WhatsApp')">
                    <i class="bi bi-whatsapp me-2"></i>Compartilhar
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
                <h5 class="modal-title fw-bold">⭐ Avaliar Partida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p class="text-muted mb-3">Como foi sua experiência na <strong>Society Premium</strong>?</p>
                
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
                    <textarea class="form-control" rows="3" placeholder="Conte-nos como foi sua experiência..."></textarea>
                </div>
                
                <div class="form-check text-start mb-3">
                    <input type="checkbox" class="form-check-input" id="recomendar">
                    <label class="form-check-label" for="recomendar">Recomendaria para outros jogadores</label>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function switchTab(tabId, btn) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        btn.classList.add('active');
    }

    function compartilhar(texto) {
        const msg = encodeURIComponent(`Olá! Bora jogar no EsporTec?\n🏟️ ${texto}\n📲 Reserve aqui: http://127.0.0.1:8000`);
        window.open(`https://wa.me/?text=${msg}`, '_blank');
    }

    function confirmarCancelamento() {
        if(confirm('Tem certeza que deseja cancelar esta reserva? O valor será estornado conforme a política.')) {
            alert('✅ Reserva cancelada com sucesso.');
        }
    }

    // Funções do Modal de Avaliação
    function setRating(n) {
        document.getElementById('rating').value = n;
        const stars = document.querySelectorAll('#stars i');
        stars.forEach((star, index) => {
            if (index < n) {
                star.classList.remove('bi-star');
                star.classList.add('bi-star-fill');
            } else {
                star.classList.remove('bi-star-fill');
                star.classList.add('bi-star');
            }
        });
    }

    function submitAvaliacao() {
        const rating = document.getElementById('rating').value;
        if (rating == 0) {
            alert('Por favor, selecione uma nota de 1 a 5 estrelas');
            return;
        }
        alert('✅ Avaliação enviada com sucesso! Obrigado pelo feedback.');
        bootstrap.Modal.getInstance(document.getElementById('modalAvaliacao')).hide();
    }
</script>
</body>
</html>