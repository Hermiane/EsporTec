<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permissao extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'permissoes';

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

        'titulo',

        'descricao',
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
    | Relacionamentos 1:N
    |--------------------------------------------------------------------------
    */

    /**
     * Permissões atribuídas aos administradores.
     */
    public function administradoresPermissoes(): HasMany
    {
        return $this->hasMany(
            AdminPermissao::class,
            'permissoes_id'
        );
    }

    /**
     * Permissões atribuídas aos funcionários.
     */
    public function funcionariosPermissoes(): HasMany
    {
        return $this->hasMany(
            FuncionarioPermissao::class,
            'permissoes_id'
        );
    }
}
