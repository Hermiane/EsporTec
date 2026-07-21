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
                            <input name="nome" type="text" class="form-control" placeholder="Ex: Arena Society Cametá" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CNPJ</label>
                            <input name="cnpj" type="text" class="form-control" placeholder="00.000.000/0001-00" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Responsável</label>
                            <input name="responsavel" type="text" class="form-control" placeholder="Nome do responsável" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input name="telefone" type="text" class="form-control" placeholder="(91) 99999-9999" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input name="email" type="email" class="form-control" placeholder="arena@email.com" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Foto de capa da arena</label>
                            <input name="foto_capa" type="file" class="form-control" accept="image/jpeg,image/png,image/webp">
                            <small class="text-muted">JPG, PNG ou WebP, até 5 MB.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Logradouro</label>
                            <input name="logradouro" type="text" class="form-control" placeholder="Rua ou avenida" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Número</label>
                            <input name="numero" type="text" class="form-control" placeholder="123">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Bairro</label>
                            <input name="bairro" type="text" class="form-control" placeholder="Centro" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Cidade</label>
                            <input name="cidade" type="text" class="form-control" placeholder="Cametá" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">UF</label>
                            <input name="estado" type="text" class="form-control" placeholder="PA" maxlength="2" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Ponto de referência</label>
                            <input name="ponto_referencia" type="text" class="form-control" placeholder="Próximo ao ginásio">
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
                            <select name="tipo_quadra" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="society">Society</option>
                                <option value="futsal">Futsal</option>
                                <option value="misto">Society e Futsal</option>
                                <option value="futebol">Outros</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Quantidade de Quadras</label>
                            <input name="quantidade_quadras" id="quantidadeQuadras" type="number" min="1" max="20" class="form-control" placeholder="Ex: 2" required>
                        </div>

                        <div class="col-12" id="camposQuadras">
                            <div class="alert alert-light border mb-0">Informe a quantidade de quadras para adicionar o nome e a foto de cada uma.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Valor por Hora</label>
                            <input name="preco_hora" type="number" min="0" step="0.01" class="form-control" placeholder="Ex: 120,00" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Capacidade</label>
                            <input name="capacidade_jogador" type="number" min="1" class="form-control" placeholder="Ex: 10" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Horário de Abertura</label>
                            <input name="hora_inicio" type="time" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Horário de Fechamento</label>
                            <input name="hora_fim" type="time" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Descrição do Espaço</label>
                            <textarea name="descricao" class="form-control" rows="4" placeholder="Descreva a estrutura, cobertura, iluminação, vestiários..." required></textarea>
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
                            <select name="pix_tipo" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="cpf">CPF</option>
                                <option value="cnpj">CNPJ</option>
                                <option value="email">E-mail</option>
                                <option value="telefone">Telefone</option>
                                <option value="aleatoria">Aleatória</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Chave PIX</label>
                            <input name="pix_chave" type="text" class="form-control" placeholder="Chave usada para receber pagamentos" required>
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

<script src="/js/esportec-api.js"></script>
<script>
    const formArena = document.getElementById('formArena');
    const quantidadeQuadras = document.getElementById('quantidadeQuadras');
    const camposQuadras = document.getElementById('camposQuadras');

    function renderizarCamposQuadras() {
        const quantidade = Math.min(Math.max(parseInt(quantidadeQuadras.value || '0', 10), 0), 20);
        if (!quantidade) { camposQuadras.innerHTML = '<div class="alert alert-light border mb-0">Informe a quantidade de quadras para adicionar o nome e a foto de cada uma.</div>'; return; }
        camposQuadras.innerHTML = `<label class="form-label fw-semibold d-block mb-3">Dados de cada quadra</label>${Array.from({ length: quantidade }, (_, indice) => `<div class="border rounded-3 p-3 mb-3"><strong class="d-block mb-3">Quadra ${indice + 1}</strong><div class="row g-3"><div class="col-md-6"><label class="form-label">Nome da quadra</label><input name="quadras[${indice}][nome]" class="form-control" placeholder="Ex: Society Premium" required></div><div class="col-md-6"><label class="form-label">Foto da quadra</label><input name="quadras[${indice}][foto]" type="file" class="form-control" accept="image/jpeg,image/png,image/webp"><small class="text-muted">JPG, PNG ou WebP, até 5 MB.</small></div></div></div>`).join('')}`;
    }
    quantidadeQuadras.addEventListener('input', renderizarCamposQuadras);

    formArena.addEventListener('submit', async function(event) {
        event.preventDefault();
        if (!EsporTecApi.token()) {
            window.location.href = '/login?redirect=' + encodeURIComponent('/cadastrar-arena');
            return;
        }
        const botao = event.submitter;
        const textoOriginal = botao.innerHTML;
        botao.disabled = true;
        botao.textContent = 'Enviando...';
        try {
            await EsporTecApi.request('/api/arenas/solicitacoes', { method: 'POST', body: new FormData(formArena) });
            const modal = new bootstrap.Modal(document.getElementById('sucessoModal'));
            modal.show();
        } catch (error) {
            alert(error.message);
        } finally {
            botao.disabled = false;
            botao.innerHTML = textoOriginal;
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>

</body>
</html>
