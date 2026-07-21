<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Arena extends Model
{
    use HasFactory;

    /**
     * Nome da tabela.
     */
    protected $table = 'arenas';

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

        'criado_por',

        'nome',

        'cnpj',

        'logradouro',

        'bairro',

        'numero',

        'ponto_referencia',

        'cidade',

        'estado',

        'telefone',

        'email',

        'foto_capa',

        'descricao',

        'pix_tipo',

        'pix_chave',

        'ativo',

        'status_aprovacao',

        'motivo_recusa',

        'analisada_em',

        'analisada_por',
    ];

    /**
     * Conversão automática de atributos.
     */
    protected function casts(): array
    {
        return [

            'ativo' => 'boolean',

            'analisada_em' => 'datetime',

            'created_at' => 'datetime',

            'updated_at' => 'datetime',
        ];
    }

    /** Mantém imagens públicas no mesmo host/porta usado pelo navegador. */
    public function getFotoCapaAttribute(?string $valor): ?string
    {
        return $this->urlPublicaRelativa($valor);
    }

    private function urlPublicaRelativa(?string $valor): ?string
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
     * Usuário que cadastrou a arena.
     */
    public function criadoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'criado_por'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:N
    |--------------------------------------------------------------------------
    */

    /**
     * Configurações da arena.
     */
    public function configuracao(): HasMany
    {
        return $this->hasMany(
            Configuracao::class,
            'arenas_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:N
    |--------------------------------------------------------------------------
    */

    /**
     * Quadras pertencentes à arena.
     */
    public function quadras(): HasMany
    {
        return $this->hasMany(
            Quadra::class,
            'arenas_id'
        );
    }

    /**
     * Administradores da arena.
     */
    public function administradores(): HasMany
    {
        return $this->hasMany(
            AdminArena::class,
            'arenas_id'
        );
    }

    /**
     * Funcionários da arena.
     */
    public function funcionarios(): HasMany
    {
        return $this->hasMany(
            FuncionarioArena::class,
            'arenas_id'
        );
    }

    /**
     * Ofertas cadastradas pela arena.
     */
    public function ofertas(): HasMany
    {
        return $this->hasMany(
            Oferta::class,
            'arenas_id'
        );
    }

    /**
     * Despesas da arena.
     */
    public function despesas(): HasMany
    {
        return $this->hasMany(
            Despesa::class,
            'arenas_id'
        );
    }

    /**
     * Feedbacks recebidos.
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(
            Feedback::class,
            'arenas_id'
        );
    }

    /**
     * Padrões de visita.
     */
    public function padroesVisitas(): HasMany
    {
        return $this->hasMany(
            PadraoVisita::class,
            'arenas_id'
        );
    }

    /**
     * Convites enviados para funcionários da arena.
     */
    public function convitesFuncionarios(): HasMany
    {
        return $this->hasMany(
            ConviteFuncionario::class,
            'arenas_id'
        );
    }

    /**
     * Notificações da arena.
     */
    public function notificacoes(): HasMany
    {
        return $this->hasMany(
            Notificacao::class,
            'arenas_id'
        );
    }

    /**
     * Chamados de suporte da arena.
     */
    public function suportes(): HasMany
    {
        return $this->hasMany(
            Suporte::class,
            'arenas_id'
        );
    }

    /**
     * Auditorias da arena.
     */
    public function auditorias(): HasMany
    {
        return $this->hasMany(
            Auditoria::class,
            'arenas_id'
        );
    }
}
