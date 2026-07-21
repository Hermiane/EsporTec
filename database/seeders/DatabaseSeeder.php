<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** Executa a base de demonstração usada após a instalação limpa. */
    public function run(): void
    {
        $this->call(DemoSeeder::class);
    }
}
