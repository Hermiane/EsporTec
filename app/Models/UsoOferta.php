<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsoOferta extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'usos_ofertas';

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

        'ofertas_id',

        'reservas_id',

        'enviada_em',

        'utilizada',

        'utilizada_em',
    ];

    /**
     * Conversões automáticas.
     */
    protected function casts(): array
    {
        return [

            'utilizada' => 'boolean',

            'enviada_em' => 'datetime',

            'utilizada_em' => 'datetime',

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
     * Usuário.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }

    /**
     * Oferta.
     */
    public function oferta(): BelongsTo
    {
        return $this->belongsTo(
            Oferta::class,
            'ofertas_id'
        );
    }

    /**
     * Reserva.
     */
    public function reserva(): BelongsTo
    {
        return $this->belongsTo(
            Reserva::class,
            'reservas_id'
        );
    }
}
