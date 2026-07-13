<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EsporTec - Gestão Inteligente de Espaços Esportivos</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #2D815D;
            --dark-green: #1F5C42;
            --light-green: #E8F5EE;
            --text-dark: #2C3E50;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-green) !important;
        }

        .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--primary-green);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background: var(--primary-green);
            color: white;
        }

        .btn-primary-custom {
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-arena {
            background: #E8F5EE;
            color: #2D815D;
            border: 1px solid #2D815D;
            border-radius: 10px;
            font-weight: 600;
            padding: 0.6rem 1rem;
        }

        .btn-arena:hover {
                background: #2D815D;
                color: white;
        }

        .btn-primary-custom:hover {
            background: var(--dark-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 129, 93, 0.3);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(45, 129, 93, 0.85), rgba(31, 92, 66, 0.9)),
                        url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            padding: 120px 0 100px;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
        }

        .search-pill {
            background: white;
            border-radius: 50px;
            padding: 0.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            max-width: 700px;
            margin: 0 auto;
        }

        .search-pill input {
            border: none;
            padding: 1rem 1.5rem;
            flex: 1;
            border-radius: 50px;
            font-size: 1rem;
            outline: none;
        }

        .search-pill .btn {
            border-radius: 50px;
            padding: 1rem 2rem;
            margin: 0 0.3rem;
            font-weight: 600;
        }

        .btn-reserve {
            background: var(--primary-green);
            color: white;
            border: none;
        }

        .btn-reserve:hover {
            background: var(--dark-green);
        }

        .btn-register {
            background: var(--light-green);
            color: var(--primary-green);
            border: none;
        }

        .btn-register:hover {
            background: #d4edda;
        }

        /* Sections */
        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--text-dark);
        }

        .section-padding {
            padding: 80px 0;
        }

        /* Cards Quadras */
        .quadra-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 2rem;
        }

        .quadra-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .quadra-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .quadra-content {
            padding: 2rem;
        }

        .quadra-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .rating {
            color: #FFC107;
            margin-bottom: 1rem;
        }

        .quadra-info {
            margin: 0.5rem 0;
            color: #666;
        }

        .quadra-info strong {
            color: var(--text-dark);
        }

        .price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin: 1.5rem 0;
        }

        .btn-details {
            width: 100%;
            padding: 1rem;
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-details:hover {
            background: var(--dark-green);
        }

        /* Agenda Section */
        .agenda-section {
            background: var(--light-green);
            border-radius: 16px;
            padding: 3rem;
            margin: 4rem 0;
        }

        .form-select-custom {
            border-radius: 8px;
            border: 2px solid #ddd;
            padding: 0.8rem;
            font-size: 1rem;
        }

        .time-slots {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .time-slot {
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .time-available {
            background: var(--primary-green);
            color: white;
        }

        .time-available:hover {
            background: var(--dark-green);
            transform: scale(1.05);
        }

        .time-selected {
            background: var(--dark-green);
            color: white;
            box-shadow: 0 0 0 3px rgba(45,129,93,0.18);
        }

        .time-busy {
            background: #e0e0e0;
            color: #999;
            cursor: not-allowed;
        }

        /* Features */
        .feature-card {
            background: white;
            padding: 2.5rem 2rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--light-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: var(--primary-green);
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Info Section */
        .info-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .info-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .info-item i {
            color: var(--primary-green);
            margin-right: 1rem;
            font-size: 1.2rem;
            margin-top: 0.2rem;
        }

        /* Table */
        .table-custom {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .table-custom thead {
            background: var(--primary-green);
            color: white;
        }

        .table-custom th {
            font-weight: 600;
            padding: 1rem;
        }

        .table-custom td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Footer */
        footer {
            background: var(--dark-green);
            color: white;
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }

        .footer-brand {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            margin-right: 1.5rem;
            opacity: 0.9;
            transition: opacity 0.3s;
        }

        .footer-links a:hover {
            opacity: 1;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .search-pill {
                flex-direction: column;
                padding: 1rem;
            }

            .search-pill input {
                margin-bottom: 1rem;
            }

            .search-pill .btn {
                width: 100%;
                margin: 0.3rem 0;
            }

            .time-slots {
                grid-template-columns: repeat(2, 1fr);
            }

            .section-title {
                font-size: 1.8rem;
            }
        }
.btn-outline-primary,
.btn-primary-custom,
.btn-arena,
.btn-reserve,
.btn-register,
.btn-details {
    transition: all 0.25s ease;
}

.btn-outline-primary:hover,
.btn-primary-custom:hover,
.btn-arena:hover,
.btn-reserve:hover,
.btn-register:hover,
.btn-details:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 18px rgba(45, 129, 93, 0.25);
}

.section-subtitle {
    color: #64748B;
    font-size: 1.1rem;
    margin-top: -1rem;
}

.contact-card {
    background: white;
    border-radius: 18px;
    padding: 2rem;
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
}

.contact-card h3 {
    font-weight: 700;
    color: #24364B;
}

.contact-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    align-items: flex-start;
}

.contact-item i {
    color: #2D815D;
    font-size: 1.4rem;
    margin-top: 0.2rem;
}

.contact-item strong {
    color: #24364B;
    font-weight: 700;
}

.contact-item p {
    margin: 0.3rem 0 0;
    color: #334155;
}

.cta-card {
    background: linear-gradient(135deg, #2D815D, #1F5C42);
    color: white;
    border-radius: 18px;
    padding: 2.5rem;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
}

.cta-badge {
    background: rgba(255,255,255,0.18);
    padding: 0.4rem 1rem;
    border-radius: 30px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 1rem;
}

.cta-card h3 {
    font-weight: 700;
    font-size: 2rem;
    max-width: 650px;
}

.cta-card p {
    color: rgba(255,255,255,0.85);
    font-size: 1.05rem;
}

.cta-info {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.cta-info div {
    background: rgba(255,255,255,0.12);
    border-radius: 14px;
    padding: 1rem;
}

.cta-info strong {
    display: block;
    font-size: 1rem;
}

.cta-info span {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.8);
}

@media (max-width: 768px) {
    .cta-card {
        padding: 1.5rem;
    }

    .cta-card h3 {
        font-size: 1.5rem;
    }

    .cta-info {
        grid-template-columns: 1fr;
    }

}
    .faq-card {
    background: white;
    border-radius: 18px;
    padding: 2rem;
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
}

.faq-card h3 {
    font-weight: 700;
    color: #24364B;
}

.faq-accordion .accordion-item {
    border: none;
    border-radius: 14px !important;
    overflow: hidden;
    margin-bottom: 1rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}

.faq-accordion .accordion-button {
    background: #F8FAFC;
    color: #24364B;
    font-weight: 600;
    box-shadow: none;
    padding: 1rem 1.2rem;
}

.faq-accordion .accordion-button:not(.collapsed) {
    background: #E8F5EE;
    color: #2D815D;
}

.faq-accordion .accordion-body {
    color: #475569;
    line-height: 1.6;
    background: white;
}
.quadras-slider {
    max-width: 460px;
    margin: 0 auto;
}

.quadras-viewport {
    border-radius: 12px;
    overflow: hidden;
}

.quadras-track {
    display: flex;
    align-items: stretch;
    transition: transform 0.65s ease;
}

.quadras-item {
    flex: 0 0 100%;
    min-width: 100%;
}

.quadra-slide {
    height: 100%;
    padding: 0 0.25rem;
}

.quadras-slider .quadra-card {
    height: 100%;
    margin-bottom: 0;
}

#quadras {
    padding: 52px 0 38px;
}

#quadras .section-title {
    font-size: 2rem;
    margin-bottom: 1.4rem;
}

.quadras-slider .quadra-img {
    height: 185px;
}

.quadras-slider .quadra-content {
    padding: 1rem 1.15rem 1.15rem;
}

.quadras-slider .quadra-title {
    font-size: 1.2rem;
    margin-bottom: 0.3rem;
}

.quadras-slider .rating {
    font-size: 0.92rem;
    margin-bottom: 0.45rem;
}

.quadras-slider .quadra-info {
    font-size: 0.9rem;
    line-height: 1.35;
    margin: 0.25rem 0;
}

.quadras-slider .price {
    font-size: 1.42rem;
    margin: 0.7rem 0;
}

.quadras-slider .btn-details {
    padding: 0.72rem;
}

.quadras-indicators {
    position: static;
    display: flex;
    justify-content: center;
    gap: 0.55rem;
    margin: 0.75rem 0 0;
}

.quadras-indicators button {
    width: 11px;
    height: 11px;
    border-radius: 50%;
    background-color: var(--primary-green);
    opacity: 0.35;
    border: 0;
    padding: 0;
}

.quadras-indicators .active {
    opacity: 1;
}

.quadras-actions {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 0.75rem;
}

.quadras-nav-btn {
    min-width: 140px;
    padding: 0.55rem 0.9rem;
    border-radius: 10px;
    font-weight: 600;
}

@media (max-width: 768px) {
    .faq-card {
        padding: 1.5rem;
    }

    .quadras-slider {
        max-width: 100%;
        padding-left: 0.25rem;
        padding-right: 0.25rem;
    }

    #quadras {
        padding: 38px 0 30px;
    }

    #quadras .section-title {
        font-size: 1.7rem;
        margin-bottom: 1rem;
    }

    .quadras-slider .quadra-img {
        height: 155px;
    }

    .quadras-slider .quadra-content {
        padding: 0.85rem 0.95rem 1rem;
    }

    .quadras-slider .quadra-title {
        font-size: 1.05rem;
    }

    .quadras-slider .rating,
    .quadras-slider .quadra-info {
        font-size: 0.84rem;
    }

    .quadras-slider .price {
        font-size: 1.2rem;
        margin: 0.55rem 0;
    }

    .quadras-slider .btn-details {
        padding: 0.62rem;
    }

    .quadras-actions {
        align-items: stretch;
        flex-direction: column;
    }
}

    </style>
