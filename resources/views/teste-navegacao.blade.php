<!DOCTYPE html>
<html>
<head>
    <title>EsporTec - Menu de Testes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">🎯 EsporTec - Menu de Testes</h1>
        <p class="lead mb-4">Selecione um perfil para navegar:</p>
        
        <div class="row g-4">
            <!-- Área Pública -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title">🌐 Área Pública</h3>
                        <a href="/" class="btn btn-outline-primary w-100 mb-2">Landing Page</a>
                        <a href="/login" class="btn btn-outline-primary w-100 mb-2">Login</a>
                        <a href="/criar-conta" class="btn btn-outline-primary w-100 mb-2">Cadastro</a>
                        <a href="/detalhes-quadra" class="btn btn-outline-primary w-100">Detalhes da Quadra</a>
                    </div>
                </div>
            </div>

            <!-- Área do Cliente -->
            <div class="col-md-4">
                <div class="card h-100 border-success">
                    <div class="card-body">
                        <h3 class="card-title text-success">👤 Cliente</h3>
                        <a href="/painel" class="btn btn-success w-100 mb-2">Painel do Cliente</a>
                        <a href="/nova-reserva" class="btn btn-outline-success w-100 mb-2">Nova Reserva</a>
                        <a href="/minhas-reservas" class="btn btn-outline-success w-100 mb-2">Minhas Reservas</a>
                        <a href="/notificacoes" class="btn btn-outline-success w-100 mb-2">Notificações</a>
                        <a href="/perfil" class="btn btn-outline-success w-100">Perfil</a>
                    </div>
                </div>
            </div>

            <!-- Área do Funcionário -->

            
            <div class="col-md-4">
                <div class="card h-100 border-primary">
                    <div class="card-body">
                        <h3 class="card-title text-primary">👨‍ Funcionário</h3>
                        <a href="/painel-funcionario" class="btn btn-primary w-100 mb-2">Agenda Operacional</a>
                    </div>
                </div>
            </div>

            <!-- Área do Admin -->
            <div class="col-md-12">
                <div class="card border-danger">
                    <div class="card-body">
                        <h3 class="card-title text-danger">👑 Administrador</h3>
                        <div class="row g-2">
                            <div class="col-md-2"><a href="/admin/dashboard" class="btn btn-outline-danger w-100">Dashboard</a></div>
                            <div class="col-md-2"><a href="/admin/agendamentos" class="btn btn-outline-danger w-100">Agendamentos</a></div>
                            <div class="col-md-2"><a href="/admin/financeiro" class="btn btn-outline-danger w-100">Financeiro</a></div>
                            <div class="col-md-2"><a href="/admin/pessoas" class="btn btn-outline-danger w-100">Usuários</a></div>
                            <div class="col-md-2"><a href="/admin/clientes" class="btn btn-outline-danger w-100">Clientes</a></div>
                            <div class="col-md-2"><a href="/admin/configuracoes" class="btn btn-outline-danger w-100">Configurações</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-4">
            <strong>💡 Dica:</strong> Quando o backend estiver pronto, você fará login e será redirecionado automaticamente!
        </div>
    </div>
</body>
</html>