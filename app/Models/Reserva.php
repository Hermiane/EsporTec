<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reserva extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'reservas';

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

        'reservas_usuarios_id',

        'quadras_id',

        'alteradas_por',

        'data',

        'hora_inicio',

        'hora_fim',

        'valor_total',

        'status',

        'observacao',

        'cancelados_por',

        'cancelada_em',
    ];

    /**
     * Conversões automáticas.
     */
    protected function casts(): array
    {
        return [

            'data' => 'date',

            'cancelada_em' => 'datetime',

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
     * Cliente da reserva.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'reservas_usuarios_id'
        );
    }

    /**
     * Quadra reservada.
     */
    public function quadra(): BelongsTo
    {
        return $this->belongsTo(
            Quadra::class,
            'quadras_id'
        );
    }

    /**
     * Usuário que alterou.
     */
    public function alteradoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'alteradas_por'
        );
    }

    /**
     * Usuário que cancelou.
     */
    public function canceladoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'cancelados_por'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:1
    |--------------------------------------------------------------------------
    */

    /**
     * Pagamento da reserva.
     */
    public function pagamento(): HasOne
    {
        return $this->hasOne(
            Pagamento::class,
            'reservas_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:N
    |--------------------------------------------------------------------------
    */

    /**
     * Histórico da reserva.
     */
    public function historicos(): HasMany
    {
        return $this->hasMany(
            HistoricoReserva::class,
            'reservas_id'
        );
    }

    /**
     * Partida vinculada à reserva.
     */
    public function partida(): HasOne
    {
        return $this->hasOne(
            Partida::class,
            'reservas_id'
        );
    }

    /**
     * Ofertas utilizadas na reserva.
     */
    public function usosOfertas(): HasMany
    {
        return $this->hasMany(
            UsoOferta::class,
            'reservas_id'
        );
    }

    /**
     * Feedback da reserva.
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(
            Feedback::class,
            'reservas_id'
        );
    }
}
