<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensagemSuporte extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'mensagens_suportes';

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

        'suportes_id',

        'usuarios_id',

        'mensagem',
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
     * Chamado de suporte.
     */
    public function suporte(): BelongsTo
    {
        return $this->belongsTo(
            Suporte::class,
            'suportes_id'
        );
    }

    /**
     * Usuário que enviou a mensagem.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }
}
