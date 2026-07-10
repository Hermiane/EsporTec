<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'pagamentos';

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

        'metodo',

        'status',

        'valor',

        'pix_copia_cola',

        'comprovante',

        'pago_em',

        'confirmados_por',
    ];

    protected function casts(): array
    {
        return [

            'valor' => 'decimal:2',

            'pago_em' => 'datetime',

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
     * Usuário que confirmou.
     */
    public function confirmadoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'confirmados_por'
        );
    }
}