</head>
<body>
<!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">

        <a class="navbar-brand" href="/">
            EsporTec
        </a>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item">
                    <a class="nav-link active" href="/">
                        Início
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#quadras">
                        Quadras
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#sobre">
                        Sobre
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contato">
                        Contato
                    </a>
                </li>
            </ul>

            <div class="d-flex flex-column flex-lg-row gap-2 mt-3 mt-lg-0">
                <a href="/login" class="btn btn-outline-primary">
                    Entrar
                </a>

                <a href="/criar-conta" class="btn btn-primary-custom">
                    Criar Conta
                </a>
                        <a href="/cadastrar-arena" class="btn btn-arena">
                  Cadastrar Arena
                 </a>
                </div>

            </div>

        </div>

    </div>
</nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="hero-title">EsporTec</h1>
            <p class="hero-subtitle">Gestão inteligente de espaços esportivos</p>

            <div class="search-pill">
                <input type="text" id="buscarQuadra" placeholder="Buscar quadras...">
                <a href="/login?redirect=/nova-reserva" class="btn btn-reserve text-decoration-none">
    Reservar Quadra
</a>
    <a href="/cadastrar-arena" class="btn btn-register text-decoration-none">
    Cadastrar Arena
</a>
            </div>
        </div>
    </section>

    <!-- Nossas Quadras -->
    <section id="quadras" class="section-padding">
        <div class="container">
            <h2 class="section-title">Nossas Quadras</h2>

            <div id="quadrasSlider" class="quadras-slider">
                <div class="quadras-viewport">
                <div class="quadras-track" id="quadrasGrid">
                    <div class="quadras-item active">
                        <div class="quadra-slide">
                    <div class="quadra-card">
                        <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=800&q=80"
                             alt="Quadra Futsal Arena" class="quadra-img">
                        <div class="quadra-content">
                            <h3 class="quadra-title">Quadra Futsal Arena</h3>
                            <div class="rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.6 (89 avaliações)</span>
                            </div>
                            <p class="quadra-info">Quadra de futsal coberta com piso de madeira, ótima para competições e treinos.</p>
                            <p class="quadra-info"><strong>Tipo:</strong> Futsal</p>
                            <p class="quadra-info"><strong>Capacidade:</strong> 10 jogadores</p>
                            <p class="quadra-info"><strong>Coberta:</strong> Sim</p>
                            <div class="price">R$ 120/hora</div>
                            <div class="d-grid">
                                <a href="/detalhes-quadra" class="btn btn-details">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>

                    <div class="quadras-item">
                        <div class="quadra-slide">
                    <div class="quadra-card">
                        <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?auto=format&fit=crop&w=800&q=80"
                             alt="Quadra Society Premium" class="quadra-img">
                        <div class="quadra-content">
                            <h3 class="quadra-title">Quadra Society Premium</h3>
                            <div class="rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.8 (124 avaliações)</span>
                            </div>
                            <p class="quadra-info">Quadra society com grama sintética de última geração e iluminação LED.</p>
                            <p class="quadra-info"><strong>Tipo:</strong> Society</p>
                            <p class="quadra-info"><strong>Capacidade:</strong> 14 jogadores</p>
                            <p class="quadra-info"><strong>Coberta:</strong> Não</p>
                            <div class="price">R$ 150/hora</div>
                            <div class="d-grid">
                                <a href="/detalhes-quadra" class="btn btn-details">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>

                    <div class="quadras-item">
                        <div class="quadra-slide">
    <div class="quadra-card">
        <img src="https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=800&q=80"
             alt="Quadra Society Descoberta" class="quadra-img">

        <div class="quadra-content">
            <h3 class="quadra-title">Quadra Society Descoberta</h3>

            <div class="rating">
                <i class="bi bi-star-fill"></i>
                <span>4.5 (67 avaliações)</span>
            </div>

            <p class="quadra-info">
                Quadra society ao ar livre com grama sintética e iluminação noturna.
            </p>

            <p class="quadra-info">
                <strong>Tipo:</strong> Society
            </p>

            <p class="quadra-info">
                <strong>Capacidade:</strong> 14 jogadores
            </p>

            <p class="quadra-info">
                <strong>Coberta:</strong> Não
            </p>

            <div class="price">R$ 100/hora</div>

            <div class="d-grid">
                <a href="/detalhes-quadra" class="btn btn-details">
                    Ver Detalhes
                </a>
            </div>
        </div>
    </div>
