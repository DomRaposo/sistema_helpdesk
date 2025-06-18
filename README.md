<h1 align="center">  
  <img src="https://via.placeholder.com/300x300.png?text=Sistema+Helpdesk" style="margin-top: 10px; height: 300px; width: 300px">
  <p>Sistema Helpdesk</p>
</h1>

<h1> Chamados 🛠️💬 </h1>

Status: Em desenvolvimento 🚧

>
+ **Descrição**:  
  Sistema web para gerenciamento de chamados técnicos com autenticação e controle de status.  
  Estruturado em camadas (Controller, Service, Repository).  
  Autenticação via Laravel Sanctum.
>

### Campos da entidade de chamado:
- id  
- assunto  
- mensagem  
- status (enum)  
- user_id  
- created_at / updated_at

### Para criar um chamado:
- assunto  
- mensagem

### Exemplo: Criar um chamado (POST)
```bash
curl --location --request POST 'http://localhost:8000/api/chamados' --header 'Authorization: Bearer {TOKEN}' --header 'Content-Type: application/json' --data-raw '{
  "assunto": "SUPORTE_TECNICO",
  "mensagem": "Estou com dificuldade para acessar o sistema"
}'
```

### Exemplo: Atualizar status do chamado (PUT)
```bash
curl --location --request PUT 'http://localhost:8000/api/chamados/5' --header 'Authorization: Bearer {TOKEN}' --header 'Content-Type: application/json' --data-raw '{
  "status": "CONCLUIDO"
}'
```

### Exemplo: Listar todos os chamados (GET)
```bash
curl --location --request GET 'http://localhost:8000/api/chamados' --header 'Authorization: Bearer {TOKEN}'
```

### Exemplo: Cancelar chamado (DELETE)
```bash
curl --location --request DELETE 'http://localhost:8000/api/chamados/5' --header 'Authorization: Bearer {TOKEN}'
```

---

<h1> Respostas 📩 </h1>

Funcionalidade que permite adicionar respostas internas a chamados.

| Método | URL                                | Descrição                             |
|--------|------------------------------------|----------------------------------------|
|GET     |/api/chamados/{id}/respostas        |Lista as respostas do chamado           |
|POST    |/api/chamados/{id}/respostas        |Adiciona uma nova resposta ao chamado   |

### Exemplo: Listar respostas
```bash
curl --location --request GET 'http://localhost:8000/api/chamados/5/respostas' --header 'Authorization: Bearer {TOKEN}'
```

### Exemplo: Adicionar resposta
```bash
curl --location --request POST 'http://localhost:8000/api/chamados/5/respostas' --header 'Authorization: Bearer {TOKEN}' --data-raw '{
  "mensagem": "Problema resolvido, sistema acessível."
}'
```

---

<h1> Dashboard 📊 </h1>

Painel com contadores de chamados por status:

- ABERTO  
- RESPONDIDO  
- CONCLUIDO  
- CANCELADO

```json
{
  "ABERTO": 3,
  "RESPONDIDO": 5,
  "CONCLUIDO": 7,
  "CANCELADO": 1
}
```

### 📷 Exemplo do Dashboard com contadores  
![Dashboard](https://via.placeholder.com/800x400.png?text=Dashboard+Contadores)

---

<h1> Autenticação 🔐 </h1>

Autenticação via Laravel Sanctum.

| Método | URL               | Descrição           |
|--------|-------------------|---------------------|
|POST    |/api/login         |Login do usuário     |
|POST    |/api/register      |Registro de usuário  |
|POST    |/api/logout        |Logout (revoga token)|

### Exemplo: Login
```bash
curl --location --request POST 'http://localhost:8000/api/login' --data-raw '{
  "email": "usuario@email.com",
  "password": "12345678"
}'
```

---

<h1> Prints do Sistema 🖼️ </h1>

> Substitua os links de imagem abaixo pelos prints reais do seu projeto.

### Tela de Login
![Tela de Login](https://via.placeholder.com/800x400.png?text=Login)

### Tela de Abertura de Chamado
![Novo Chamado](https://via.placeholder.com/800x400.png?text=Abrir+Chamado)

### Tela de Listagem de Chamados
![Lista de Chamados](https://via.placeholder.com/800x400.png?text=Chamados)

### Tela de Respostas
![Respostas](https://via.placeholder.com/800x400.png?text=Respostas)

---

<h1> Tecnologias Utilizadas 🔧 </h1>

- [Laravel 10+](https://laravel.com/)  
- [PHP 8.1+](https://www.php.net/)  
- [MySQL](https://www.mysql.com/)  
- [Composer](https://getcomposer.org/)  
- [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum)

---

<h1> Instalação Local 💻 </h1>

### Pré-requisitos:
- PHP 8.1+  
- Composer  
- MySQL

### Passos:

```bash
git clone https://github.com/DomRaposo/sistema_helpdesk.git
cd sistema_helpdesk
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

<h1> Licença 📄 </h1>

Este projeto está licenciado sob a licença [MIT](https://opensource.org/licenses/MIT).
