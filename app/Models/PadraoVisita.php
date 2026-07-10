<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PadraoVisita extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'padroes_visitas';

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
     * Permite criação em massa.
     */
    protected $fillable = [

        'usuarios_id',

        'arenas_id',

        'dia_semana',

        'frequencia',

        'ultima_visita',
    ];

    /**
     * Conversão automática.
     */
    protected function casts(): array
    {
        return [

            'dia_semana' => 'integer',

            'frequencia' => 'integer',

            'ultima_visita' => 'datetime',

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
     * Usuário.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }

    /**
     * Arena.
     */
    public function arena(): BelongsTo
    {
        return $this->belongsTo(
            Arena::class,
            'arenas_id'
        );
    }
}
