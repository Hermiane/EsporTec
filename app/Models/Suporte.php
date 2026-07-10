<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suporte extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'suportes';

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

        'usuarios_id',

        'titulo',

        'descricao',

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
     * Usuário que abriu o chamado.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:N
    |--------------------------------------------------------------------------
    */

    /**
     * Mensagens do chamado.
     */
    public function mensagens(): HasMany
    {
        return $this->hasMany(
            MensagemSuporte::class,
            'suportes_id'
        );
    }
}
