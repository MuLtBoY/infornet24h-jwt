# Infornet24H JWT

Sistema para **assistência veicular 24 horas**, permitindo **busca de prestadores de serviço** que forneçam suporte para veículos em situações emergenciais.  
O projeto utiliza **Laravel 12**, **PHP 8.4**, **MySQL 8** e **Docker (Laravel Sail)** para simplificar o ambiente de desenvolvimento.

---

## 🚀 Tecnologias Utilizadas

- [Laravel 12](https://laravel.com)
- [PHP 8.4](https://www.php.net)
- [MySQL 8](https://www.mysql.com)
- [Docker + Laravel Sail](https://laravel.com/docs/sail)
- [JWT Auth](https://jwt.io) para autenticação

---

## 📋 Pré-requisitos

Certifique-se de ter instalado em sua máquina:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Composer](https://getcomposer.org/)

---

## ⚡ Passos para rodar o projeto localmente

1. **Clonar o repositório**
   ```bash
   git clone <URL_DO_REPOSITORIO>

2. **Entrar na pasta do projeto**
   ```bash
   cd infornet24h-jwt

3. **Copiar o arquivo .env.example para .env**
   ```bash
   cp .env.example .env

4. **Instalar dependências do PHP via Composer**
   ```bash
   composer install

5. **Subir o ambiente Docker com Laravel Sail**
   ```bash
   ./vendor/bin/sail up -d

6. **Gerar a chave da aplicação**
   ```bash
   ./vendor/bin/sail artisan key:generate

7. **Configurar variáveis de banco de dados no .env**
   ```bash
   DB_HOST=mysql
   DB_PASSWORD=password

8. **Executar migrations com seeders**
   ```bash
   ./vendor/bin/sail artisan migrate:fresh --seed

9. **Gerar a chave JWT para autenticação**
   ```bash
   ./vendor/bin/sail artisan jwt:secret

10. **Configurar credenciais da API da Infornet**
    ```bash
    Adicione ao .env:
    USERINFORNET=seu_usuario
    PASSWORDINFORNET=sua_senha

## 📡 Endpoints da API

- **Autenticação JWT**
- **Cadastro e consulta de prestadores**
- **Integração com API da Infornet**
