<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quadra Society Premium - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; --bg: #F8FAFC; --gray: #64748B; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .container-detalhes { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
        .btn-back { width: 40px; height: 40px; border-radius: 10px; background: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-decoration: none; color: inherit; }
        .btn-back:hover { background: var(--light); }

        /* Galeria */
        .carousel-img { height: 400px; object-fit: cover; border-radius: 16px; }
        @media(max-width:768px) { .carousel-img { height: 250px; } }

        /* Info */
        .quadra-title { font-size: 2rem; font-weight: 700; margin: 1.5rem 0 0.5rem; }
        .rating { color: #FFC107; font-weight: 600; margin-bottom: 1rem; }
        .badges { display: flex; gap: 0.8rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
        .badge-info { background: var(--light); color: var(--primary); padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.85rem; font-weight: 500; }
        .description { color: var(--gray); line-height: 1.7; margin-bottom: 2rem; }

        /* Grade de Horários */
        .schedule-section { background: white; border-radius: 16px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); }
        .time-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(85px, 1fr)); gap: 0.8rem; margin-top: 1rem; }
        .time-slot { padding: 0.8rem; border-radius: 8px; text-align: center; font-weight: 500; cursor: pointer; border: 2px solid transparent; transition: all 0.2s; }
        .time-available { background: var(--light); color: var(--primary); }
        .time-available:hover { background: var(--primary); color: white; }
        .time-selected { background: var(--primary); color: white; border-color: var(--dark); transform: scale(1.05); }
        .time-busy { background: #F1F5F9; color: #94A3B8; cursor: not-allowed; }

        /* Preço e CTA */
        .price-box { background: var(--light); padding: 1.5rem; border-radius: 12px; text-align: center; margin-bottom: 2rem; }
        .price-value { font-size: 2rem; font-weight: 700; color: var(--primary); }
        .btn-reserve { background: var(--primary); color: white; border: none; padding: 1rem 2rem; border-radius: 12px; font-weight: 600; font-size: 1.1rem; width: 100%; cursor: pointer; transition: all 0.2s; }
        .btn-reserve:hover { background: var(--dark); transform: translateY(-2px); box-shadow: 0 6px 15px rgba(45,129,93,0.3); }

        /* Avaliações */
        .review-card { background: white; border-radius: 12px; padding: 1.2rem; margin-bottom: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .review-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
        .review-user { font-weight: 600; }
        .review-date { font-size: 0.8rem; color: var(--gray); }
        .review-text { color: var(--gray); line-height: 1.5; }
        .stars { color: #FFC107; }
    </style>
</head>
<body>

<div class="container-detalhes">
    <a href="/" class="btn-back"><i class="bi bi-arrow-left"></i></a>

    <!-- Galeria de Fotos -->
    <div id="quadraCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#quadraCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#quadraCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#quadraCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1200&q=80" class="d-block w-100 carousel-img" alt="Quadra 1">
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?auto=format&fit=crop&w=1200&q=80" class="d-block w-100 carousel-img" alt="Quadra 2">
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1529926706528-db9e5010cd3e?auto=format&fit=crop&w=1200&q=80" class="d-block w-100 carousel-img" alt="Quadra 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#quadraCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#quadraCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Informações -->
    <h1 class="quadra-title">Quadra Society Premium</h1>
    <div class="rating">
        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
        <span>4.8 (124 avaliações)</span>
    </div>
    <div class="badges">
        <span class="badge-info">⚽ Society</span>
        <span class="badge-info">👥 14 jogadores</span>
        <span class="badge-info">️ Aberta</span>
        <span class="badge-info">💡 Iluminação LED</span>
    </div>
    <p class="description">
        Quadra society com grama sintética de última geração, marcações oficiais e iluminação LED de alta performance.
        Ideal para campeonatos, treinos intensos e partidas entre amigos. Dispõe de vestiários, bebedouro e estacionamento gratuito.
    </p>

    <!-- Agenda -->
    <div class="schedule-section">
        <h4 class="fw-bold mb-3">📅 Disponibilidade para Hoje</h4>
        <div class="time-grid" id="grade-horarios">
            <!-- Gerado via JS -->
        </div>
    </div>

    <!-- Preço e Reserva -->
    <div class="price-box">
        <p class="mb-1 text-muted">Valor por hora</p>
        <div class="price-value">R$ 150,00</div>
        <small class="text-muted">Pagamento via PIX ou Cartão</small>
    </div>
    <a href="/nova-reserva" class="btn btn-success w-100 py-3 mt-3">
    Reservar esta Quadra
</a>

    <!-- Avaliações -->
    <h4 class="fw-bold mt-5 mb-3">⭐ Avaliações dos Jogadores</h4>
    <div class="review-card">
        <div class="review-header">
            <span class="review-user">Carlos M.</span>
            <span class="review-date">10/06/2026</span>
        </div>
        <div class="stars mb-2">★★★★★</div>
        <p class="review-text">Gramado impecável e iluminação excelente para jogos noturnos. Recomendo demais!</p>
    </div>
    <div class="review-card">
        <div class="review-header">
            <span class="review-user">Ana P.</span>
            <span class="review-date">08/06/2026</span>
        </div>
        <div class="stars mb-2">★★★★☆</div>
        <p class="review-text">Ótima quadra, mas o bebedouro estava sem água no último jogo. Tirando isso, top!</p>
    </div>
    <div class="review-card">
        <div class="review-header">
            <span class="review-user">Grupo F.C. Unidos</span>
            <span class="review-date">02/06/2026</span>
        </div>
        <div class="stars mb-2">★★★★★</div>
        <p class="review-text">Jogamos nosso campeonato aqui. Espaço amplo, vestiários limpos e staff muito atencioso.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    // Gerar grade de horários
    const grid = document.getElementById('grade-horarios');
    const hours = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00'];

    hours.forEach(hour => {
        const slot = document.createElement('div');
        slot.className = 'time-slot time-available';
        slot.textContent = hour;

        // Simular ocupados aleatoriamente
        if (Math.random() > 0.75) {
            slot.className = 'time-slot time-busy';
            slot.title = 'Indisponível';
        } else {
            slot.onclick = function() {
                document.querySelectorAll('.time-selected').forEach(s => {
                    s.classList.remove('time-selected');
                    s.classList.add('time-available');
                });
                this.classList.remove('time-available');
                this.classList.add('time-selected');
            };
        }
        grid.appendChild(slot);
    });
</script>
</body>
</html>
