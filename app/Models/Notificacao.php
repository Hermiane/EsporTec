<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacao extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'notificacoes';

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

        'arenas_id',

        'ofertas_id',

        'destinatario',

        'tipo',

        'titulo',

        'mensagem',

        'lida',

        'criado_por',

        'enviada_em',
    ];

    /**
     * Conversões automáticas.
     */
    protected function casts(): array
    {
        return [

            'lida' => 'boolean',

            'enviada_em' => 'datetime',

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
     * Usuário destinatário.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }

    /**
     * Arena relacionada.
     */
    public function arena(): BelongsTo
    {
        return $this->belongsTo(
            Arena::class,
            'arenas_id'
        );
    }

    /**
     * Oferta relacionada.
     */
    public function oferta(): BelongsTo
    {
        return $this->belongsTo(
            Oferta::class,
            'ofertas_id'
        );
    }

    /**
     * Usuário que enviou.
     */
    public function criadoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'criado_por'
        );
    }
}
