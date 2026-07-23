<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('arenas')
            ->orderBy('id')
            ->get(['id', 'descricao'])
            ->each(function ($arena): void {
                $descricaoFoiCopiada = DB::table('quadras')
                    ->where('arenas_id', $arena->id)
                    ->where('descricao', $arena->descricao)
                    ->exists();

                if ($descricaoFoiCopiada) {
                    DB::table('arenas')->where('id', $arena->id)->update(['descricao' => '']);
                }
            });
    }

    public function down(): void
    {
        // A descrição copiada não é restaurada para evitar repetir o problema.
    }
};
