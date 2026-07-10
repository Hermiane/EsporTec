<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JogadorPartida extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'jogadores_partidas';

    /**
     * Chave primária.
     */
    protected $primaryKey = 'id';

    /**
     * Tipo da chave.
     */
    protected $keyType = 'int';

    /**
     * Auto incremento.
     */
    public $incrementing = true;

    /**
     * Campos preenchíveis.
     */
    protected $fillable = [

        'usuarios_id',

        'partidas_id',

        'nome_jogador',

        'contato',

        'status',
    ];

    /**
     * Conversões automáticas.
     */
    protected function casts(): array
    {
        return [

            'created_at' => 'datetime',

            'updated_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos N:1
    |--------------------------------------------------------------------------
    */

    /**
     * Usuário participante.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }

    /**
     * Partida.
     */
    public function partida(): BelongsTo
    {
        return $this->belongsTo(
            Partida::class,
            'partidas_id'
        );
    }
}
