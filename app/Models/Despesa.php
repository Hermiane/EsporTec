<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Despesa extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'despesas';

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

        'registrado_por',

        'descricao',

        'categoria',

        'valor',

        'data_despesas',

        'semana_do_mes',

        'recorrente',

        'recorrencia',

        'comprovante',

        'observacao',
    ];

    /**
     * Conversões automáticas.
     */
    protected function casts(): array
    {
        return [

            'valor' => 'decimal:2',

            'data_despesas' => 'date',

            'recorrente' => 'boolean',

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
     * Arena proprietária da despesa.
     */
    public function arena(): BelongsTo
    {
        return $this->belongsTo(
            Arena::class,
            'arenas_id'
        );
    }

    /**
     * Usuário que registrou a despesa.
     */
    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'registrado_por'
        );
    }
}
