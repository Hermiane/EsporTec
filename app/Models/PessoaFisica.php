<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PessoaFisica extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'pessoas_fisicas';

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

        'usuarios_id',

        'cpf',

        'cpf_verificado',
    ];

    /**
     * Conversão automática de atributos.
     */
    protected function casts(): array
    {
        return [

            'cpf_verificado' => 'boolean',

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
     * Usuário proprietário deste CPF.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }
}
