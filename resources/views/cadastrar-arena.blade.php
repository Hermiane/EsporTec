<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Arena - EsporTec</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2D815D;
            --dark: #1F5C42;
            --light: #E8F5EE;
            --bg: #F8FAFC;
            --text: #334155;
            --gray: #64748B;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.7rem;
        }

        .btn-primary-custom {
            background: var(--primary);
            color: white;
            border-radius: 10px;
            font-weight: 600;
            border: none;
        }

        .btn-primary-custom:hover {
            background: var(--dark);
            color: white;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .form-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 0.8rem;
        }

        .section-title {
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1rem;
        }

        .info-box {
            background: var(--light);
            border-radius: 16px;
            padding: 1.5rem;
            height: auto;
        }

        .info-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

        .info-section .info-box {
        margin-bottom: 0 !important;
    }

        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .form-card {
                padding: 1.3rem;
            }

            .info-section {
            grid-template-columns: 1fr;
    }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg py-3">
    <div class="container">
        <a class="navbar-brand" href="/">EsporTec</a>

        <div class="d-flex gap-2">
            <a href="/" class="btn btn-outline-success">
                Início
            </a>

            <a href="/login" class="btn btn-primary-custom">
                Entrar
            </a>
        </div>
    </div>
</nav>

<main class="container py-5">

    <section class="page-header">
        <h1 class="fw-bold mb-2">Cadastre sua Arena</h1>
        <p class="mb-0 fs-8">
            Cadastre seu espaço esportivo para receber reservas pelo EsporTec.
        </p>
    </section>

    <form id="formArena">

        <div class="row g-4">

            <div class="col-12 order-2">

                <div class="form-card">
                    <h4 class="section-title">
                        <i class="bi bi-building me-2 text-success"></i>
                        Dados da Arena
                    </h4>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nome da Arena</label>
                            <input type="text" class="form-control" placeholder="Ex: Arena Society Cametá" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CNPJ</label>
                            <input type="text" class="form-control" placeholder="00.000.000/0001-00" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Responsável</label>
                            <input type="text" class="form-control" placeholder="Nome do responsável" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" class="form-control" placeholder="(91) 99999-9999" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" class="form-control" placeholder="arena@email.com" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Logradouro</label>
                            <input type="text" class="form-control" placeholder="Rua ou avenida" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Número</label>
                            <input type="text" class="form-control" placeholder="123">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Bairro</label>
                            <input type="text" class="form-control" placeholder="Centro" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Cidade</label>
                            <input type="text" class="form-control" placeholder="Cametá" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">UF</label>
                            <input type="text" class="form-control" placeholder="PA" maxlength="2" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Ponto de referência</label>
                            <input type="text" class="form-control" placeholder="Próximo ao ginásio">
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <h4 class="section-title">
                        <i class="bi bi-dribbble me-2 text-success"></i>
                        Informações das Quadras
                    </h4>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tipo de Quadra</label>
                            <select class="form-select" required>
                                <option value="">Selecione</option>
                                <option>Society</option>
                                <option>Futsal</option>
                                <option>Society e Futsal</option>
                                <option>Outros</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Quantidade de Quadras</label>
                            <input type="number" class="form-control" placeholder="Ex: 2" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Valor por Hora</label>
                            <input type="text" class="form-control" placeholder="Ex: R$ 120,00" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Capacidade</label>
                            <input type="text" class="form-control" placeholder="Ex: 10 jogadores" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Horário de Abertura</label>
                            <input type="time" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Horário de Fechamento</label>
                            <input type="time" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Descrição do Espaço</label>
                            <textarea class="form-control" rows="4" placeholder="Descreva a estrutura, cobertura, iluminação, vestiários..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <h4 class="section-title">
                        <i class="bi bi-credit-card me-2 text-success"></i>
                        Formas de Pagamento
                    </h4>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tipo da chave PIX</label>
                            <select class="form-select" required>
                                <option value="">Selecione</option>
                                <option>CPF</option>
                                <option>CNPJ</option>
                                <option>E-mail</option>
                                <option>Telefone</option>
                                <option>Aleatória</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Chave PIX</label>
                            <input type="text" class="form-control" placeholder="Chave usada para receber pagamentos" required>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked>
                                <label class="form-check-label">PIX</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Dinheiro</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Cartão crédito</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Cartão débito</label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success mt-4 rounded-4">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="confirmarPagamento" required>
        <label class="form-check-label fw-semibold" for="confirmarPagamento">
            Confirmo que a arena aceita as formas de pagamento selecionadas.
        </label>
    </div>
</div>

                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-3 fs-5">
                    Enviar Cadastro da Arena
                </button>

            </div>

            <div class="col-12 order-1 info-section">

                <div class="info-box mb-4">
                    <h5 class="fw-bold">
                        <i class="bi bi-info-circle me-2"></i>
                        Como funciona?
                    </h5>

                    <p class="mb-2">
                        1. Preencha os dados da arena.
                    </p>

                    <p class="mb-2">
                        2. Informe os tipos de quadra e horários.
                    </p>

                    <p class="mb-2">
                        3. A equipe EsporTec analisa o cadastro.
                    </p>

                    <p class="mb-0">
                        4. Depois de aprovado, sua arena aparece no sistema.
                    </p>
                </div>

                <div class="info-box">
                    <h5 class="fw-bold">
                        <i class="bi bi-shield-check me-3"></i>
                        Observação
                    </h5>

                    <p class="mb-0">
                        Este cadastro é para donos ou responsáveis por espaços esportivos.
                        Clientes comuns devem criar conta normalmente em “Criar Conta”.
                    </p>
                </div>

            </div>

        </div>

    </form>

</main>

<div class="modal fade" id="sucessoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-body text-center p-5">
                <i class="bi bi-check-circle-fill text-success display-3"></i>

                <h3 class="fw-bold mt-3">
                    Cadastro enviado!
                </h3>

                <p class="text-muted">
                    Sua arena foi cadastrada para análise da equipe EsporTec.
                </p>

                <a href="/" class="btn btn-primary-custom px-4 py-2">
                    Voltar para Início
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const formArena = document.getElementById('formArena');

    formArena.addEventListener('submit', function(event) {
        event.preventDefault();

        esportecWithLoading(event.submitter, 'Enviando...', () => esportecMockApi('arenas.solicitarCadastro')).then(() => {
            const modal = new bootstrap.Modal(document.getElementById('sucessoModal'));
            modal.show();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>

</body>
</html>
