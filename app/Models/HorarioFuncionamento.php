<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioFuncionamento extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'horarios_funcionamento';

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

        'quadras_id',

        'dia_semana',

        'hora_inicio',

        'hora_fim',

        'ativo',
    ];

    /**
     * Conversão automática de atributos.
     */
    protected function casts(): array
    {
        return [

            'hora_inicio' => 'string',

            'hora_fim' => 'string',

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
     * Quadra proprietária deste horário.
     */
    public function quadra(): BelongsTo
    {
        return $this->belongsTo(
            Quadra::class,
            'quadras_id'
        );
    }
}
