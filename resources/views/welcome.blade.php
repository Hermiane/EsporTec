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

        .arena-search-pill {
            align-items: center;
            background: #FFFFFF;
            border: 1px solid #DDEBE4;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(31,92,66,0.08);
            display: flex;
            gap: 0.65rem;
            margin: 0;
            max-width: 430px;
            padding: 0.42rem;
            width: min(100%, 430px);
        }

        .arena-search-control {
            align-items: center;
            background: #F8FAF9;
            border-radius: 8px;
            display: flex;
            flex: 1;
            gap: 0.5rem;
            padding: 0 0.8rem;
        }

        .arena-search-control i {
            color: var(--primary-green);
        }

        .arena-search-control input {
            background: transparent;
            border: 0;
            flex: 1;
            font-size: 0.88rem;
            outline: 0;
            padding: 0.5rem 0;
        }

        .arena-search-btn {
            background: #E8F5EE;
            border-radius: 8px;
            color: var(--primary-green);
            padding: 0.5rem 0.9rem;
            white-space: nowrap;
        }

        .arena-search-btn:hover {
            background: #D7EDE2;
            color: var(--dark-green);
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

        /* ✅ CORREÇÕES RESPONSIVAS */
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

            .arena-search-pill {
                align-items: stretch;
                flex-direction: column;
                max-width: 100%;
            }

            .arena-search-btn {
                width: 100%;
            }

            .section-title {
                font-size: 1.8rem;
            }

            /* Tabela responsiva com scroll horizontal */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-custom {
                min-width: 700px; /* Garante largura mínima para não quebrar */
            }

            .table-custom th,
            .table-custom td {
                white-space: nowrap; /* Impede quebra de linha nas células */
                font-size: 0.9rem;
                padding: 0.75rem;
            }

            .navbar-collapse {
                background: white;
                padding: 1rem;
                border-radius: 8px;
                margin-top: 1rem;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            }

            .navbar-nav {
                margin-bottom: 1rem;
            }

            .d-flex.flex-column.flex-lg-row {
                flex-direction: column !important;
            }

            .d-flex.flex-column.flex-lg-row .btn {
                width: 100%;
            }

            .cta-info {
                grid-template-columns: 1fr;
            }

            .arena-public-card {
                padding: 1rem;
            }

            .contact-card,
            .faq-card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 80px 0 60px;
            }

            .section-padding {
                padding: 40px 0;
            }

            .feature-card {
                padding: 1.5rem 1rem;
            }

            .feature-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .table-custom th,
            .table-custom td {
                font-size: 0.85rem;
                padding: 0.6rem;
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
    .arena-public-card {
        background: #fff;
        border: 1px solid #E8F5EE;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        height: 100%;
        padding: 1.25rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .arena-public-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(45,129,93,0.13);
    }

    .arena-public-icon {
        align-items: center;
        background: #E8F5EE;
        border-radius: 12px;
        color: var(--primary);
        display: inline-flex;
        font-size: 1.6rem;
        height: 48px;
        justify-content: center;
        margin-bottom: 1rem;
        width: 48px;
    }

    .arena-public-meta {
        color: #5F6F65;
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        margin: 0.85rem 0 1rem;
    }

    .arena-public-meta span,
    .arena-badge {
        background: #E8F5EE;
        border-radius: 999px;
        color: var(--primary-dark);
        font-size: 0.82rem;
        font-weight: 600;
        padding: 0.35rem 0.65rem;
    }

    .arena-owner-info {
        color: #475569;
        font-size: 0.92rem;
        margin-top: 0.9rem;
    }

    .arena-owner-info p {
        align-items: flex-start;
        display: flex;
        gap: 0.45rem;
        margin-bottom: 0.4rem;
    }

    .arena-owner-info i {
        color: var(--primary);
        margin-top: 0.1rem;
    }

    .arena-filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        justify-content: center;
        margin: 1rem auto 1.35rem;
    }

    .arena-filter-btn {
        background: #fff;
        border: 1px solid #BFDCCF;
        border-radius: 999px;
        color: var(--primary-dark);
        font-weight: 600;
        padding: 0.55rem 1rem;
    }

    .arena-filter-btn.active,
    .arena-filter-btn:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }

    @media (max-width: 768px) {
        .faq-card {
            padding: 1.5rem;
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
                    <a class="nav-link" href="#arenas">
                        Arenas
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
        </div>
    </section>

    <!-- Arenas cadastradas -->
    <section id="arenas" class="section-padding">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
                <div class="text-center flex-grow-1">
                    <h2 class="section-title mb-2">Arenas Cadastradas</h2>
                    <p class="section-subtitle mx-auto mb-0" style="max-width: 720px;">
                        Busque uma arena ou escolha uma opção cadastrada para ver quadras, valores e horários daquele local.
                    </p>
                </div>
                <div class="arena-search-pill" aria-label="Filtrar arenas cadastradas">
                    <div class="arena-search-control">
                        <i class="bi bi-search"></i>
                        <input type="text" id="buscarQuadra" placeholder="Buscar arena ou quadra">
                    </div>
                    <button type="button" class="btn btn-reserve arena-search-btn" id="btnBuscarQuadra">
                        Buscar
                    </button>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($arenas as $arena)
                    @php
                        $horarios = $arena->quadras->flatMap->horariosFuncionamento;
                        $inicio = $horarios->min('hora_inicio');
                        $fim = $horarios->max('hora_fim');
                        $endereco = collect([$arena->logradouro, $arena->numero, $arena->bairro, $arena->cidade, $arena->estado])->filter()->implode(', ');
                    @endphp
                    <div class="col-md-4">
                        <div class="arena-public-card">
                            @if ($arena->foto_capa)
                                <img src="{{ $arena->foto_capa }}" alt="{{ $arena->nome }}" class="w-100 rounded mb-3" style="height: 160px; object-fit: cover;">
                            @else
                                <div class="arena-public-icon"><i class="bi bi-building"></i></div>
                            @endif
                            <h3 class="feature-title">{{ $arena->nome }}</h3>
                            <p class="mb-0 text-muted">{{ $arena->descricao ?: 'Informações da arena disponíveis em sua página.' }}</p>
                            <div class="arena-owner-info">
                                <p><i class="bi bi-person-circle"></i><span><strong>Responsável:</strong> {{ $arena->criadoPor?->nome_completo ?? 'Não informado' }}</span></p>
                                <p><i class="bi bi-geo-alt"></i><span><strong>Endereço:</strong> {{ $endereco ?: 'Não informado' }}</span></p>
                            </div>
                            <div class="arena-public-meta">
                                <span>{{ $arena->quadras_ativas_count }} {{ $arena->quadras_ativas_count === 1 ? 'quadra' : 'quadras' }}</span>
                                <span>{{ $inicio && $fim ? substr($inicio, 0, 5).' - '.substr($fim, 0, 5) : 'Horários a consultar' }}</span>
                            </div>
                            <a href="/arenas/{{ $arena->id }}/quadras" class="btn btn-details w-100">Ver quadras desta arena</a>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><p class="text-center text-muted mb-0">Ainda não há arenas aprovadas disponíveis.</p></div>
                @endforelse
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
                            <th>Arena</th>
                            <th>Quadra</th>
                            <th>Tipo</th>
                            <th>Valor/hora</th>
                            <th>Coberta</th>
                            <th>Capacidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($arenas as $arena)
                            @foreach ($arena->quadras as $quadra)
                                <tr>
                                    <td>{{ $arena->nome }}</td>
                                    <td>{{ $quadra->nome }}</td>
                                    <td>{{ ucfirst($quadra->tipo) }}</td>
                                    <td>R$ {{ number_format((float) $quadra->preco_hora, 2, ',', '.') }}</td>
                                    <td>{{ $quadra->coberta ? 'Sim' : 'Não' }}</td>
                                    <td>{{ $quadra->capacidade_jogador }} jogadores</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">Nenhuma quadra disponível no momento.</td></tr>
                        @endforelse
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
                <a href="#arenas">Arenas</a>
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

        const buscarQuadra = document.getElementById('buscarQuadra');
        const arenaSearchRoutes = @json($arenas->map(fn ($arena) => [
            'terms' => collect([$arena->nome])
                ->merge($arena->quadras->pluck('nome'))
                ->filter()
                ->values(),
            'url' => '/arenas/'.$arena->id.'/quadras',
        ])->values());

        function executarBuscaArena() {
            const term = buscarQuadra.value.trim().toLowerCase();
            if (!term) {
                document.getElementById('arenas').scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }

            const found = arenaSearchRoutes.find(item => {
                return item.terms.some(keyword => keyword.includes(term) || term.includes(keyword));
            });

            if (found) {
                window.location.href = found.url;
                return;
            }

            esportecToast('Nenhuma arena encontrada. Veja as opções cadastradas abaixo.', 'warning');
            document.getElementById('arenas').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        buscarQuadra.addEventListener('keydown', event => {
            if (event.key !== 'Enter') {
                return;
            }

            event.preventDefault();
            executarBuscaArena();
        });

        document.getElementById('btnBuscarQuadra').addEventListener('click', executarBuscaArena);
    </script>
</body>
</html>