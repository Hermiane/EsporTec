<?php

namespace Database\Seeders;

use App\Models\Oferta;
use App\Models\Reserva;
use App\Models\UsoOferta;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsoOfertaSeeder extends Seeder
{
    /**
     * Executa o seeder.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();
        $ofertas = Oferta::all();
        $reservas = Reserva::all();

        if (
            $usuarios->isEmpty() ||
            $ofertas->isEmpty() ||
            $reservas->isEmpty()
        ) {
            $this->command->warn(
                'UsoOfertaSeeder ignorado: usuários, ofertas ou reservas inexistentes.'
            );

            return;
        }

        /**
         * Registros padrão.
         */
        UsoOferta::factory()
            ->count(30)
            ->create([
                'usuarios_id' => fn () => $usuarios->random()->id,

                'ofertas_id' => fn () => $ofertas->random()->id,

                'reservas_id' => fn () => $reservas->random()->id,
            ]);

        /**
         * Ofertas utilizadas.
         */
        UsoOferta::factory()
            ->count(15)
            ->utilizada()
            ->create([
                'usuarios_id' => fn () => $usuarios->random()->id,

                'ofertas_id' => fn () => $ofertas->random()->id,

                'reservas_id' => fn () => $reservas->random()->id,
            ]);

        /**
         * Ofertas não utilizadas.
         */
        UsoOferta::factory()
            ->count(10)
            ->naoUtilizada()
            ->create([
                'usuarios_id' => fn () => $usuarios->random()->id,

                'ofertas_id' => fn () => $ofertas->random()->id,

                'reservas_id' => fn () => $reservas->random()->id,
            ]);

        /**
         * Ofertas enviadas hoje.
         */
        UsoOferta::factory()
            ->count(5)
            ->enviadaHoje()
            ->create([
                'usuarios_id' => fn () => $usuarios->random()->id,

                'ofertas_id' => fn () => $ofertas->random()->id,

                'reservas_id' => fn () => $reservas->random()->id,
            ]);
    }
}