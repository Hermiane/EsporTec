window.EsporTecApi = {
    token() { return localStorage.getItem('esportec_token'); },
    async request(path, options = {}) {
        const headers = { Accept: 'application/json', ...(options.headers || {}) };
        const token = this.token();
        if (token) headers.Authorization = `Bearer ${token}`;
        if (options.body && !(options.body instanceof FormData)) headers['Content-Type'] = 'application/json';
        const response = await fetch(path, { ...options, headers });
        if (response.status === 401) { localStorage.removeItem('esportec_token'); if (!location.pathname.includes('/login')) location.href = `/login?redirect=${encodeURIComponent(location.pathname)}`; }
        const data = response.status === 204 ? null : await response.json().catch(() => ({}));
        if (!response.ok) throw new Error(data.message || 'Não foi possível concluir a solicitação.');
        return data;
    },
    saveSession(data) {
        localStorage.setItem('esportec_token', data.token);
        localStorage.setItem('esportec_user', JSON.stringify({ ...data.usuario, acessos: data.acessos || {} }));
    },
};

// Compatibilidade para telas antigas que ainda usam fetch() diretamente.
// Apenas requisições para a API local recebem o token da sessão atual.
(() => {
    const fetchOriginal = window.fetch.bind(window);
    window.fetch = (entrada, opcoes = {}) => {
        const url = typeof entrada === 'string' ? entrada : entrada?.url;
        if (!url || !(url.startsWith('/api/') || url.startsWith(`${window.location.origin}/api/`))) return fetchOriginal(entrada, opcoes);
        const headers = new Headers(opcoes.headers || (entrada instanceof Request ? entrada.headers : undefined));
        const token = localStorage.getItem('esportec_token');
        if (token && !headers.has('Authorization')) headers.set('Authorization', `Bearer ${token}`);
        if (!headers.has('Accept')) headers.set('Accept', 'application/json');
        return fetchOriginal(entrada, { ...opcoes, headers });
    };
})();
