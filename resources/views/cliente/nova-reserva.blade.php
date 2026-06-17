<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Reserva - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; --bg: #F8FAFC; --gray: #64748B; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        
        .container-reserva { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
        .header-reserva { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
        .btn-back { width: 40px; height: 40px; border-radius: 10px; background: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .btn-back:hover { background: var(--light); }
        
        /* Barra de Progresso */
        .progress-bar-custom { display: flex; justify-content: space-between; margin-bottom: 2.5rem; position: relative; }
        .progress-bar-custom::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 3px; background: #E2E8F0; transform: translateY(-50%); z-index: 0; }
        .progress-step { width: 40px; height: 40px; border-radius: 50%; background: white; border: 3px solid #E2E8F0; display: flex; align-items: center; justify-content: center; font-weight: 600; position: relative; z-index: 1; transition: all 0.3s; }
        .progress-step.active { border-color: var(--primary); background: var(--primary); color: white; transform: scale(1.1); }
        .progress-step.completed { border-color: var(--primary); background: var(--light); color: var(--primary); }
        .step-label { position: absolute; top: 45px; left: 50%; transform: translateX(-50%); font-size: 0.75rem; font-weight: 500; color: var(--gray); white-space: nowrap; }
        .progress-step.active .step-label { color: var(--primary); font-weight: 600; }
        
        /* Cards de Etapa */
        .step-content { display: none; animation: fadeIn 0.4s; }
        .step-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .card-step { background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 1.5rem; }
        .form-control, .form-select { border-radius: 10px; padding: 0.8rem; border: 1px solid #E2E8F0; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(45,129,93,0.15); }
        
        /* Grade de Horários */
        .time-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); gap: 0.8rem; margin-top: 1rem; }
        .time-slot { padding: 0.8rem; border-radius: 8px; text-align: center; font-weight: 500; cursor: pointer; border: 2px solid transparent; transition: all 0.2s; }
        .time-available { background: var(--light); color: var(--primary); border-color: var(--light); }
        .time-available:hover { background: var(--primary); color: white; }
        .time-selected { background: var(--primary); color: white; border-color: var(--dark); transform: scale(1.05); }
        .time-busy { background: #F1F5F9; color: #94A3B8; cursor: not-allowed; }
        
        /* PIX e QR Code */
        .pix-container { text-align: center; padding: 1.5rem; background: #F8FAFC; border-radius: 12px; border: 2px dashed #CBD5E1; }
        .qr-code { width: 180px; height: 180px; background: white; margin: 1rem auto; display: flex; align-items: center; justify-content: center; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .pix-code { background: white; padding: 0.8rem; border-radius: 8px; font-family: monospace; word-break: break-all; margin: 1rem 0; border: 1px solid #E2E8F0; }
        .btn-copy { background: var(--primary); color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-copy:hover { background: var(--dark); }
        
        /* Navegação */
        .nav-buttons { display: flex; justify-content: space-between; margin-top: 2rem; }
        .btn-nav { padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; }
        .btn-prev { background: #F1F5F9; color: var(--gray); }
        .btn-prev:hover { background: #E2E8F0; }
        .btn-next { background: var(--primary); color: white; }
        .btn-next:hover { background: var(--dark); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(45,129,93,0.3); }
        .btn-next:disabled { background: #CBD5E1; cursor: not-allowed; transform: none; box-shadow: none; }
        
        .total-box { background: var(--light); padding: 1.2rem; border-radius: 12px; margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        .total-price { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
        
        @media (max-width: 768px) {
            .progress-bar-custom { margin-bottom: 3.5rem; }
            .step-label { font-size: 0.65rem; }
            .time-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>

<div class="container-reserva">
    <!-- Cabeçalho -->
    <div class="header-reserva">
        <a href="/painel" class="btn-back"><i class="bi bi-arrow-left"></i></a>
        <h2 class="fw-bold mb-0">Nova Reserva</h2>
    </div>

    <!-- Barra de Progresso -->
    <div class="progress-bar-custom">
        <div class="progress-step active" data-step="1">1<span class="step-label">Quadra</span></div>
        <div class="progress-step" data-step="2">2<span class="step-label">Data/Hora</span></div>
        <div class="progress-step" data-step="3">3<span class="step-label">Jogadores</span></div>
        <div class="progress-step" data-step="4">4<span class="step-label">Pagamento</span></div>
    </div>

    <!-- Passo 1: Escolha da Quadra -->
    <div class="step-content active" id="step-1">
        <div class="card-step">
            <h4 class="fw-bold mb-3">Escolha a Quadra</h4>
            <div class="mb-3">
                <label class="form-label fw-medium">Tipo de Modalidade</label>
                <select class="form-select" id="modalidade">
                    <option value="futsal">Futsal</option>
                    <option value="society">Society</option>
                    <option value="beach">Beach Tennis</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Selecione a Quadra</label>
                <select class="form-select" id="quadra">
                    <option value="futsal-arena" data-price="120">Quadra Futsal Arena (R$ 120/h)</option>
                    <option value="society-premium" data-price="150">Quadra Society Premium (R$ 150/h)</option>
                    <option value="beach-1" data-price="100">Beach Tennis #1 (R$ 100/h)</option>
                </select>
            </div>
            <div class="alert" style="background: var(--light); color: var(--primary); border-radius: 10px;">
                <i class="bi bi-info-circle me-2"></i> Valor por hora: <strong id="preco-hora">R$ 120,00</strong>
            </div>
        </div>
        <div class="nav-buttons">
            <div></div>
            <button class="btn-nav btn-next" onclick="nextStep(2)">Próximo <i class="bi bi-arrow-right ms-2"></i></button>
        </div>
    </div>

    <!-- Passo 2: Data e Horário -->
    <div class="step-content" id="step-2">
        <div class="card-step">
            <h4 class="fw-bold mb-3">Escolha Data e Horário</h4>
            <div class="mb-3">
                <label class="form-label fw-medium">Data</label>
                <input type="date" class="form-control" id="data-reserva">
            </div>
            <label class="form-label fw-medium">Horários Disponíveis</label>
            <div class="time-grid" id="grade-horarios">
                <!-- Gerado via JS -->
            </div>
            <div class="total-box">
                <span class="fw-semibold">Tempo Selecionado</span>
                <span class="total-price" id="tempo-total">0h</span>
            </div>
            <div class="total-box mt-2" style="background: white; border: 2px solid var(--primary);">
                <span class="fw-bold">Valor Total</span>
                <span class="total-price" id="valor-total">R$ 0,00</span>
            </div>
        </div>
        <div class="nav-buttons">
            <button class="btn-nav btn-prev" onclick="prevStep(1)"><i class="bi bi-arrow-left me-2"></i> Voltar</button>
            <button class="btn-nav btn-next" id="btn-step-2" disabled onclick="nextStep(3)">Próximo <i class="bi bi-arrow-right ms-2"></i></button>
        </div>
    </div>

    <!-- Passo 3: Dados dos Jogadores -->
    <div class="step-content" id="step-3">
        <div class="card-step">
            <h4 class="fw-bold mb-3">Dados dos Jogadores</h4>
            <div class="mb-3">
                <label class="form-label fw-medium">Nome do Responsável</label>
                <input type="text" class="form-control" placeholder="Seu nome completo">
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Telefone para Contato</label>
                <input type="tel" class="form-control" placeholder="(00) 00000-0000">
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Quantidade de Jogadores</label>
                <select class="form-select">
                    <option>10 jogadores</option>
                    <option>12 jogadores</option>
                    <option>14 jogadores</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Observações (opcional)</label>
                <textarea class="form-control" rows="3" placeholder="Ex: Precisamos de bolas extras..."></textarea>
            </div>
        </div>
        <div class="nav-buttons">
            <button class="btn-nav btn-prev" onclick="prevStep(2)"><i class="bi bi-arrow-left me-2"></i> Voltar</button>
            <button class="btn-nav btn-next" onclick="nextStep(4)">Ir para Pagamento <i class="bi bi-arrow-right ms-2"></i></button>
        </div>
    </div>

    <!-- Passo 4: Pagamento PIX -->
    <div class="step-content" id="step-4">
        <div class="card-step">
            <h4 class="fw-bold mb-3">Pagamento via PIX</h4>
            <div class="pix-container">
                <p class="fw-semibold mb-2">Escaneie o QR Code ou copie o código</p>
                <div class="qr-code">
                    <i class="bi bi-qr-code" style="font-size: 4rem; color: var(--primary);"></i>
                </div>
                <div class="pix-code" id="pix-code">00020126580014BR.GOV.BCB.PIX0136a1b2c3d4-e5f6-7890-abcd-ef12345678905204000053039865406120.005802BR5913ESPORTEC LTDA6009SAO PAULO62070503***63041D3F</div>
                <button class="btn-copy" onclick="copiarPix()"><i class="bi bi-clipboard me-2"></i>Copiar Código PIX</button>
            </div>
            <div class="mt-4">
                <label class="form-label fw-medium">Enviar Comprovante (opcional)</label>
                <input type="file" class="form-control" accept="image/*,.pdf">
                <small class="text-muted">Envie o comprovante para agilizar a confirmação</small>
            </div>
            <div class="alert" style="background: var(--light); color: var(--primary); border-radius: 10px; margin-top: 1.5rem;">
                <i class="bi bi-shield-check me-2"></i> Sua reserva será confirmada em até <strong>15 minutos</strong> após o pagamento.
            </div>
        </div>
        <div class="nav-buttons">
            <button class="btn-nav btn-prev" onclick="prevStep(3)"><i class="bi bi-arrow-left me-2"></i> Voltar</button>
            <button class="btn-nav btn-next" style="background: #10B981;" onclick="finalizarReserva()">✅ Confirmar Reserva</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let currentStep = 1;
    let selectedSlots = [];
    let pricePerHour = 120;

    // Atualizar preço ao mudar quadra
    document.getElementById('quadra').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        pricePerHour = parseInt(selected.getAttribute('data-price'));
        document.getElementById('preco-hora').textContent = `R$ ${pricePerHour},00`;
        updateTotal();
    });

    // Gerar grade de horários
    function generateTimeGrid() {
        const grid = document.getElementById('grade-horarios');
        grid.innerHTML = '';
        const hours = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'];
        
        hours.forEach(hour => {
            const slot = document.createElement('div');
            slot.className = 'time-slot time-available';
            slot.textContent = hour;
            slot.onclick = () => toggleSlot(slot, hour);
            
            // Simular horários ocupados aleatoriamente
            if (Math.random() > 0.7) {
                slot.className = 'time-slot time-busy';
                slot.onclick = null;
            }
            grid.appendChild(slot);
        });
    }
    generateTimeGrid();

    // Selecionar/Desselecionar horário
    function toggleSlot(element, hour) {
        if (element.classList.contains('time-selected')) {
            element.classList.remove('time-selected');
            element.classList.add('time-available');
            selectedSlots = selectedSlots.filter(h => h !== hour);
        } else {
            element.classList.remove('time-available');
            element.classList.add('time-selected');
            selectedSlots.push(hour);
        }
        updateTotal();
    }

    // Calcular total
    function updateTotal() {
        const hours = selectedSlots.length;
        const total = hours * pricePerHour;
        document.getElementById('tempo-total').textContent = `${hours}h`;
        document.getElementById('valor-total').textContent = `R$ ${total},00`;
        document.getElementById('btn-step-2').disabled = hours === 0;
    }

    // Navegação entre passos
    function nextStep(step) {
        document.getElementById(`step-${currentStep}`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.add('completed');
        
        currentStep = step;
        document.getElementById(`step-${currentStep}`).classList.add('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.add('active');
    }

    function prevStep(step) {
        document.getElementById(`step-${currentStep}`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.remove('active');
        
        currentStep = step;
        document.getElementById(`step-${currentStep}`).classList.add('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.add('active');
        document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.remove('completed');
    }

    // Copiar PIX
    function copiarPix() {
        const code = document.getElementById('pix-code').textContent;
        navigator.clipboard.writeText(code).then(() => {
            alert('✅ Código PIX copiado!');
        });
    }

    // Finalizar
    function finalizarReserva() {
        if (confirm('Deseja realmente confirmar esta reserva?')) {
            alert('🎉 Reserva realizada com sucesso! Você receberá um e-mail de confirmação.');
            setTimeout(() => window.location.href = '/painel', 1500);
        }
    }

    // Definir data mínima como hoje
    document.getElementById('data-reserva').valueAsDate = new Date();
</script>
</body>
</html>