</div>
                        </div>
                    </div>

            </div>
                </div>
                </div>
                <div class="quadras-indicators" id="quadrasIndicators">
                    <button type="button" class="active" data-quadras-dot="0" aria-current="true" aria-label="Quadra 1"></button>
                    <button type="button" data-quadras-dot="1" aria-label="Quadra 2"></button>
                    <button type="button" data-quadras-dot="2" aria-label="Quadra 3"></button>
                </div>
                <div class="quadras-actions">
                    <button class="btn btn-outline-primary quadras-nav-btn" type="button" data-quadras-prev>
                        <i class="bi bi-chevron-left me-1"></i>Anterior
                    </button>
                    <button class="btn btn-primary-custom quadras-nav-btn" type="button" data-quadras-next>
                        Próxima<i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <!-- Agenda de Disponibilidade -->
    <section class="container">
        <div class="agenda-section">
            <h2 class="section-title">Agenda de Disponibilidade</h2>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Selecione a Quadra</label>
                    <select class="form-select form-select-custom">
                        <option>Quadra Society Premium</option>
                        <option>Quadra Futsal Arena</option>
                        <option>Quadra Society Descoberta</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Selecione a Data</label>
                    <input type="date" class="form-control form-select-custom" value="2026-06-10">
                </div>
            </div>

            <div class="time-slots">
                <div class="time-slot time-available">07:00</div>
                <div class="time-slot time-available">08:00</div>
                <div class="time-slot time-busy">09:00</div>
                <div class="time-slot time-available">10:00</div>
                <div class="time-slot time-available">11:00</div>
                <div class="time-slot time-busy">12:00</div>
                <div class="time-slot time-busy">15:00</div>
                <div class="time-slot time-available">16:00</div>
                <div class="time-slot time-available">17:00</div>
                <div class="time-slot time-busy">18:00</div>
                <div class="time-slot time-available">19:00</div>
                <div class="time-slot time-available">20:00</div>
            </div>
        </div>
    </section>

    <!-- Tabela de valores e pagamentos -->
    <section class="section-padding">
        <div class="container">
            <h2 class="section-title">Tabela de Valores</h2>
            <div class="table-responsive table-custom mb-4">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Quadra</th>
                            <th>Tipo</th>
                            <th>Valor/hora</th>
                            <th>Coberta</th>
                            <th>Capacidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Quadra Futsal Arena</td><td>Futsal</td><td>R$ 120,00</td><td>Sim</td><td>10 jogadores</td></tr>
                        <tr><td>Quadra Society Premium</td><td>Society</td><td>R$ 150,00</td><td>Não</td><td>14 jogadores</td></tr>
                        <tr><td>Quadra Society Descoberta</td><td>Society</td><td>R$ 100,00</td><td>Não</td><td>14 jogadores</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="row g-3 text-center">
                <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="bi bi-qr-code"></i></div><h3 class="feature-title">PIX</h3><p>Confirmação rápida com QR Code.</p></div></div>
                <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="bi bi-cash-coin"></i></div><h3 class="feature-title">Dinheiro</h3><p>Pagamento presencial na arena.</p></div></div>
                <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="bi bi-credit-card"></i></div><h3 class="feature-title">Cartão</h3><p>Opção de pagamento no atendimento.</p></div></div>
            </div>
        </div>
    </section>

    <!-- Por que escolher a EsporTec? -->
    <section id="sobre" class="section-padding" style="background: #f8f9fa;">
        <div class="container">
            <h2 class="section-title">Por que escolher a EsporTec?</h2>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h3 class="feature-title">Agendamento Fácil</h3>
                        <p>Reserve sua quadra em poucos cliques, de forma rápida e segura.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-qr-code"></i>
                        </div>
                        <h3 class="feature-title">Pagamento PIX</h3>
                        <p>Pague de forma instantânea e segura através do PIX.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-star"></i>
                        </div>
                        <h3 class="feature-title">Avalie sua Experiência</h3>
                        <p>Compartilhe sua experiência e ajude outros jogadores.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Informações -->
    <!-- Contato e Ações -->
