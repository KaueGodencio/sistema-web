# 🍽️ Sistema de Gestão de Restaurantes (CRM)

Sistema completo desenvolvido em **Laravel 11**, focado na gestão de fornecedores, produtos e pedidos.

## 🚀 Como Rodar o Projeto

### 1. Pré-requisitos
*   PHP 8.2+
*   Composer
*   MySQL (XAMPP / Laragon)
*   Node.js & NPM (Para compilar os estilos)

### 2. Passo a Passo de Instalação

Abra o terminal na pasta onde deseja o projeto e siga os comandos:

```bash
# 1. Clonar o repositório
git clone https://github.com/KaueGodencio/sistema-web.git
cd sistema-web

# 2. Instalar dependências do PHP
composer install

# 3. Criar o arquivo de configuração (.env)
cp .env.example .env
# Caso esteja no Windows (CMD): copy .env.example .env

# 4. Configurar o Banco de Dados
# Abra o seu .env e verifique se o nome do banco está como 'sistema_web'
# No phpMyAdmin, crie um banco de dados vazio chamado: sistema_web

# 5. Gerar chave de segurança e preparar banco
php artisan key:generate
php artisan migrate
php artisan db:seed --force

# 6. Instalar e compilar o Front-end
npm install
npm run build

# 7. Iniciar o servidor
php artisan serve
```

---

## 🛠️ Tecnologias e Decisões
*   **Back-end**: Laravel 11 (Eloquent ORM, Migrations, Seeders).
*   **Front-end**: Blade Templates com Design Premium Customizado.
*   **UI**: Bootstrap 4.6 + jQuery + DataTables para buscas e filtros dinâmicos.
*   **Segurança**: Validação de dados via Form Requests e proteção contra SQL Injection.

---
Desenvolvido por **Kaue Godencio** para teste técnico de recrutamento.
