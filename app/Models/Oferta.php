<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Oferta extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'ofertas';

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

        'arenas_id',

        'titulo',

        'descricao',

        'desconto_percent',

        'valida_ate',

        'tipo',

        'publico_alvo',

        'ativo',

        'criado_por',
    ];

    /**
     * Conversões automáticas.
     */
    protected function casts(): array
    {
        return [

            'desconto_percent' => 'decimal:2',

            'ativo' => 'boolean',

            'valida_ate' => 'datetime',

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
     * Arena proprietária.
     */
    public function arena(): BelongsTo
    {
        return $this->belongsTo(
            Arena::class,
            'arenas_id'
        );
    }

    /**
     * Usuário que criou.
     */
    public function criadoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'criado_por'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:N
    |--------------------------------------------------------------------------
    */

    /**
     * Histórico de utilização.
     */
    public function usos(): HasMany
    {
        return $this->hasMany(
            UsoOferta::class,
            'ofertas_id'
        );
    }

    /**
     * Notificações relacionadas.
     */
    public function notificacoes(): HasMany
    {
        return $this->hasMany(
            Notificacao::class,
            'ofertas_id'
        );
    }
}
