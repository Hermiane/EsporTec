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
    </style>
</head>
<body>
<!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">EsporTec</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="#quadras">Quadras</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sobre">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contato">Contato</a></li>
                </ul>
            </div>
            <div class="d-flex gap-2">
                <a href="/login" class="btn btn-outline-primary">Entrar</a>
                <a href="/criar-conta" class="btn btn-primary-custom">Criar Conta</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="hero-title">EsporTec</h1>
            <p class="hero-subtitle">Gestão inteligente de espaços esportivos</p>
            
            <div class="search-pill">
                <input type="text" placeholder="Buscar quadras...">
                <button class="btn btn-reserve">Reservar Quadra</button>
                <button class="btn btn-register">Cadastrar Espaço</button>
            </div>
        </div>
    </section>

    <!-- Nossas Quadras -->
    <section id="quadras" class="section-padding">
        <div class="container">
            <h2 class="section-title">Nossas Quadras</h2>
            
            <div class="row">
                <div class="col-lg-6">
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
                            <a href="/detalhes-quadra" class="btn btn-details">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
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
                            <a href="/detalhes-quadra" class="btn btn-details">Ver Detalhes</a>
                        </div>
                    </div>
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
    <section id="contato" class="section-padding">
        <div class="container">
            <h2 class="section-title">Informações</h2>
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="info-card">
                        <h3 class="info-title">Contato</h3>
                        <div class="info-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div>
                                <strong>Endereço</strong><br>
                                Rua dos Esportes, 123 - São Paulo, SP
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-telephone-fill"></i>
                            <div>
                                <strong>Telefone</strong><br>
                                (11) 99999-9999
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-envelope-fill"></i>
                            <div>
                                <strong>E-mail</strong><br>
                                contato@esportec.com.br
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-clock-fill"></i>
                            <div>
                                <strong>Horário de Funcionamento</strong><br>
                                Seg a Dom | 07:00–23:00
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="info-card">
                        <h3 class="info-title">Tabela de Valores</h3>
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
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
                                    <tr>
                                        <td>Futsal Arena</td>
                                        <td>Futsal</td>
                                        <td>R$ 120</td>
                                        <td>Sim</td>
                                        <td>10 jogadores</td>
                                    </tr>
                                    <tr>
                                        <td>Society Premium</td>
                                        <td>Society</td>
                                        <td>R$ 150</td>
                                        <td>Não</td>
                                        <td>14 jogadores</td>
                                    </tr>
                                    <tr>
                                        <td>Beach Tennis</td>
                                        <td>Areia</td>
                                        <td>R$ 100</td>
                                        <td>Não</td>
                                        <td>4 jogadores</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <h5 class="fw-semibold mb-3">Formas de Pagamento</h5>
                            <div class="d-flex gap-3">
                                <div class="text-center">
                                    <i class="bi bi-qr-code-scan display-4 text-success"></i>
                                    <p class="mb-0 mt-2 small">PIX</p>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-cash-stack display-4 text-success"></i>
                                    <p class="mb-0 mt-2 small">Dinheiro</p>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-credit-card display-4 text-success"></i>
                                    <p class="mb-0 mt-2 small">Cartão</p>
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
                <a href="#">Início</a>
                <a href="#quadras">Quadras</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
                <a href="#">Política de Privacidade</a>
            </div>
            <p class="mb-0 opacity-75">&copy; 2026 EsporTec - Universidade Federal do Pará | Prof. Dr. Fabricio Farias</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para interatividade -->
    <script>
        // Smooth scroll para links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
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
                alert('Horário selecionado: ' + this.textContent);
            });
        });
    </script>
</body>
</html>