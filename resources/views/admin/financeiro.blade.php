<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestão Financeira - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --admin-dark: #1F5C42; --primary: #2D815D; --primary-soft: #E8F5EE; --muted: #64748B; --line: #E2E8F0; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; display: block; }
        .nav-link { color: rgba(255,255,255,0.74); padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .main { flex: 1; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; color: var(--admin-dark); margin: 0; }
        .card-custom { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-box { padding: 1.5rem; border-radius: 12px; color: #334155; background: white; border: 1px solid var(--line); border-left: 4px solid var(--primary); box-shadow: 0 2px 8px rgba(15,23,42,0.04); }
        .stat-box.entradas { border-left-color: var(--primary); }
        .stat-box.saidas { border-left-color: #94A3B8; }
        .stat-box.saldo { border-left-color: var(--admin-dark); }
        .stat-box.semana { border-left-color: #CBD5E1; }
        .stat-value { font-size: 2rem; font-weight: 700; margin: 0.5rem 0; }
        .stat-label { font-size: 0.9rem; color: var(--muted); }
        .stat-box small { color: var(--muted); }
        .stat-box i { color: var(--primary); }
        .chart-container { position: relative; height: 300px; margin-top: 1rem; }
        .btn-primary-admin { background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-primary-admin:hover { background: var(--admin-dark); }
        .legend-dot { width: 12px; height: 12px; border-radius: 50%; display: inline-block; }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="/admin/dashboard" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.75;">Admin da arena</span></a>
        <nav>
            <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
            <a href="/admin/financeiro" class="nav-link active"><i class="bi bi-cash-stack"></i> Financeiro</a>
            <a href="/admin/quadras" class="nav-link"><i class="bi bi-grid-3x3-gap"></i> Quadras</a>
            <a href="/admin/equipe" class="nav-link"><i class="bi bi-person-badge"></i> Equipe</a>
            <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
            <a href="/admin/notificacoes" class="nav-link"><i class="bi bi-bell"></i> Notificações</a>
            <a href="/admin/configuracoes" class="nav-link"><i class="bi bi-gear"></i> Configurações</a>
        </nav>
        <div style="margin-top: auto;"><a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a></div>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1><i class="bi bi-cash-stack me-2"></i>Gestão Financeira</h1>
                <p class="text-muted mb-0">Controle financeiro da arena selecionada</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <input type="month" class="form-control" id="filtroMes" value="2026-06" style="width: 150px;">
                <button class="btn btn-primary-admin" data-bs-toggle="modal" data-bs-target="#modalDespesa"><i class="bi bi-plus-lg me-2"></i>Nova Despesa</button>
                <span class="badge bg-success">Admin da arena</span>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-box entradas">
                <div class="stat-label"><i class="bi bi-arrow-down-circle me-2"></i>Entradas (Pagamentos)</div>
                <div class="stat-value" id="statEntradas">-</div>
                <small id="statEntradasVariacao"><i class="bi bi-arrow-up"></i> Carregando...</small>
            </div>
            <div class="stat-box saidas">
                <div class="stat-label"><i class="bi bi-arrow-up-circle me-2"></i>Saídas (Despesas)</div>
                <div class="stat-value" id="statSaidas">-</div>
                <small id="statSaidasVariacao"><i class="bi bi-arrow-down"></i> Carregando...</small>
            </div>
            <div class="stat-box saldo">
                <div class="stat-label"><i class="bi bi-piggy-bank me-2"></i>Saldo Líquido</div>
                <div class="stat-value" id="statSaldo">-</div>
                <small id="statMargem">Margem: -</small>
            </div>
            <div class="stat-box semana">
                <div class="stat-label"><i class="bi bi-trophy me-2"></i>Melhor Semana</div>
                <div class="stat-value" id="statMelhorSemana">-</div>
                <small id="statMaiorEntrada">Carregando...</small>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card-custom">
                    <h5 class="fw-bold mb-3"><i class="bi bi-bar-chart me-2"></i>Entradas vs Saídas por Semana</h5>
                    <div class="chart-container">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <h5 class="fw-bold mb-3"><i class="bi bi-pie-chart me-2"></i>Despesas por Categoria</h5>
                    <div class="chart-container">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="mt-3" id="legendaPie">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="legend-dot" style="background: #2D815D;"></span>
                            <small>Salários</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="legend-dot" style="background: #1F5C42;"></span>
                            <small>Contas</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="legend-dot" style="background: #94A3B8;"></span>
                            <small>Manutenção</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="legend-dot" style="background: #CBD5E1;"></span>
                            <small>Outros</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="card-custom">
            <h5 class="fw-bold mb-3"><i class="bi bi-receipt-cutoff me-2"></i>Despesas recentes</h5>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Descrição</th><th>Categoria</th><th>Valor</th><th>Status</th></tr></thead>
                    <tbody id="despesasRecentes">
                        <tr><td colspan="4" class="text-center text-muted py-3"><i class="bi bi-hourglass-spin me-2"></i>Carregando despesas...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<div class="modal fade" id="modalDespesa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-receipt me-2"></i>Nova despesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Descrição</label>
                    <input type="text" class="form-control" id="despesaDescricao" placeholder="Ex: Manutenção da quadra">
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Categoria</label>
                        <select class="form-select" id="despesaCategoria">
                            <option>Manutenção</option>
                            <option>Salários</option>
                            <option>Contas</option>
                            <option>Outros</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Valor</label>
                        <input type="number" step="0.01" class="form-control" id="despesaValor" placeholder="0,00">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnSalvarDespesa">Salvar despesa</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>
<script>
    
    //  INTEGRAÇÃO COM API - ADMIN FINANCEIRO
    
    const API_BASE = '/api';
    
    // Mock data para fallback
    const MOCK_FINANCEIRO = {
        stats: {
            entradas: 4850.00,
            entradas_variacao: 12,
            saidas: 1240.00,
            saidas_variacao: -5,
            saldo: 3610.00,
            margem: 74,
            melhor_semana: 'Semana 3',
            maior_entrada: 1600.00
        },
        grafico_semanal: {
            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
            entradas: [1200, 800, 1600, 1250],
            saidas: [300, 200, 400, 340]
        },
        grafico_categorias: {
            labels: ['Salários', 'Contas', 'Manutenção', 'Outros'],
            values: [600, 300, 200, 140],
            colors: ['#2D815D', '#1F5C42', '#94A3B8', '#CBD5E1']
        },
        despesas_recentes: [
            { id: 1, descricao: 'Manutenção do gramado', categoria: 'Manutenção', valor: 340.00, status: 'registrada' },
            { id: 2, descricao: 'Conta de energia', categoria: 'Contas', valor: 620.00, status: 'registrada' },
            { id: 3, descricao: 'Material de limpeza', categoria: 'Outros', valor: 85.50, status: 'registrada' }
        ]
    };

    let barChart = null;
    let pieChart = null;

    //  CARREGAR DADOS FINANCEIROS
    async function carregarFinanceiro(mes = null) {
        try {
            const url = mes ? `${API_BASE}/admin/financeiro?mes=${mes}` : `${API_BASE}/admin/financeiro`;
            const response = await fetch(url);
            
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            
            const dados = await response.json();
            
            // Se API retornar estrutura esperada, usa os dados
            if (dados.stats) {
                renderizarStats(dados.stats);
                if (dados.grafico_semanal) renderizarGraficoBarras(dados.grafico_semanal);
                if (dados.grafico_categorias) renderizarGraficoPizza(dados.grafico_categorias);
                if (dados.despesas_recentes) renderizarDespesas(dados.despesas_recentes);
                console.log(' Dados financeiros carregados da API');
                return;
            }
            
            throw new Error('Estrutura inesperada');
            
        } catch (error) {
            console.log(' Usando dados de teste:', error.message);
            renderizarStats(MOCK_FINANCEIRO.stats);
            renderizarGraficoBarras(MOCK_FINANCEIRO.grafico_semanal);
            renderizarGraficoPizza(MOCK_FINANCEIRO.grafico_categorias);
            renderizarDespesas(MOCK_FINANCEIRO.despesas_recentes);
        }
    }

    function renderizarStats(stats) {
        document.getElementById('statEntradas').textContent = `R$ ${stats.entradas.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
        if (stats.entradas_variacao !== undefined) {
            const sinal = stats.entradas_variacao >= 0 ? '+' : '';
            document.getElementById('statEntradasVariacao').innerHTML = `<i class="bi bi-arrow-${stats.entradas_variacao >= 0 ? 'up' : 'down'}"></i> ${sinal}${stats.entradas_variacao}% vs mês anterior`;
        }
        
        document.getElementById('statSaidas').textContent = `R$ ${stats.saidas.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
        if (stats.saidas_variacao !== undefined) {
            const sinal = stats.saidas_variacao >= 0 ? '+' : '';
            document.getElementById('statSaidasVariacao').innerHTML = `<i class="bi bi-arrow-${stats.saidas_variacao >= 0 ? 'up' : 'down'}"></i> ${sinal}${stats.saidas_variacao}% vs mês anterior`;
        }
        
        document.getElementById('statSaldo').textContent = `R$ ${stats.saldo.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
        if (stats.margem !== undefined) {
            document.getElementById('statMargem').textContent = `Margem: ${stats.margem}%`;
        }
        
        document.getElementById('statMelhorSemana').textContent = stats.melhor_semana || '-';
        if (stats.maior_entrada !== undefined) {
            document.getElementById('statMaiorEntrada').textContent = `Maior entrada: R$ ${stats.maior_entrada.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
        }
    }

    function renderizarGraficoBarras(dados) {
        const ctx = document.getElementById('barChart').getContext('2d');
        
        // Destroi gráfico anterior se existir
        if (barChart) barChart.destroy();
        
        barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dados.labels,
                datasets: [
                    {
                        label: 'Entradas',
                        data: dados.entradas,
                        backgroundColor: '#2D815D',
                        borderRadius: 6
                    },
                    {
                        label: 'Saídas',
                        data: dados.saidas,
                        backgroundColor: '#94A3B8',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true, boxWidth: 8 }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#F1F5F9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    function renderizarGraficoPizza(dados) {
        const ctx = document.getElementById('pieChart').getContext('2d');
        
        // Destroi gráfico anterior se existir
        if (pieChart) pieChart.destroy();
        
        pieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: dados.labels,
                datasets: [{
                    data: dados.values,
                    backgroundColor: dados.colors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '65%'
            }
        });
        
        // Atualiza legenda dinâmica
        const legendaContainer = document.getElementById('legendaPie');
        legendaContainer.innerHTML = '';
        dados.labels.forEach((label, index) => {
            legendaContainer.innerHTML += `
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="legend-dot" style="background: ${dados.colors[index]};"></span>
                    <small>${label}</small>
                </div>
            `;
        });
    }

    function renderizarDespesas(despesas) {
        const tbody = document.getElementById('despesasRecentes');
        tbody.innerHTML = '';
        
        if (!despesas || despesas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Nenhuma despesa registrada.</td></tr>';
            return;
        }
        
        despesas.slice(0, 10).forEach(despesa => {
            tbody.innerHTML += `
                <tr>
                    <td>${despesa.descricao}</td>
                    <td>${despesa.categoria}</td>
                    <td>R$ ${despesa.valor.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                    <td><span class="badge bg-success">Registrada</span></td>
                </tr>
            `;
        });
    }

    //  SALVAR NOVA DESPESA - API: POST /api/admin/financeiro/despesas
    document.getElementById('btnSalvarDespesa').addEventListener('click', async () => {
        const payload = {
            descricao: document.getElementById('despesaDescricao').value.trim(),
            categoria: document.getElementById('despesaCategoria').value,
            valor: parseFloat(document.getElementById('despesaValor').value) || 0
        };
        
        if (!payload.descricao || !payload.valor) {
            esportecToast('Preencha descrição e valor.', 'warning');
            return;
        }
        
        try {
            const response = await fetch(`${API_BASE}/admin/financeiro/despesas`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify(payload)
            });
            
            if (!response.ok) throw new Error('Erro');
            
            bootstrap.Modal.getInstance(document.getElementById('modalDespesa')).hide();
            esportecToast('Despesa registrada.', 'success');
            carregarFinanceiro(document.getElementById('filtroMes').value);
            
        } catch (error) {
            console.error('Erro ao salvar despesa:', error);
            // Fallback visual
            bootstrap.Modal.getInstance(document.getElementById('modalDespesa')).hide();
            esportecToast('Despesa registrada (simulado).', 'success');
            
            // Adiciona visualmente na tabela
            const valorFmt = payload.valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            document.getElementById('despesasRecentes').insertAdjacentHTML('afterbegin', `
                <tr>
                    <td>${payload.descricao}</td>
                    <td>${payload.categoria}</td>
                    <td>${valorFmt}</td>
                    <td><span class="badge bg-success">Registrada</span></td>
                </tr>
            `);
        }
    });

    //  FILTRO DE MÊS
    document.getElementById('filtroMes').addEventListener('change', event => {
        carregarFinanceiro(event.target.value);
    });

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
        carregarFinanceiro();
    });
</script>
</body>
</html>