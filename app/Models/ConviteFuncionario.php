<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConviteFuncionario extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'convites_funcionarios';

    /**
     * Chave primária.
     */
    protected $primaryKey = 'id';

    /**
     * Tipo da chave primária.
     */
    protected $keyType = 'int';

    /**
     * Chave auto incremento.
     */
    public $incrementing = true;

    /**
     * Permite criação em massa.
     */
    protected $fillable = [

        'arenas_id',

        'email',

        'token',

        'cargo',

        'turno',

        'status',

        'enviados_por',

        'aceitados_por',

        'expirado_em',
    ];

    /**
     * Conversão automática de atributos.
     */
    protected function casts(): array
    {
        return [

            'expirado_em' => 'datetime',

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
     * Arena responsável pelo convite.
     */
    public function arena(): BelongsTo
    {
        return $this->belongsTo(
            Arena::class,
            'arenas_id'
        );
    }

    /**
     * Usuário que enviou o convite.
     */
    public function enviadoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'enviados_por'
        );
    }

    /**
     * Usuário que aceitou o convite.
     */
    public function aceitoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'aceitados_por'
        );
    }
}
