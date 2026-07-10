<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoReserva extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'historicos_reservas';

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

        'reservas_id',

        'usuarios_id',

        'acao',

        'campo_alterado',

        'valor_antigo',

        'valor_novo',

        'motivo',

        'ip',
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
     * Reserva.
     */
    public function reserva(): BelongsTo
    {
        return $this->belongsTo(
            Reserva::class,
            'reservas_id'
        );
    }

    /**
     * Usuário responsável.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'usuarios_id'
        );
    }
}