<section id="contato" class="section-padding contato-section">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">Fale com a EsporTec</h2>
            <p class="section-subtitle">
    Entre em contato com a nossa equipe e veja as principais dúvidas sobre reservas e cadastro de arenas.
</p>
 </div>

        <div class="row g-4 align-items-stretch">

            <div class="col-lg-5">
                <div class="contact-card h-100">
                    <h3 class="mb-4">Contato</h3>

                    <div class="contact-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>
                            <strong>Endereço</strong>
                            <p>Rua dos Esportes, 123 - São Paulo, SP</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="bi bi-telephone-fill"></i>
                        <div>
                            <strong>Telefone</strong>
                            <p>(11) 9999-9999</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="bi bi-envelope-fill"></i>
                        <div>
                            <strong>E-mail</strong>
                            <p>contato@esportec.com.br</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="bi bi-clock-fill"></i>
                        <div>
                            <strong>Funcionamento</strong>
                            <p>Segunda a Domingo | 07:00 - 23:00</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
    <div class="faq-card h-100">
        <h3 class="mb-4">Dúvidas Frequentes</h3>

        <div class="accordion faq-accordion" id="faqAccordion">

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
    Como faço para reservar uma quadra?
</button></h2>
                <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                        Basta acessar a opção <strong>Reservar Quadra</strong>, escolher a quadra, data, horário e confirmar a reserva.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        Como cadastrar minha arena?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Clique em <strong>Cadastrar Arena</strong>, preencha os dados do espaço esportivo e envie o cadastro para análise.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        Quais formas de pagamento são aceitas?
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        As formas de pagamento podem variar conforme a arena, mas normalmente incluem <strong>PIX</strong>, <strong>dinheiro</strong> e <strong>cartão</strong>.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        Qual é o horário de funcionamento?
                    </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        O funcionamento padrão é de <strong>segunda a domingo, das 07:00 às 23:00</strong>.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
        </div>

    </div>
