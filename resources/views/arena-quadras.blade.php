<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $arena['nome'] }} - Quadras | EsporTec</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2D815D;
            --primary-dark: #1F5C42;
            --light: #E8F5EE;
            --text: #1F2937;
            --muted: #6B7280;
        }

        body {
            background: #F8FAF9;
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background: #FFFFFF;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            color: var(--primary);
            font-size: 1.9rem;
            font-weight: 800;
        }

        .nav-link {
            color: var(--text);
            font-weight: 600;
        }

        .btn-primary-custom {
            background: var(--primary);
            border: 1px solid var(--primary);
            border-radius: 10px;
            color: #FFFFFF;
            font-weight: 700;
            padding: 0.65rem 1rem;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: #FFFFFF;
        }

        .btn-outline-custom {
            border: 1px solid var(--primary);
            border-radius: 10px;
            color: var(--primary);
            font-weight: 700;
            padding: 0.65rem 1rem;
        }

        .btn-outline-custom:hover {
            background: var(--light);
            border-color: var(--primary);
            color: var(--primary-dark);
        }

        .dropdown-menu {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(31,92,66,0.14);
            min-width: 165px;
            padding: 0.45rem;
        }

        .dropdown-item {
            border-radius: 8px;
            color: var(--text);
            font-size: 0.88rem;
            font-weight: 600;
            padding: 0.55rem 0.65rem;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: #F1F3F2;
            color: var(--text);
        }

        .dropdown-item.active,
        .dropdown-item:active {
            background: var(--primary);
            color: #FFFFFF;
        }

        .arena-hero {
            background:
                linear-gradient(90deg, rgba(31,92,66,0.92), rgba(45,129,93,0.72)),
                url('{{ $arena['imagem'] }}') center/cover;
            color: #FFFFFF;
            padding: 78px 0 64px;
        }

        .arena-hero h1 {
            font-size: clamp(2rem, 5vw, 3.4rem);
            font-weight: 800;
            margin-bottom: 0.75rem;
        }

        .arena-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1.2rem;
        }

        .arena-meta span {
            align-items: center;
            backdrop-filter: blur(8px);
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            border-radius: 999px;
            display: inline-flex;
            gap: 0.45rem;
            padding: 0.45rem 0.8rem;
        }

        .section-padding {
            padding: 56px 0;
        }

        .section-title {
            color: var(--primary-dark);
            font-size: clamp(1.7rem, 3vw, 2.3rem);
            font-weight: 800;
            margin-bottom: 0.75rem;
        }

        .court-card {
            background: #FFFFFF;
            border: 1px solid #E6EFEA;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(31,92,66,0.08);
            height: 100%;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .court-card:hover {
            box-shadow: 0 14px 32px rgba(31,92,66,0.14);
            transform: translateY(-4px);
        }

        .court-img {
            height: 210px;
            object-fit: cover;
            width: 100%;
        }

        .court-body {
            padding: 1.2rem;
        }

        .courts-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .court-title {
            color: var(--text);
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .court-info {
            color: var(--muted);
            margin-bottom: 0.35rem;
        }

        .description-toggle {
            align-items: center;
            background: transparent;
            border: 0;
            color: var(--primary-dark);
            display: flex;
            font-weight: 800;
            justify-content: space-between;
            margin: 0.35rem 0 0.65rem;
            padding: 0;
            width: 100%;
        }

        .description-toggle i {
            transition: transform 0.2s ease;
        }

        .description-toggle[aria-expanded="true"] i {
            transform: rotate(180deg);
        }

        .court-description {
            background: #F8FAF9;
            border-radius: 6px;
            color: var(--muted);
            font-size: 0.92rem;
            margin-bottom: 0.75rem;
            padding: 0.7rem;
        }

        .badge-soft {
            background: var(--light);
            border-radius: 999px;
            color: var(--primary-dark);
            display: inline-flex;
            font-weight: 700;
            margin-bottom: 0.8rem;
            padding: 0.35rem 0.7rem;
        }

        .price {
            color: var(--primary);
            font-size: 1.35rem;
            font-weight: 800;
            margin: 0.9rem 0;
        }

        .owner-line {
            align-items: center;
            color: var(--primary-dark);
            display: inline-flex;
            font-weight: 700;
            gap: 0.45rem;
            margin-top: 0.45rem;
        }

        .arena-info-panel {
            background: #FFFFFF;
            border: 1px solid #E6EFEA;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(31,92,66,0.07);
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            padding: 1rem max(1rem, calc((100vw - 1140px) / 2));
        }

        .arena-info-grid {
            display: grid;
            gap: 0.75rem;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .arena-info-item {
            background: #F8FAF9;
            border-radius: 6px;
            padding: 0.75rem;
        }

        .arena-info-item i {
            color: var(--primary);
            font-size: 1rem;
            margin-right: 0.45rem;
        }

        .arena-info-label {
            color: var(--muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .arena-info-value {
            color: var(--text);
            font-weight: 700;
            margin-top: 0.25rem;
            overflow-wrap: normal;
            word-break: normal;
        }

        .arena-info-value.email-value {
            display: block;
            font-size: clamp(0.78rem, 2.5vw, 1rem);
            overflow: visible;
            white-space: normal;
        }

        footer {
            background: var(--primary-dark);
            color: #FFFFFF;
            padding: 28px 0;
        }

        footer a {
            color: #FFFFFF;
            font-weight: 600;
            margin: 0 0.5rem;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .courts-grid {
                gap: 1rem;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .court-img {
                height: 135px;
            }

            .court-body {
                padding: 0.8rem;
            }

            .court-title {
                font-size: 1rem;
            }

            .court-info {
                font-size: 0.82rem;
            }

            .price {
                font-size: 1rem;
                margin: 0.6rem 0;
            }

            .badge-soft {
                font-size: 0.72rem;
                padding: 0.28rem 0.5rem;
            }

            .court-card .btn {
                font-size: 0.82rem;
                padding: 0.55rem 0.45rem;
            }

            .arena-info-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .arena-info-item {
                min-width: 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">EsporTec</a>

            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublicArena" aria-controls="navbarPublicArena" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarPublicArena">
                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item"><a class="nav-link" href="/">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="/#arenas">Arenas</a></li>
                    <li class="nav-item"><a class="nav-link" href="/#sobre">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="/#contato">Contato</a></li>
                </ul>

                <div class="d-flex flex-column flex-lg-row gap-2 mt-3 mt-lg-0">
                    <a href="/login" class="btn btn-outline-custom">Entrar</a>
                    <a href="/criar-conta" class="btn btn-primary-custom">Criar Conta</a>
                </div>
            </div>
        </div>
    </nav>

    <header class="arena-hero">
        <div class="container">
            <a href="/#arenas" class="btn btn-light btn-sm fw-semibold mb-4">
                <i class="bi bi-arrow-left me-1"></i>Voltar para arenas
            </a>
            <h1>{{ $arena['nome'] }}</h1>
            <p class="lead mb-0" style="max-width: 740px;">{{ $arena['descricao'] }}</p>
            <div class="arena-meta">
                <span><i class="bi bi-geo-alt"></i>{{ $arena['endereco'] }}</span>
                <span><i class="bi bi-clock"></i>{{ $arena['funcionamento'] }}</span>
                <span><i class="bi bi-grid-3x3-gap"></i>{{ count($arena['quadras']) }} {{ count($arena['quadras']) === 1 ? 'quadra' : 'quadras' }}</span>
            </div>
        </div>
    </header>

    <main class="section-padding">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
                <div>
                    <h2 class="section-title">Quadras disponíveis</h2>
                    <p class="text-muted mb-0">Escolha uma quadra desta arena. Para reservar, entre na sua conta ou crie um cadastro.</p>
                    <div class="owner-line">
                        <i class="bi bi-person-circle"></i>
                        <span>Dono da arena: {{ $arena['dono'] }}</span>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-custom dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-building me-1"></i>Trocar arena
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($arenasMenu as $item)
                            <li>
                                <a
                                    href="/arenas/{{ $item['slug'] }}/quadras"
                                    class="dropdown-item {{ $item['slug'] === $slug ? 'active' : '' }}"
                                >
                                    {{ $item['nome'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="courts-grid">
                @foreach ($arena['quadras'] as $quadra)
                    <div>
                        <article class="court-card">
                            <img src="{{ $quadra['imagem'] }}" alt="{{ $quadra['nome'] }}" class="court-img">
                            <div class="court-body">
                                <span class="badge-soft">{{ $arena['nome'] }}</span>
                                <h3 class="court-title">{{ $quadra['nome'] }}</h3>
                                <button
                                    class="description-toggle"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#descricao-{{ $quadra['slug'] }}"
                                    aria-expanded="false"
                                    aria-controls="descricao-{{ $quadra['slug'] }}"
                                >
                                    <span>Descrição</span>
                                    <i class="bi bi-chevron-up"></i>
                                </button>
                                <div class="collapse" id="descricao-{{ $quadra['slug'] }}">
                                    <div class="court-description">
                                        <p class="mb-2">{{ $quadra['descricao'] }}</p>
                                        <p class="mb-1"><strong>Tipo:</strong> {{ $quadra['tipo'] }}</p>
                                        <p class="mb-1"><strong>Capacidade:</strong> {{ $quadra['capacidade'] }}</p>
                                        <p class="mb-0"><strong>Coberta:</strong> {{ $quadra['coberta'] }}</p>
                                    </div>
                                </div>
                                <div class="price">{{ $quadra['preco'] }}</div>
                                <a
                                    href="/login?redirect={{ urlencode('/nova-reserva?arena='.$slug.'&quadra='.$quadra['slug'].'&etapa=data') }}"
                                    class="btn btn-primary-custom w-100"
                                >
                                    <i class="bi bi-calendar-plus me-2"></i>Reservar
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <section class="arena-info-panel mt-5">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                    <div>
                        <h2 class="section-title mb-1">Informações da arena</h2>
                        <p class="text-muted mb-0">Dados principais para contato, localização e atendimento.</p>
                    </div>
                    <span class="badge-soft">{{ $arena['nome'] }}</span>
                </div>

                <div class="arena-info-grid">
                    <div class="arena-info-item">
                        <div class="arena-info-label"><i class="bi bi-person"></i>Responsável</div>
                        <div class="arena-info-value">{{ $arena['dono'] }}</div>
                    </div>

                    <div class="arena-info-item">
                        <div class="arena-info-label"><i class="bi bi-telephone"></i>Contato</div>
                        <div class="arena-info-value">{{ $arena['telefone'] }}</div>
                    </div>

                    <div class="arena-info-item">
                        <div class="arena-info-label"><i class="bi bi-envelope"></i>E-mail</div>
                        <div class="arena-info-value email-value" title="{{ $arena['email'] }}">{!! str_replace(['@', '.'], ['@<wbr>', '.<wbr>'], e($arena['email'])) !!}</div>
                    </div>

                    <div class="arena-info-item">
                        <div class="arena-info-label"><i class="bi bi-geo-alt"></i>Endereço</div>
                        <div class="arena-info-value">{{ $arena['endereco'] }}</div>
                    </div>

                    <div class="arena-info-item">
                        <div class="arena-info-label"><i class="bi bi-calendar-week"></i>Dias de funcionamento</div>
                        <div class="arena-info-value">{{ $arena['dias_funcionamento'] }}</div>
                    </div>

                    <div class="arena-info-item">
                        <div class="arena-info-label"><i class="bi bi-clock"></i>Horário</div>
                        <div class="arena-info-value">{{ $arena['funcionamento'] }}</div>
                    </div>

                    <div class="arena-info-item">
                        <div class="arena-info-label"><i class="bi bi-grid-3x3-gap"></i>Número de quadras</div>
                        <div class="arena-info-value">{{ count($arena['quadras']) }} {{ count($arena['quadras']) === 1 ? 'quadra' : 'quadras' }}</div>
                    </div>

                    <div class="arena-info-item">
                        <div class="arena-info-label"><i class="bi bi-credit-card"></i>Pagamentos aceitos</div>
                        <div class="arena-info-value">{{ implode(', ', $arena['formas_pagamento']) }}</div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <div class="container text-center">
            <div class="fw-bold fs-4 mb-2">EsporTec</div>
            <div class="mb-2">
                <a href="/">Início</a>
                <a href="/#arenas">Arenas</a>
                <a href="/#contato">Contato</a>
            </div>
            <p class="mb-0 opacity-75">&copy; 2026 EsporTec - Gestão de Espaços Esportivos</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
