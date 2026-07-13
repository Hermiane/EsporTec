<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloqueioQuadra extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'bloqueios_quadras';

    /**
     * Chave primária.
     */
    protected $primaryKey = 'id';

    /**
     * Tipo da chave primária.
     */
    protected $keyType = 'int';

    /**
     * Indica que a chave é auto incremento.
     */
    public $incrementing = true;

    /**
     * Permite criação em massa.
     */
    protected $fillable = [

        'quadras_id',

        'criado_por',

        'data',

        'hora_inicio',

        'hora_fim',

        'motivo',

        'tipo',
    ];

    /**
     * Conversão automática de atributos.
     */
    protected function casts(): array
    {
        return [

            'data' => 'date',

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
     * Quadra bloqueada.
     */
    public function quadra(): BelongsTo
    {
        return $this->belongsTo(
            Quadra::class,
            'quadras_id'
        );
    }

    /**
     * Usuário responsável pelo bloqueio.
     */
    public function criadoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'criado_por'
        );
    }
}