</section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <div class="footer-brand">EsporTec</div>
            <div class="footer-links mb-3">
                <a href="/">Início</a>
                <a href="#quadras">Quadras</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
                <a href="#modalPrivacidade" data-bs-toggle="modal" data-bs-target="#modalPrivacidade">Política de Privacidade</a>
            </div>
            <p class="mb-0 opacity-75">&copy; 2026 EsporTec - Gestão de Espaços Esportivos | Reservas, agenda e pagamentos em um só lugar</p>
        </div>
    </footer>

    <div class="modal fade" id="modalPrivacidade" tabindex="-1" aria-labelledby="modalPrivacidadeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="modalPrivacidadeLabel">Política de Privacidade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-0">A EsporTec usa os dados informados apenas para cadastro, reservas, notificações e contato com o cliente, conforme a LGPD.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary-custom" data-bs-dismiss="modal">Entendi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>

    <!-- Script para interatividade -->
    <script>
        // Smooth scroll para links
        document.querySelectorAll('a[href^="#"]:not([data-bs-toggle])').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                if (this.getAttribute('href') === '#') {
                    return;
                }
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Animação nos time slots
        document.querySelectorAll('.time-slot.time-available').forEach(slot => {
            slot.addEventListener('click', function() {
                document.querySelectorAll('.time-slot.time-selected').forEach(selected => selected.classList.remove('time-selected'));
                this.classList.add('time-selected');
                esportecToast(`Horário selecionado: ${this.textContent}`, 'success');
            });
        });
        const quadrasGrid = document.getElementById('quadrasGrid');
        const quadrasSlider = document.getElementById('quadrasSlider');
        const quadrasDots = [...document.querySelectorAll('[data-quadras-dot]')];
        const quadrasPrevButton = document.querySelector('[data-quadras-prev]');
        const quadrasNextButton = document.querySelector('[data-quadras-next]');
        let currentQuadraSlide = 0;
        let quadrasAutoPlay = null;

        function getQuadrasSlides() {
            return [...quadrasGrid.querySelectorAll('.quadras-item')];
        }

        function showQuadraSlide(index) {
            const slides = getQuadrasSlides();
            if (!slides.length) {
                return;
            }

            currentQuadraSlide = (index + slides.length) % slides.length;
            quadrasGrid.style.transform = `translateX(-${currentQuadraSlide * 100}%)`;

            slides.forEach((slide, slideIndex) => {
                slide.classList.toggle('active', slideIndex === currentQuadraSlide);
            });

            quadrasDots.forEach((dot, dotIndex) => {
                const isActive = dotIndex === currentQuadraSlide;
                dot.classList.toggle('active', isActive);
                dot.setAttribute('aria-current', isActive ? 'true' : 'false');
            });
        }

        function restartQuadrasAutoPlay() {
            clearInterval(quadrasAutoPlay);
            quadrasAutoPlay = setInterval(() => {
                showQuadraSlide(currentQuadraSlide + 1);
            }, 7500);
        }

        quadrasPrevButton.addEventListener('click', () => {
            showQuadraSlide(currentQuadraSlide - 1);
            restartQuadrasAutoPlay();
        });

        quadrasNextButton.addEventListener('click', () => {
            showQuadraSlide(currentQuadraSlide + 1);
            restartQuadrasAutoPlay();
        });

        quadrasDots.forEach(dot => {
            dot.addEventListener('click', () => {
                showQuadraSlide(Number(dot.dataset.quadrasDot));
                restartQuadrasAutoPlay();
            });
        });

        quadrasSlider.addEventListener('mouseenter', () => clearInterval(quadrasAutoPlay));
        quadrasSlider.addEventListener('mouseleave', restartQuadrasAutoPlay);
        showQuadraSlide(0);
        restartQuadrasAutoPlay();
    </script>
</body>
</html>
