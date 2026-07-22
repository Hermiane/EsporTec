<?php

namespace Database\Seeders;

use App\Models\AdminArena;
use App\Models\Arena;
use App\Models\FuncionarioArena;
use App\Models\HorarioFuncionamento;
use App\Models\Pagamento;
use App\Models\PessoaFisica;
use App\Models\Quadra;
use App\Models\Reserva;
use App\Models\SuperAdmin;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /** Cria uma base pequena e previsível para avaliação local do projeto. */
    public function run(): void
    {
        DB::transaction(function (): void {
            $senha = Hash::make('EsporTec@123');
            $superAdmin = $this->usuario('Equipe EsporTec', 'superadmin.esportec', 'superadmin@esportec.test', $senha);
            $gestor = $this->usuario('Marina Costa', 'marina.gestora', 'gestor@arenaexemplo.test', $senha);
            $funcionario = $this->usuario('Lucas Ferreira', 'lucas.funcionario', 'funcionario@arenaexemplo.test', $senha);
            $cliente = $this->usuario('Ana Souza', 'ana.cliente', 'cliente@esportec.test', $senha);

            SuperAdmin::updateOrCreate(['usuarios_id' => $superAdmin->id], ['cargo' => 'Equipe EsporTec', 'ativo' => true]);

            foreach ([$superAdmin, $gestor, $funcionario, $cliente] as $indice => $usuario) {
                PessoaFisica::updateOrCreate(
                    ['usuarios_id' => $usuario->id],
                    ['cpf' => '0000000000'.($indice + 1), 'cpf_verificado' => true]
                );
            }

            $arena = Arena::updateOrCreate(
                ['cnpj' => '12.345.678/0001-90'],
                [
                    'criado_por' => $gestor->id, 'nome' => 'Arena Exemplo EsporTec',
                    'logradouro' => 'Avenida do Esporte', 'numero' => '100', 'bairro' => 'Centro',
                    'ponto_referencia' => 'Próximo à praça central', 'cidade' => 'Cametá', 'estado' => 'PA',
                    'telefone' => '91999990000', 'email' => 'contato@arenaexemplo.test',
                    'foto_capa' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1200&q=80',
                    'descricao' => 'Arena de demonstração com quadras para futsal e society.',
                    'pix_tipo' => 'email', 'pix_chave' => 'pagamentos@arenaexemplo.test', 'ativo' => true,
                    'status_aprovacao' => 'aprovada', 'analisada_em' => now(), 'analisada_por' => $superAdmin->id,
                ]
            );

            AdminArena::updateOrCreate(
                ['arenas_id' => $arena->id, 'usuarios_id' => $gestor->id],
                ['criado_por' => $superAdmin->id, 'cargo' => 'Proprietária', 'is_dono' => true, 'ativo' => true]
            );
            FuncionarioArena::updateOrCreate(
                ['arenas_id' => $arena->id, 'usuarios_id' => $funcionario->id],
                ['criado_por' => $gestor->id, 'cargo' => 'Atendente', 'turno' => 'integral', 'data_entrada' => now()->subMonth()->toDateString(), 'ativo' => true]
            );

            $futsal = $this->quadra($arena, 'Futsal Coberta', 'futsal', 10, true, 80, 'Quadra coberta para partidas de futsal.');
            $society = $this->quadra($arena, 'Society Gramado', 'society', 14, false, 100, 'Quadra society com gramado sintético.');

            foreach ([$futsal, $society] as $quadra) {
                foreach (['segunda-feira', 'terca-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sabado', 'domingo'] as $dia) {
                    HorarioFuncionamento::updateOrCreate(
                        ['quadras_id' => $quadra->id, 'dia_semana' => $dia],
                        ['hora_inicio' => '08:00:00', 'hora_fim' => '22:00:00', 'ativo' => true]
                    );
                }
            }

            $confirmada = Reserva::updateOrCreate(
                ['reservas_usuarios_id' => $cliente->id, 'quadras_id' => $futsal->id, 'data' => now()->addDays(2)->toDateString(), 'hora_inicio' => '19:00:00'],
                ['hora_fim' => '20:00:00', 'valor_total' => 80, 'status' => 'confirmada', 'observacao' => 'Reserva de demonstração confirmada.']
            );
            Pagamento::updateOrCreate(
                ['reservas_id' => $confirmada->id],
                ['metodo' => 'pix', 'tipo' => 'integral', 'status' => 'pago', 'valor' => 80, 'pix_copia_cola' => 'PIX-DEMONSTRACAO-ESPORTEC', 'pago_em' => now(), 'confirmados_por' => $gestor->id]
            );

            $pendente = Reserva::updateOrCreate(
                ['reservas_usuarios_id' => $cliente->id, 'quadras_id' => $society->id, 'data' => now()->addDays(4)->toDateString(), 'hora_inicio' => '18:00:00'],
                ['hora_fim' => '19:00:00', 'valor_total' => 100, 'status' => 'pendente', 'observacao' => 'Reserva de demonstração aguardando confirmação.']
            );
            Pagamento::updateOrCreate(
                ['reservas_id' => $pendente->id],
                ['metodo' => 'dinheiro', 'tipo' => 'integral', 'status' => 'pendente', 'valor' => 100]
            );
        });
    }

    private function usuario(string $nome, string $nomeUsuario, string $email, string $senha): Usuario
    {
        return Usuario::updateOrCreate(
            ['email' => $email],
            ['nome_completo' => $nome, 'nome_usuario' => $nomeUsuario, 'senha_hash' => $senha, 'telefone' => '91999990000', 'data_nascimento' => '1995-01-01', 'ativo' => true, 'email_verificacao' => now()]
        );
    }

    private function quadra(Arena $arena, string $nome, string $tipo, int $capacidade, bool $coberta, float $preco, string $descricao): Quadra
    {
        return Quadra::updateOrCreate(
            ['arenas_id' => $arena->id, 'nome' => $nome],
            ['tipo' => $tipo, 'descricao' => $descricao, 'foto' => 'https://images.unsplash.com/photo-1551958219-acbc608c6377?auto=format&fit=crop&w=1200&q=80', 'capacidade_jogador' => $capacidade, 'coberta' => $coberta, 'preco_hora' => $preco, 'ativo' => true]
        );
    }
}
