
# Teste Api Backend TruckPag

## Endpoints

### cidade/listagem (GET)

### endereco/listagem (GET)

### endereco/criar (POST)
| Atributos     | Tipo    | Obrigatório |
| ------------- |:-------:|:-----------:|
| logradouro    | string  |     Sim     |
| numero        | string  |     Sim     |
| bairro        | string  |     Sim     |
| cidade_id     | integer |     Sim     |

### endereco/{id}/atualizar (POST)
| Atributos     | Tipo    | Obrigatório |
| ------------- |:-------:|:-----------:|
| logradouro    | string  |     Não     |
| numero        | string  |     Não     |
| bairro        | string  |     Não     |
| cidade_id     | integer |     Não     |

### endereco/{id}/deletar (DELETE)

---

## Como instalar

Clonar o repositório

`git clone https://github.com/marlinho20/Teste_Backend_TruckPag.git`

Baixar as dependências

`composer install`

Se não existir '.env' faz seguinte comando

`copy .env.example .env`

Precisa criar banco de dados e configurar banco no '.env'

`php artisan migrate:fresh`

Comando para importar todas cidades do Rio de Janeiro no banco de dados

`php artisan db:seed --class=CitiesSetSeeder`

---

## Testes

### Obs: Depois terminar de rodar os testes precisa usar comando para importar as cidades de novo

`php artisan db:seed --class=CitiesSetSeeder`