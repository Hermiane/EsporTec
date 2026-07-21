<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quadra extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'quadras';

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

        'arenas_id',

        'nome',

        'tipo',

        'descricao',

        'foto',

        'capacidade_jogador',

        'coberta',

        'preco_hora',

        'ativo',
    ];

    /**
     * Conversão automática de atributos.
     */
    protected function casts(): array
    {
        return [

            'capacidade_jogador' => 'integer',

            'coberta' => 'boolean',

            'preco_hora' => 'decimal:2',

            'ativo' => 'boolean',

            'created_at' => 'datetime',

            'updated_at' => 'datetime',
        ];
    }

    /** Mantém imagens públicas no mesmo host/porta usado pelo navegador. */
    public function getFotoAttribute(?string $valor): ?string
    {
        if (!$valor) {
            return $valor;
        }

        $caminho = parse_url($valor, PHP_URL_PATH);

        return is_string($caminho) && str_starts_with($caminho, '/storage/') ? $caminho : $valor;
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos N:1
    |--------------------------------------------------------------------------
    */

    /**
     * Arena proprietária da quadra.
     */
    public function arena(): BelongsTo
    {
        return $this->belongsTo(
            Arena::class,
            'arenas_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:N
    |--------------------------------------------------------------------------
    */

    /**
     * Horários de funcionamento.
     */
    public function horariosFuncionamento(): HasMany
    {
        return $this->hasMany(
            HorarioFuncionamento::class,
            'quadras_id'
        );
    }

    /**
     * Bloqueios da quadra.
     */
    public function bloqueios(): HasMany
    {
        return $this->hasMany(
            BloqueioQuadra::class,
            'quadras_id'
        );
    }

    /**
     * Reservas da quadra.
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(
            Reserva::class,
            'quadras_id'
        );
    }
}
