(() => {
    const API_BASE = '/api';
    const hoje = new Date().toISOString().slice(0, 10);
    let visao = 'dia';
    let reservas = [];
    let quadras = [];

    const escapar = valor => String(valor ?? '').replace(/[&<>'"]/g, caractere => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;',
    })[caractere]);
    const dataReserva = reserva => String(reserva.data || '').slice(0, 10);
    const hora = valor => String(valor || '').slice(0, 5);
    const formatarData = valor => valor ? new Date(`${String(valor).slice(0, 10)}T00:00:00`).toLocaleDateString('pt-BR') : '-';
    const formatarMetodo = metodo => ({ pix: 'PIX', dinheiro: 'Dinheiro', cartao_credito: 'Cartão', cartao_debito: 'Débito' })[metodo] || metodo || '-';

    async function carregarAgenda() {
        try {
            const data = document.getElementById('dataSelecionada').value || hoje;
            const [painel, agenda] = await Promise.all([
                EsporTecApi.request(`${API_BASE}/funcionario/painel`),
                EsporTecApi.request(`${API_BASE}/funcionario/agenda/${visao}?data=${encodeURIComponent(data)}`),
            ]);
            quadras = painel.quadras;
            reservas = agenda;
            renderizarGrade();
            atualizarResumo();
        } catch (error) {
            quadras = [];
            reservas = [];
            renderizarGrade();
            atualizarResumo();
            esportecToast(error.message, 'warning');
        }
    }

    function renderizarGrade() {
        const grid = document.getElementById('agendaGrid');
        grid.style.gridTemplateColumns = `120px repeat(${Math.max(quadras.length, 1)}, minmax(180px, 1fr))`;
        grid.innerHTML = `<div class="cell head">${visao === 'semana' ? 'Data/Horário' : 'Horário'}</div>`;

        if (!quadras.length) {
            grid.innerHTML += '<div class="cell busy">Nenhuma quadra ativa</div>';
            return;
        }

        grid.innerHTML += quadras.map(quadra => `<div class="cell head">${escapar(quadra.nome)}</div>`).join('');
        const chaves = [...new Set(reservas.map(reserva => `${dataReserva(reserva)}|${hora(reserva.hora_inicio)}`))].sort();
        if (!chaves.length) {
            grid.innerHTML += `<div class="cell hour">-</div><div class="cell busy" style="grid-column:span ${quadras.length}">Nenhuma reserva no período.</div>`;
            return;
        }

        chaves.forEach(chave => {
            const [data, horario] = chave.split('|');
            grid.innerHTML += `<div class="cell hour">${visao === 'semana' ? `${formatarData(data)}<br>` : ''}${horario}</div>`;
            quadras.forEach(quadra => {
                const reserva = reservas.find(item => item.quadra?.id === quadra.id && dataReserva(item) === data && hora(item.hora_inicio) === horario);
                if (!reserva) {
                    grid.innerHTML += '<div class="cell busy">Livre</div>';
                    return;
                }
                const classe = reserva.status === 'cancelada' ? 'cancelled' : (reserva.status === 'pendente' ? 'pending' : 'confirmed');
                const pagamento = reserva.pagamento?.status === 'pago' ? `Pago (${formatarMetodo(reserva.pagamento.metodo)})` : (reserva.pagamento ? `${formatarMetodo(reserva.pagamento.metodo)} pendente` : 'Sem pagamento');
                grid.innerHTML += `<div class="cell"><button type="button" class="booking ${classe} border-0 w-100 text-start" data-reserva-id="${reserva.id}"><strong>${escapar(reserva.usuario?.nome_completo || 'Cliente')}</strong><br><small>${escapar(pagamento)}</small></button></div>`;
            });
        });
    }

    function atualizarResumo() {
        const reservasHoje = reservas.filter(reserva => dataReserva(reserva) === hoje);
        const pendentes = reservasHoje.filter(reserva => reserva.pagamento?.status === 'pendente');
        const horarioAtual = new Date().toTimeString().slice(0, 5);
        const proxima = reservasHoje.filter(reserva => reserva.status !== 'cancelada' && hora(reserva.hora_inicio) >= horarioAtual).sort((a, b) => hora(a.hora_inicio).localeCompare(hora(b.hora_inicio)))[0];
        document.getElementById('countReservas').textContent = reservasHoje.length;
        document.getElementById('countPendentes').textContent = pendentes.length;
        document.getElementById('countQuadras').textContent = quadras.length;
        document.getElementById('proximaReserva').textContent = proxima ? hora(proxima.hora_inicio) : '-';

        const alertas = document.getElementById('alertasDia');
        const itens = [];
        if (pendentes.length) itens.push(`<div class="list-group-item px-0"><i class="bi bi-exclamation-triangle text-warning me-2"></i>${pendentes.length} pagamento${pendentes.length > 1 ? 's' : ''} pendente${pendentes.length > 1 ? 's' : ''} hoje.</div>`);
        const canceladas = reservasHoje.filter(reserva => reserva.status === 'cancelada').length;
        if (canceladas) itens.push(`<div class="list-group-item px-0"><i class="bi bi-x-circle text-danger me-2"></i>${canceladas} reserva${canceladas > 1 ? 's' : ''} cancelada${canceladas > 1 ? 's' : ''} hoje.</div>`);
        alertas.innerHTML = itens.join('') || '<div class="list-group-item px-0 text-muted"><i class="bi bi-check-circle me-2"></i>Nenhum alerta real para hoje.</div>';
    }

    function abrirDetalhes(id) {
        const reserva = reservas.find(item => item.id === id);
        if (!reserva) return;
        document.getElementById('modalDetalhesContent').innerHTML = `
            <p><strong>Cliente:</strong> ${escapar(reserva.usuario?.nome_completo || 'Cliente')}</p>
            <p><strong>Quadra:</strong> ${escapar(reserva.quadra?.nome || '-')}</p>
            <p><strong>Data/Hora:</strong> ${formatarData(reserva.data)} ${hora(reserva.hora_inicio)} - ${hora(reserva.hora_fim)}</p>
            <p><strong>Status:</strong> ${escapar(reserva.status)}</p>
            <p><strong>Pagamento:</strong> ${escapar(reserva.pagamento?.status || 'Não informado')}</p>
            <p><strong>Valor:</strong> R$ ${Number(reserva.pagamento?.valor || reserva.valor_total || 0).toFixed(2).replace('.', ',')}</p>`;

        const confirmar = document.getElementById('btnConfirmarPagamentoModal');
        confirmar.disabled = !reserva.pagamento || reserva.pagamento.status !== 'pendente';
        confirmar.onclick = () => confirmarPagamento(reserva.pagamento?.id);
        confirmar.innerHTML = reserva.pagamento?.status === 'pago' ? '<i class="bi bi-check2-circle me-1"></i>Pago' : '<i class="bi bi-check-circle me-1"></i>Confirmar pagamento';

        const cancelar = document.getElementById('btnCancelarReservaModal');
        cancelar.disabled = reserva.status === 'cancelada';
        cancelar.onclick = () => cancelarReserva(reserva.id);
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetalhes')).show();
    }

    async function confirmarPagamento(id) {
        if (!id || !confirm('Confirmar recebimento do pagamento?')) return;
        try {
            await EsporTecApi.request(`${API_BASE}/funcionario/pagamentos/${id}/confirmar`, { method: 'PATCH' });
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes'))?.hide();
            esportecToast('Pagamento confirmado.', 'success');
            carregarAgenda();
        } catch (error) {
            esportecToast(error.message, 'warning');
        }
    }

    async function cancelarReserva(id) {
        if (!confirm('Cancelar esta reserva?')) return;
        try {
            await EsporTecApi.request(`${API_BASE}/reservas/${id}/cancelar`, { method: 'PATCH', body: JSON.stringify({ observacao: 'Cancelada pela equipe da arena' }) });
            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes'))?.hide();
            esportecToast('Reserva cancelada.', 'success');
            carregarAgenda();
        } catch (error) {
            esportecToast(error.message, 'warning');
        }
    }

    document.getElementById('agendaGrid').addEventListener('click', evento => {
        const botao = evento.target.closest('[data-reserva-id]');
        if (botao) abrirDetalhes(Number(botao.dataset.reservaId));
    });
    document.getElementById('dataSelecionada').addEventListener('change', carregarAgenda);
    document.getElementById('btnDia').addEventListener('click', () => alternarVisao('dia'));
    document.getElementById('btnSemana').addEventListener('click', () => alternarVisao('semana'));

    function alternarVisao(novaVisao) {
        visao = novaVisao;
        document.getElementById('btnDia').className = visao === 'dia' ? 'btn btn-success active' : 'btn btn-outline-success';
        document.getElementById('btnSemana').className = visao === 'semana' ? 'btn btn-success active' : 'btn btn-outline-success';
        document.getElementById('agendaTitulo').textContent = `Grade por quadra - visão ${visao === 'dia' ? 'do dia' : 'semanal'}`;
        carregarAgenda();
    }

    document.getElementById('dataSelecionada').value = hoje;
    carregarAgenda();
})();
