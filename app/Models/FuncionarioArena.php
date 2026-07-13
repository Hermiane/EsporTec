<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FuncionarioArena extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'funcionarios_arenas';

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

        'turno',

        'data_entrada',

        'ativo',
    ];

    /**
     * Conversão automática de atributos.
     */
    protected function casts(): array
    {
        return [

            'ativo' => 'boolean',

            'data_entrada' => 'date',

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
     * Arena onde o funcionário trabalha.
     */
    public function arena(): BelongsTo
    {
        return $this->belongsTo(
            Arena::class,
            'arenas_id'
        );
    }

    /**
     * Usuário que representa o funcionário.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }

    /**
     * Usuário responsável pelo cadastro.
     */
    public function criadoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'criado_por'
        );
    }

    /**
     * Permissões do funcionário.
     */
    public function permissoes(): HasMany
    {
        return $this->hasMany(
            FuncionarioPermissao::class,
            'funcionarios_id'
        );
    }
}
