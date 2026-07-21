# EsporTec

Aplicação Laravel para gestão de arenas esportivas, quadras, reservas e pagamentos. Possui área pública, cliente, funcionário, administração da arena e superadmin.

## Requisitos

- PHP 8.3 ou superior
- Composer
- MySQL/MariaDB
- Node.js e npm (opcional, somente se for alterar os assets do front-end)
- XAMPP ou ambiente equivalente

## Instalação para avaliação

1. Clone o repositório e entre na pasta do projeto.

2. Instale as dependências:

```bash
composer install
```

3. Crie um banco MySQL vazio chamado `esportec`.

4. Copie o arquivo de configuração de exemplo:

```powershell
Copy-Item .env.example .env
```

5. Confira no `.env` as credenciais locais do MySQL. No XAMPP padrão, elas são:

```env
DB_DATABASE=esportec
DB_USERNAME=root
DB_PASSWORD=
```

6. Gere a chave, crie as tabelas e carregue a base de demonstração:

```bash
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Abra `http://127.0.0.1:8000` no navegador.

> `migrate:fresh --seed` apaga as tabelas do banco configurado no `.env`. Use-o apenas em um banco local de demonstração vazio.

## Dados de demonstração

O comando de instalação cria uma arena, duas quadras, horários de funcionamento, reservas e pagamentos de exemplo em português. Todas as contas abaixo usam a senha:

```text
EsporTec@123
```

| Área | E-mail | Tipo de acesso no login |
| --- | --- | --- |
| Superadmin | `superadmin@esportec.test` | Super admin |
| Administração da arena | `gestor@arenaexemplo.test` | Admin da arena |
| Funcionário | `funcionario@arenaexemplo.test` | Funcionário |
| Cliente | `cliente@esportec.test` | Cliente |

## Segurança e dados locais

- O arquivo `.env` não é versionado e não deve ser enviado ao Git.
- A base demonstrativa é criada pelos seeders; dados cadastrados em um computador não são enviados automaticamente pelo Git.
- Para demonstrar a aplicação com dados criados localmente, use o link do Cloudflare Tunnel ou exporte o banco como arquivo SQL separadamente.

## Tecnologias

- Laravel 13
- PHP 8.3+
- MySQL/MariaDB
- Blade, Bootstrap e JavaScript
