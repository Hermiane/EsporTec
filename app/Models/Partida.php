<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partida extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'partidas';

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

        'reservas_id',

        'link_partida',

        'max_jogador',

        'ativo',
    ];

    /**
     * Conversões automáticas.
     */
    protected function casts(): array
    {
        return [

            'ativo' => 'boolean',

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
     * Reserva vinculada.
     */
    public function reserva(): BelongsTo
    {
        return $this->belongsTo(
            Reserva::class,
            'reservas_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:N
    |--------------------------------------------------------------------------
    */

    /**
     * Jogadores participantes.
     */
    public function jogadores(): HasMany
    {
        return $this->hasMany(
            JogadorPartida::class,
            'partidas_id'
        );
    }
}
