<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auditoria extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'auditorias';

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

        'acao',

        'descricao',

        'tabela_afetada',

        'registro_id',

        'ip',
    ];

    /**
     * Conversão automática.
     */
    protected function casts(): array
    {
        return [

            'registro_id' => 'integer',

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
     * Usuário responsável pela ação.
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
}
