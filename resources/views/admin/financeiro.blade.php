<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financeiro - EsporTec Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --admin-dark: #0F172A; --admin-blue: #3B82F6; --success: #10B981; --danger: #EF4444; --warning: #F59E0B; --bg: #F8FAFC; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--admin-dark); color: white; padding: 1.5rem; display: flex; flex-direction: column; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; margin-bottom: 2rem; }
        .nav-link { color: #94A3B8; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; transition: 0.2s; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        
        .main { flex: 1; padding: 2rem; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .header h1 { font-size: 1.6rem; font-weight: 700; color: var(--admin-dark); margin: 0; }
        .badge-admin { background: var(--admin-blue); color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; }
        
        /* KPI Cards */
        .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .kpi-card { background: white; padding: 1.2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); position: relative; overflow: hidden; }
        .kpi-card::after { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; }
        .kpi-entradas::after { background: var(--success); }
        .kpi-saidas::after { background: var(--danger); }
        .kpi-saldo::after { background: var(--admin-blue); }
        .kpi-lucro::after { background: var(--warning); }
        .kpi-label { font-size: 0.85rem; color: #64748B; font-weight: 500; }
        .kpi-value { font-size: 1.8rem; font-weight: 700; margin: 0.5rem 0; }
        .kpi-trend { font-size: 0.8rem; font-weight: 600; }
        .trend-up { color: var(--success); }
        .trend-down { color: var(--danger); }
        
        /* Charts */
        .chart-container { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .chart-title { font-weight: 600; margin-bottom: 1rem; font-size: 1.1rem; }
        
        /* Table */
        .expense-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .expense-table th { text-align: left; padding: 1rem; background: #F1F5F9; color: #64748B; font-weight: 600; font-size: 0.85rem; }
        .expense-table td { padding: 1rem; border-bottom: 1px solid #E2E8F0; vertical-align: middle; }
        .badge-cat { padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
        .cat-salario { background: #DBEAFE; color: #1D4ED8; }
        .cat-manutencao { background: #FEF3C7; color: #B45309; }
        .cat-contas { background: #E0E7FF; color: #3730A3; }
        .cat-outros { background: #F3F4F6; color: #4B5563; }
        
        .btn-primary-admin { background: var(--admin-blue); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-primary-admin:hover { background: #2563EB; }
        
        @media (max-width: 992px) { .sidebar { display: none; } }
    </style>
</head>
<body>

<div class="layout">
    <aside class="sidebar">
        <a href="#" class="sidebar-brand">EsporTec <span style="font-size:0.7rem; opacity:0.6;">ADMIN</span></a>
        <nav>
          <a href="/admin/agendamentos" class="nav-link"><i class="bi bi-calendar-check"></i> Agendamentos</a>
          <a href="/admin/financeiro" class="nav-link active"><i class="bi bi-cash-stack"></i> Financeiro</a>
          <a href="/admin/pessoas" class="nav-link"><i class="bi bi-people"></i> Usuários</a>
          <a href="/admin/clientes" class="nav-link"><i class="bi bi-person-check"></i> Clientes</a>
      </nav>
        <div style="margin-top: auto;">
            <a href="/" class="nav-link"><i class="bi bi-box-arrow-left"></i> Sair</a>
        </div>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1>Módulo Financeiro</h1>
                <p class="text-muted mb-0">Controle de entradas e saídas da arena</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <input type="month" class="form-control" value="2026-06" style="width: 140px;">
                <button class="btn-primary-admin" data-bs-toggle="modal" data-bs-target="#modalDespesa">
                    <i class="bi bi-plus-lg me-2"></i>Nova Despesa
                </button>
                <span class="badge-admin">Super Admin</span>
            </div>
        </div>

        <!-- KPIs -->
        <div class="kpi-grid">
            <div class="kpi-card kpi-entradas">
                <div class="kpi-label">💰 Entradas (Pagamentos)</div>
                <div class="kpi-value">R$ 4.850,00</div>
                <div class="kpi-trend trend-up"><i class="bi bi-arrow-up-short"></i> +12% vs mês anterior</div>
            </div>
            <div class="kpi-card kpi-saidas">
                <div class="kpi-label">📉 Saídas (Despesas)</div>
                <div class="kpi-value">R$ 1.240,00</div>
                <div class="kpi-trend trend-down"><i class="bi bi-arrow-down-short"></i> -5% vs mês anterior</div>
            </div>
            <div class="kpi-card kpi-saldo">
                <div class="kpi-label">📊 Saldo Líquido</div>
                <div class="kpi-value" style="color: var(--success);">R$ 3.610,00</div>
                <div class="kpi-trend" style="color: #64748B;">Margem: 74%</div>
            </div>
            <div class="kpi-card kpi-lucro">
                <div class="kpi-label">🏆 Melhor Semana</div>
                <div class="kpi-value">Semana 3</div>
                <div class="kpi-trend trend-up">Maior entrada: R$ 1.600</div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="chart-container">
                    <div class="chart-title">📈 Entradas vs Saídas por Semana</div>
                    <canvas id="chartSemanas" height="120"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="chart-container">
                    <div class="chart-title">🍩 Despesas por Categoria</div>
                    <canvas id="chartCategorias" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabela de Despesas Recentes -->
        <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="chart-title mb-0">📋 Últimas Despesas Registradas</div>
                <a href="#" class="text-decoration-none small fw-semibold" style="color: var(--admin-blue)">Ver relatório completo</a>
            </div>
            <div class="table-responsive">
                <table class="expense-table">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Recorrente</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">Salário Equipe - Junho</td>
                            <td><span class="badge-cat cat-salario">Salário</span></td>
                            <td class="fw-bold">R$ 600,00</td>
                            <td>05/06/2026</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">Mensal</span></td>
                            <td><span class="text-success"><i class="bi bi-check-circle me-1"></i>Pago</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Conta de Luz e Internet</td>
                            <td><span class="badge-cat cat-contas">Contas</span></td>
                            <td class="fw-bold">R$ 340,00</td>
                            <td>08/06/2026</td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">Mensal</span></td>
                            <td><span class="text-success"><i class="bi bi-check-circle me-1"></i>Pago</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Reparo Iluminação Quadra 2</td>
                            <td><span class="badge-cat cat-manutencao">Manutenção</span></td>
                            <td class="fw-bold">R$ 200,00</td>
                            <td>10/06/2026</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Não</span></td>
                            <td><span class="text-warning"><i class="bi bi-clock me-1"></i>Pendente</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Compra Bolas e Cones</td>
                            <td><span class="badge-cat cat-outros">Equipamento</span></td>
                            <td class="fw-bold">R$ 100,00</td>
                            <td>12/06/2026</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Não</span></td>
                            <td><span class="text-success"><i class="bi bi-check-circle me-1"></i>Pago</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modal Nova Despesa -->
<div class="modal fade" id="modalDespesa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Registrar Nova Despesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formDespesa">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Descrição</label>
                        <input type="text" class="form-control" placeholder="Ex: Conta de água" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-medium">Categoria</label>
                            <select class="form-select" required>
                                <option value="salario">Salário</option>
                                <option value="manutencao">Manutenção</option>
                                <option value="conta">Contas</option>
                                <option value="equipamento">Equipamento</option>
                                <option value="marketing">Marketing</option>
                                <option value="aluguel">Aluguel</option>
                                <option value="imposto">Imposto</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium">Valor (R$)</label>
                            <input type="number" step="0.01" class="form-control" placeholder="0,00" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-medium">Data</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium">Recorrente?</label>
                            <select class="form-select">
                                <option value="nao">Não</option>
                                <option value="mensal">Mensal</option>
                                <option value="anual">Anual</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Comprovante (Opcional)</label>
                        <input type="file" class="form-control" accept="image/*,.pdf">
                        <small class="text-muted">Nota fiscal, recibo ou boleto</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-primary-admin" onclick="salvarDespesa()">Salvar Despesa</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Gráfico de Semanas (Entradas vs Saídas)
    new Chart(document.getElementById('chartSemanas'), {
        type: 'bar',
        data: {
            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
            datasets: [
                { label: 'Entradas', data: [1200, 800, 1600, 1250], backgroundColor: '#10B981', borderRadius: 6 },
                { label: 'Saídas', data: [300, 200, 400, 340], backgroundColor: '#EF4444', borderRadius: 6 }
            ]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } } }
    });

    // Gráfico de Categorias
    new Chart(document.getElementById('chartCategorias'), {
        type: 'doughnut',
        data: {
            labels: ['Salários', 'Contas', 'Manutenção', 'Outros'],
            datasets: [{ data: [600, 340, 200, 100], backgroundColor: ['#3B82F6', '#8B5CF6', '#F59E0B', '#94A3B8'], borderWidth: 0 }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
    });

    function salvarDespesa() {
        alert('✅ Despesa registrada com sucesso! (Dados simulados para frontend)');
        bootstrap.Modal.getInstance(document.getElementById('modalDespesa')).hide();
    }
</script>
</body>
</html>