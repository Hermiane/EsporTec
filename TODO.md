 - [x] Implementar migration add_ativa_to_quadras_table: up() adiciona ativa boolean default true after nome; down() remove coluna.
- [x] Atualizar ReservaController@store com validação de conflito de horário (mesma quadra, mesma data, sobreposição), considerando status pendente/confirmada/paga.
- [x] Atualizar ReservaController@quadrasDisponiveis: filtrar quadras pela arena do usuário logado (funcionario_arena) e ativa=true.

- [x] Ajustar routes/api.php criando GET /api/quadras e POST /api/reservas com auth:sanctum.
- [ ] Testar: php artisan migrate; validar endpoints com requests manuais (horário conflitando e não conflitando).


