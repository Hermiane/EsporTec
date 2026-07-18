<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Nome da tabela.
     */
    protected $table = 'usuarios';

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

        'nome_completo',

        'nome_usuario',

        'email',

        'senha_hash',

        'telefone',

        'data_nascimento',

        'foto_perfil',

        'email_marketing',

        'ativo',

        'relembrar_token',

        'email_verificacao',

        'login_tentativa',

        'login_bloqueado_ate',
    ];

    /**
     * Campos ocultos.
     */
    protected $hidden = [

        'senha_hash',

        'relembrar_token',
    ];

    /**
     * Conversão automática de atributos.
     */
    protected function casts(): array
    {
        return [

            'email_marketing' => 'boolean',

            'ativo' => 'boolean',

            'data_nascimento' => 'date',

            'email_verificacao' => 'datetime',

            'login_bloqueado_ate' => 'datetime',

            'created_at' => 'datetime',

            'updated_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Autenticação
    |--------------------------------------------------------------------------
    */

    /**
     * Campo utilizado pelo Laravel para armazenar a senha.
     */
    public function getAuthPassword(): string
    {
        return $this->senha_hash;
    }

    /**
     * Campo utilizado pelo recurso "Lembrar-me".
     */
    public function getRememberTokenName(): string
    {
        return 'relembrar_token';
    }
    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:1
    |--------------------------------------------------------------------------
    */

    /**
     * Dados pessoais do usuário.
     */
    public function pessoaFisica(): HasOne
    {
        return $this->hasOne(
            PessoaFisica::class,
            'usuarios_id'
        );
    }

    /**
     * Super Administrador.
     */
    public function superAdmin(): HasOne
    {
        return $this->hasOne(
            SuperAdmin::class,
            'usuarios_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos 1:N
    |--------------------------------------------------------------------------
    */
    /**
     * Super Administradores promovidos por este usuário.
     */
    public function superAdminsCriados(): HasMany
    {
        return $this->hasMany(
            SuperAdmin::class,
            'criado_por'
        );
    }

    /**
     * Reservas realizadas.
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(
            Reserva::class,
            'reservas_usuarios_id'
        );
    }

    /**
     * Convites enviados pelo usuário.
     */
    public function convitesEnviados(): HasMany
    {
        return $this->hasMany(
            ConviteFuncionario::class,
            'enviados_por'
        );
    }

    /**
     * Convites aceitos pelo usuário.
     */
    public function convitesAceitos(): HasMany
    {
        return $this->hasMany(
            ConviteFuncionario::class,
            'aceitados_por'
        );
    }

    /**
     * Arenas administradas pelo usuário.
     */
    public function administradoresArena(): HasMany
    {
        return $this->hasMany(
            AdminArena::class,
            'usuarios_id'
        );
    }

    /**
     * Usuário que Atua como funcionário na arena.
     */
    public function funcionariosArena(): HasMany
    {
        return $this->hasMany(
            FuncionarioArena::class,
            'usuarios_id'
        );
    }

    /**
     * Pagamentos confirmados.
     */
    public function pagamentosConfirmados(): HasMany
    {
        return $this->hasMany(
            Pagamento::class,
            'confirmados_por'
        );
    }

    /**
     * Participações em partidas.
     */
    public function jogadoresPartidas(): HasMany
    {
        return $this->hasMany(
            JogadorPartida::class,
            'usuarios_id'
        );
    }

    /**
     * Feedbacks enviados.
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(
            Feedback::class,
            'usuarios_id'
        );
    }

    /**
     * Respostas aos feedbacks.
     */
    public function feedbacksRespondidos(): HasMany
    {
        return $this->hasMany(
            Feedback::class,
            'respondido_por'
        );
    }

    /**
     * Ofertas cadastradas.
     */
    public function ofertasCriadas(): HasMany
    {
        return $this->hasMany(
            Oferta::class,
            'criado_por'
        );
    }

    /**
     * Notificações recebidas.
     */
    public function notificacoes(): HasMany
    {
        return $this->hasMany(
            Notificacao::class,
            'usuarios_id'
        );
    }

    /**
     * Chamados de suporte.
     */
    public function suportes(): HasMany
    {
        return $this->hasMany(
            Suporte::class,
            'usuarios_id'
        );
    }

    /**
     * Mensagens enviadas ao suporte.
     */
    public function mensagensSuporte(): HasMany
    {
        return $this->hasMany(
            MensagemSuporte::class,
            'usuarios_id'
        );
    }

    /**
     * Auditorias registradas.
     */
    public function auditorias(): HasMany
    {
        return $this->hasMany(
            Auditoria::class,
            'usuarios_id'
        );
    }

    /**
     * Solicitações de recuperação de senha
     * e alteração de e-mail.
     */
    public function resetarSenhas(): HasMany
    {
        return $this->hasMany(
            ResetarSenha::class,
            'usuarios_id'
        );
    }

    /**
     * Arenas cadastradas pelo usuário.
     */
    public function arenasCriadas(): HasMany
    {
        return $this->hasMany(
            Arena::class,
            'criado_por'
        );
    }

    /**
     * Bloqueios de quadras criados pelo usuário.
     */
    public function bloqueiosQuadras(): HasMany
    {
        return $this->hasMany(
            BloqueioQuadra::class,
            'criado_por'
        );
    }

    /**
     * Administradores de arena cadastrados pelo usuário.
     */
    public function administradoresCriados(): HasMany
    {
        return $this->hasMany(
            AdminArena::class,
            'criado_por'
        );
    }

    /**
     * Funcionários cadastrados pelo usuário.
     */
    public function funcionariosCriados(): HasMany
    {
        return $this->hasMany(
            FuncionarioArena::class,
            'criado_por'
        );
    }

    /**
     * Permissões concedidas a administradores.
     */
    public function permissoesAdministradoresConcedidas(): HasMany
    {
        return $this->hasMany(
            AdminPermissao::class,
            'concedido_por'
        );
    }

    /**
     * Permissões concedidas a funcionários.
     */
    public function permissoesFuncionariosConcedidas(): HasMany
    {
        return $this->hasMany(
            FuncionarioPermissao::class,
            'concedido_por'
        );
    }

    /**
     * Reservas alteradas pelo usuário.
     */
    public function reservasAlteradas(): HasMany
    {
        return $this->hasMany(
            Reserva::class,
            'alteradas_por'
        );
    }

    /**
     * Reservas canceladas pelo usuário.
     */
    public function reservasCanceladas(): HasMany
    {
        return $this->hasMany(
            Reserva::class,
            'cancelados_por'
        );
    }

    /**
     * Históricos registrados pelo usuário.
     */
    public function historicosReservas(): HasMany
    {
        return $this->hasMany(
            HistoricoReserva::class,
            'usuarios_id'
        );
    }

    /**
     * Utilizações de ofertas.
     */
    public function usosOfertas(): HasMany
    {
        return $this->hasMany(
            UsoOferta::class,
            'usuarios_id'
        );
    }

    /**
     * Notificações enviadas.
     */
    public function notificacoesCriadas(): HasMany
    {
        return $this->hasMany(
            Notificacao::class,
            'criado_por'
        );
    }

    /**
     * Despesas registradas pelo usuário.
     */
    public function despesasRegistradas(): HasMany
    {
        return $this->hasMany(
            Despesa::class,
            'registrado_por'
        );
    }

    /**
     * Padrões de visita do usuário.
     */
    public function padroesVisitas(): HasMany
    {
        return $this->hasMany(
            PadraoVisita::class,
            'usuarios_id'
        );
    }
}
