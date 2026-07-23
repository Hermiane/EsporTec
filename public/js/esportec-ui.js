(function () {
    function ensureToastContainer() {
        let container = document.getElementById('esportecToastContainer');
        if (container) {
            return container;
        }

        container = document.createElement('div');
        container.id = 'esportecToastContainer';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '2000';
        document.body.appendChild(container);
        return container;
    }

    window.esportecToast = function esportecToast(message, type = 'success') {
        const container = ensureToastContainer();
        const palette = {
            success: 'text-bg-success',
            warning: 'text-bg-warning',
            danger: 'text-bg-danger',
            info: 'text-bg-primary'
        };
        const toast = document.createElement('div');
        toast.className = `toast align-items-center border-0 ${palette[type] || palette.success}`;
        toast.setAttribute('role', 'status');
        toast.setAttribute('aria-live', 'polite');
        toast.setAttribute('aria-atomic', 'true');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
            </div>
        `;
        container.appendChild(toast);
        bootstrap.Toast.getOrCreateInstance(toast, { delay: 2800 }).show();
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    };

    window.alert = function esportecAlert(message) {
        window.esportecToast(String(message), 'info');
    };

    window.esportecMockApi = function esportecMockApi(action, payload = {}) {
        // Futuro backend: trocar este helper por fetch/axios mantendo action + payload.
        return new Promise(resolve => {
            setTimeout(() => resolve({ ok: true, action, payload }), 450);
        });
    };

    window.esportecWithLoading = function esportecWithLoading(button, label, callback) {
        if (!button) {
            return callback();
        }

        const original = button.innerHTML;
        button.disabled = true;
        button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>${label}`;

        return Promise.resolve(callback())
            .finally(() => {
                button.disabled = false;
                button.innerHTML = original;
            });
    };

    function configurarBotaoVoltar() {
        const path = window.location.pathname;
        const paginasIniciais = ['/', '/painel', '/admin/dashboard', '/painel-funcionario', '/super-admin/dashboard'];
        const paginaInterna =
            path.startsWith('/admin/') ||
            path.startsWith('/funcionario/') ||
            ['/nova-reserva', '/minhas-reservas', '/notificacoes', '/perfil'].includes(path) ||
            path.startsWith('/partida/');

        if (!paginaInterna || paginasIniciais.includes(path)) {
            return;
        }

        const role = sessionStorage.getItem('esportecRole');
        const destinoPadrao = path.startsWith('/partida/') && role === 'cliente'
            ? '/minhas-reservas'
            : path.startsWith('/admin/')
                ? '/admin/dashboard'
                : path.startsWith('/funcionario/')
                    ? '/painel-funcionario'
                    : '/painel';

        const voltar = event => {
            event.preventDefault();
            const origem = document.referrer;
            let origemDoSistema = false;
            try {
                origemDoSistema = Boolean(origem) && new URL(origem).origin === window.location.origin;
            } catch (_) {
                origemDoSistema = false;
            }

            if (origemDoSistema && window.history.length > 1) {
                window.history.back();
                return;
            }
            window.location.href = destinoPadrao;
        };

        const existente = document.querySelector('.btn-back, [data-esportec-voltar]');
        if (existente) {
            existente.setAttribute('aria-label', 'Voltar para a página anterior');
            existente.addEventListener('click', voltar);
            return;
        }

        const estilo = document.createElement('style');
        estilo.textContent = `
            .esportec-btn-voltar {
                position: fixed;
                right: 20px;
                bottom: 20px;
                z-index: 1080;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 11px 17px;
                border: 0;
                border-radius: 999px;
                background: #1f5c42;
                color: #fff;
                font: 600 14px/1.2 Poppins, sans-serif;
                box-shadow: 0 6px 20px rgba(15, 23, 42, .24);
                cursor: pointer;
            }
            .esportec-btn-voltar:hover { background: #174733; }
            .esportec-btn-voltar:focus-visible { outline: 3px solid rgba(45, 129, 93, .35); outline-offset: 3px; }
            @media (max-width: 576px) {
                .esportec-btn-voltar { right: 14px; bottom: 14px; }
            }
        `;
        document.head.appendChild(estilo);

        const botao = document.createElement('button');
        botao.type = 'button';
        botao.className = 'esportec-btn-voltar';
        botao.setAttribute('aria-label', 'Voltar para a página anterior');
        botao.innerHTML = '<span aria-hidden="true">←</span> Voltar';
        botao.addEventListener('click', voltar);
        document.body.appendChild(botao);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', configurarBotaoVoltar);
    } else {
        configurarBotaoVoltar();
    }

    document.addEventListener('click', event => {
        const logoutLink = event.target.closest('a');
        if (logoutLink && logoutLink.textContent.trim().toLowerCase().includes('sair')) {
            sessionStorage.removeItem('esportecRole');
        }
    });

    const publicRoutes = ['/', '/login', '/criar-conta', '/recuperar-senha', '/detalhes-quadra', '/cadastrar-arena', '/teste'];
    const path = window.location.pathname;
    const isPublic = publicRoutes.includes(path) || path.startsWith('/partida');
    const isSuperAdmin = path.startsWith('/super-admin');
    const isAdmin = path.startsWith('/admin');
    const isPlatformLog = path === '/admin/logs';
    const isStaff = path.startsWith('/funcionario') || path === '/painel-funcionario';
    const isClient = ['/painel', '/nova-reserva', '/minhas-reservas', '/notificacoes', '/perfil'].includes(path);

    if (!isPublic && (isSuperAdmin || isAdmin || isStaff || isClient)) {
        const role = sessionStorage.getItem('esportecRole');
        const allowed =
            (isPlatformLog && role === 'super_admin') ||
            (isSuperAdmin && role === 'super_admin') ||
            (isAdmin && !isPlatformLog && role === 'admin') ||
            (isStaff && role === 'funcionario') ||
            (isClient && role === 'cliente');

        if (!role) {
            window.location.href = `/login?redirect=${encodeURIComponent(path)}`;
            return;
        }

        if (!allowed) {
            window.location.href = role === 'super_admin' ? '/super-admin/dashboard' : role === 'admin' ? '/admin/dashboard' : role === 'funcionario' ? '/painel-funcionario' : '/painel';
        }
    }
})();
