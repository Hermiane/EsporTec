<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações - EsporTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2D815D; --dark: #1F5C42; --light: #E8F5EE; --bg: #F8FAFC; --gray: #64748B; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: #334155; margin: 0; }
        .container-notificacoes { max-width: 700px; margin: 2rem auto; padding: 0 1rem; }
        .header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
        .btn-back { width: 40px; height: 40px; border-radius: 10px; background: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-decoration: none; color: inherit; }
        .btn-back:hover { background: var(--light); }
        
        .notification-card { background: white; border-radius: 12px; padding: 1.2rem; margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.04); display: flex; gap: 1rem; align-items: flex-start; position: relative; transition: all 0.2s; }
        .notification-card:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .notification-card.unread { border-left: 4px solid var(--primary); }
        
        .notification-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
        .icon-aniversario { background: rgba(233, 30, 99, 0.15); color: #E91E63; }
        .icon-oferta { background: rgba(249, 168, 37, 0.15); color: #F9A825; }
        .icon-aviso { background: rgba(244, 67, 54, 0.15); color: #F44336; }
        .icon-confirmacao { background: rgba(45, 129, 93, 0.15); color: var(--primary); }
        
        .notification-content { flex: 1; min-width: 0; }
        .notification-title { font-weight: 600; margin-bottom: 0.3rem; font-size: 1rem; }
        .notification-text { color: var(--gray); font-size: 0.9rem; margin-bottom: 0.5rem; line-height: 1.4; }
        .notification-time { font-size: 0.75rem; color: #94A3B8; }
        
        .notification-actions { display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end; }
        .btn-mark-read { background: transparent; border: 1px solid #E2E8F0; color: var(--gray); padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem; cursor: pointer; transition: all 0.2s; }
        .btn-mark-read:hover { background: var(--light); color: var(--primary); border-color: var(--primary); }
        
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--gray); }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.3; }
        
        .badge-new { position: absolute; top: 1rem; right: 1rem; width: 8px; height: 8px; background: var(--primary); border-radius: 50%; }
        
        @media (max-width: 576px) {
            .notification-actions { flex-direction: row; align-items: center; }
            .btn-mark-read { padding: 0.3rem 0.6rem; font-size: 0.75rem; }
        }
    </style>
</head>
<body>

<div class="container-notificacoes">
    <div class="header">
        <a href="/painel" class="btn-back"><i class="bi bi-arrow-left"></i></a>
        <h2 class="fw-bold mb-0">Notificações</h2>
    </div>

    <!-- Notificação: Aniversário -->
    <div class="notification-card unread">
        <span class="badge-new"></span>
        <div class="notification-icon icon-aniversario">
            <i class="bi bi-balloon-heart"></i>
        </div>
        <div class="notification-content">
            <div class="notification-title">🎂 Feliz aniversário!</div>
            <div class="notification-text">Hoje é seu dia! Que tal comemorar com uma partida? Ganhe 10% de desconto na sua próxima reserva.</div>
            <div class="notification-time">Hoje, 08:00</div>
        </div>
        <div class="notification-actions">
            <button class="btn-mark-read" onclick="marcarComoLida(this)">Marcar como lida</button>
        </div>
    </div>

    <!-- Notificação: Oferta -->
    <div class="notification-card unread">
        <span class="badge-new"></span>
        <div class="notification-icon icon-oferta">
            <i class="bi bi-gift"></i>
        </div>
        <div class="notification-content">
            <div class="notification-title">🎁 Oferta especial!</div>
            <div class="notification-text">Reserve a Quadra Society Premium às terças e quintas e ganhe 15% de desconto. Válido até 30/06.</div>
            <div class="notification-time">Ontem, 14:30</div>
        </div>
        <div class="notification-actions">
            <button class="btn-mark-read" onclick="marcarComoLida(this)">Marcar como lida</button>
        </div>
    </div>

    <!-- Notificação: Aviso -->
    <div class="notification-card">
        <div class="notification-icon icon-aviso">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <div class="notification-content">
            <div class="notification-title">⚠️ Aviso de manutenção</div>
            <div class="notification-text">A Quadra Futsal Arena passará por manutenção preventiva no dia 20/06 das 08:00 às 12:00. Agende em outro horário.</div>
            <div class="notification-time">12/06, 10:15</div>
        </div>
        <div class="notification-actions">
            <button class="btn-mark-read" onclick="marcarComoLida(this)" disabled style="opacity: 0.5;">Lida</button>
        </div>
    </div>

    <!-- Notificação: Confirmação -->
    <div class="notification-card">
        <div class="notification-icon icon-confirmacao">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="notification-content">
            <div class="notification-title">✅ Reserva confirmada</div>
            <div class="notification-text">Sua reserva na Quadra Society Premium para 14/06 às 19:00 foi confirmada. Chegue com 10 minutos de antecedência.</div>
            <div class="notification-time">10/06, 16:45</div>
        </div>
        <div class="notification-actions">
            <button class="btn-mark-read" onclick="marcarComoLida(this)" disabled style="opacity: 0.5;">Lida</button>
        </div>
    </div>

    <!-- Estado vazio (oculto por padrão) -->
    <div class="empty-state" id="empty-state" style="display: none;">
        <i class="bi bi-bell-slash"></i>
        <p class="fw-medium">Nenhuma notificação nova</p>
        <small class="text-muted">Quando houver novidades, elas aparecerão aqui.</small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function marcarComoLida(btn) {
        const card = btn.closest('.notification-card');
        card.classList.remove('unread');
        btn.textContent = 'Lida';
        btn.disabled = true;
        btn.style.opacity = '0.5';
        
        // Remove o badge "novo"
        const badge = card.querySelector('.badge-new');
        if (badge) badge.remove();
        
        // Verifica se todas foram lidas
        const unread = document.querySelectorAll('.notification-card.unread');
        if (unread.length === 0) {
            // Opcional: mostrar estado vazio se quiser
        }
    }
</script>
</body>
</html>