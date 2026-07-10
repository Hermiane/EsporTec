<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminArena extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'admins_arenas';

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

        'arenas_id',

        'usuarios_id',

        'criado_por',

        'cargo',

        'is_dono',

        'ativo',
    ];

    /**
     * Conversão automática de atributos.
     */
    protected function casts(): array
    {
        return [

            'is_dono' => 'boolean',

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
     * Arena administrada.
     */
    public function arena(): BelongsTo
    {
        return $this->belongsTo(
            Arena::class,
            'arenas_id'
        );
    }

    /**
     * Usuário administrador.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }

    /**
     * Usuário que cadastrou este administrador.
     */
    public function criadoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'criado_por'
        );
    }

    /**
     * Permissões do administrador.
     */
    public function permissoes(): HasMany
    {
        return $this->hasMany(
            AdminPermissao::class,
            'admins_arenas_id'
        );
    }
}
