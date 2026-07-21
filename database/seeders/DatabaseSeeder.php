<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Executa todos os seeders da aplicação.
     */
    public function run(): void
    {
        $this->call([

            /*
            |--------------------------------------------------------------------------
            | Usuários
            |--------------------------------------------------------------------------
            */

            UsuarioSeeder::class,

            SuperAdminSeeder::class,

            PessoaFisicaSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Arena e configurações
            |--------------------------------------------------------------------------
            */

            ArenaSeeder::class,

            ConfiguracaoSeeder::class,

            HorarioFuncionamentoSeeder::class,

            QuadraSeeder::class,

            BloqueioQuadraSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Permissões e funcionários
            |--------------------------------------------------------------------------
            */

            PermissaoSeeder::class,

            AdminArenaSeeder::class,

            FuncionarioArenaSeeder::class,

            AdminPermissaoSeeder::class,

            FuncionarioPermissaoSeeder::class,

            ConviteFuncionarioSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Reservas
            |--------------------------------------------------------------------------
            */

            ReservaSeeder::class,

            PagamentoSeeder::class,

            HistoricoReservaSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Partidas
            |--------------------------------------------------------------------------
            */

            PartidaSeeder::class,

            JogadorPartidaSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Feedback
            |--------------------------------------------------------------------------
            */

            FeedbackSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Ofertas
            |--------------------------------------------------------------------------
            */

            OfertaSeeder::class,

            UsoOfertaSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Notificações
            |--------------------------------------------------------------------------
            */

            NotificacaoSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Financeiro
            |--------------------------------------------------------------------------
            */

            DespesaSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Suporte
            |--------------------------------------------------------------------------
            */

            SuporteSeeder::class,

            MensagemSuporteSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Inteligência de negócio
            |--------------------------------------------------------------------------
            */

            PadraoVisitaSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Segurança
            |--------------------------------------------------------------------------
            */

            ResetarSenhaSeeder::class,

            AuditoriaSeeder::class,

        ]);
    }
}