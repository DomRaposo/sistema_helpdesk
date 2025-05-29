# Sistema Helpdesk  
## _Gerencie chamados de suporte de forma simples e eficiente_

[![Laravel](https://img.shields.io/badge/Laravel-Framework-red)](https://laravel.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

O **Sistema Helpdesk** é uma aplicação web desenvolvida em Laravel com autenticação, controle de usuários e gerenciamento de chamados técnicos. Ideal para empresas que precisam organizar a comunicação entre suporte e clientes.

- Abertura e acompanhamento de chamados  
- Respostas internas com controle de status  
- Sistema baseado em camadas (Controller, Service, Repository)  
- Suporte a autenticação com Laravel Sanctum  

---

## ✨ Funcionalidades

- Abertura de chamados por usuários autenticados  
- Resposta a chamados com histórico  
- Enum para status e assuntos  
- Filtros e contadores de chamados por status  
- Cadastro e listagem de usuários  
- Integração com autenticação via Sanctum  

---

## 🛠️ Tecnologias

O projeto usa as seguintes tecnologias:

- [Laravel 10+](https://laravel.com) – Framework PHP  
- [PHP 8+](https://www.php.net/)  
- [MySQL](https://www.mysql.com/) – Banco de dados  
- [Bootstrap](https://getbootstrap.com/) – Estilização de páginas  
- [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum) – Autenticação via API  
- [Composer](https://getcomposer.org/) – Gerenciador de dependências  

---

## 🚀 Instalação

### Pré-requisitos:

- PHP 8.1+  
- Composer  
- MySQL  
- Node.js (opcional para assets)  

### Passos:

```bash
git clone https://github.com/DomRaposo/sistema_helpdesk.git
cd sistema_helpdesk
composer install
cp .env.example .env
php artisan key:generate

