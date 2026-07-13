<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminPermissao extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'admins_permissoes';

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

        'admins_arenas_id',

        'permissoes_id',

        'concedido_por',
    ];

    /**
     * Conversão automática de atributos.
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
     * Administrador da arena.
     */
    public function administrador(): BelongsTo
    {
        return $this->belongsTo(
            AdminArena::class,
            'admins_arenas_id'
        );
    }

    /**
     * Permissão concedida.
     */
    public function permissao(): BelongsTo
    {
        return $this->belongsTo(
            Permissao::class,
            'permissoes_id'
        );
    }

    /**
     * Usuário que concedeu a permissão.
     */
    public function concedidoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'concedido_por'
        );
    }
}
