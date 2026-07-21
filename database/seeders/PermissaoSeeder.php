<?php

namespace Database\Seeders;

use App\Models\Permissao;
use Illuminate\Database\Seeder;

class PermissaoSeeder extends Seeder
{
    /**
     * Popula as permissões do sistema.
     */
    public function run(): void
    {
        $permissoes = [

            /*
            |--------------------------------------------------------------------------
            | Arena
            |--------------------------------------------------------------------------
            */

            [
                'titulo' => 'Gerenciar Arenas',
                'descricao' => 'Permite cadastrar, editar e excluir arenas.',
            ],

            [
                'titulo' => 'Gerenciar Quadras',
                'descricao' => 'Permite cadastrar, editar e excluir quadras.',
            ],

            [
                'titulo' => 'Gerenciar Horários',
                'descricao' => 'Permite configurar horários de funcionamento das quadras.',
            ],

            [
                'titulo' => 'Gerenciar Bloqueios',
                'descricao' => 'Permite bloquear horários para manutenção ou eventos.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Reservas
            |--------------------------------------------------------------------------
            */

            [
                'titulo' => 'Gerenciar Reservas',
                'descricao' => 'Permite visualizar, aprovar, cancelar e alterar reservas.',
            ],

            [
                'titulo' => 'Gerenciar Pagamentos',
                'descricao' => 'Permite confirmar pagamentos e acompanhar transações.',
            ],

            [
                'titulo' => 'Gerenciar Ofertas',
                'descricao' => 'Permite criar e administrar promoções e cupons.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Funcionários
            |--------------------------------------------------------------------------
            */

            [
                'titulo' => 'Gerenciar Funcionários',
                'descricao' => 'Permite cadastrar, editar e remover funcionários.',
            ],

            [
                'titulo' => 'Gerenciar Administradores',
                'descricao' => 'Permite administrar responsáveis pelas arenas.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Clientes
            |--------------------------------------------------------------------------
            */

            [
                'titulo' => 'Gerenciar Clientes',
                'descricao' => 'Permite consultar e editar informações dos clientes.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Financeiro
            |--------------------------------------------------------------------------
            */

            [
                'titulo' => 'Gerenciar Financeiro',
                'descricao' => 'Permite visualizar despesas, receitas e indicadores financeiros.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Relatórios
            |--------------------------------------------------------------------------
            */

            [
                'titulo' => 'Visualizar Relatórios',
                'descricao' => 'Permite acessar relatórios administrativos.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Sistema
            |--------------------------------------------------------------------------
            */

            [
                'titulo' => 'Gerenciar Configurações',
                'descricao' => 'Permite alterar configurações gerais do sistema.',
            ],

            [
                'titulo' => 'Gerenciar Auditoria',
                'descricao' => 'Permite consultar registros de auditoria.',
            ],

            [
                'titulo' => 'Responder Chamados',
                'descricao' => 'Permite responder solicitações de suporte.',
            ],
        ];

        foreach ($permissoes as $permissao) {

            Permissao::firstOrCreate(
                [
                    'titulo' => $permissao['titulo'],
                ],
                [
                    'descricao' => $permissao['descricao'],
                ]
            );

        }
    }
}