<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'feedbacks';

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
     * Permite criação em massa.
     */
    protected $fillable = [

        'reservas_id',

        'usuarios_id',

        'arenas_id',

        'momento',

        'nota',

        'comentario',

        'visivel',

        'respondido_por',

        'resposta',
    ];

    /**
     * Conversão automática.
     */
    protected function casts(): array
    {
        return [

            'nota' => 'integer',

            'visivel' => 'boolean',

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
     * Reserva relacionada.
     */
    public function reserva(): BelongsTo
    {
        return $this->belongsTo(
            Reserva::class,
            'reservas_id'
        );
    }

    /**
     * Usuário que enviou.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }

    /**
     * Arena avaliada.
     */
    public function arena(): BelongsTo
    {
        return $this->belongsTo(
            Arena::class,
            'arenas_id'
        );
    }

    /**
     * Usuário que respondeu.
     */
    public function respondidoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'respondido_por'
        );
    }
}
