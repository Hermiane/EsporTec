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
})();
