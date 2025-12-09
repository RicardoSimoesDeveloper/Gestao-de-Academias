# 🏋️ Sistema de Gestão de Academias (Multi-Tenant)

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php)
![Vue](https://img.shields.io/badge/Vue.js-3-42b883?style=for-the-badge&logo=vue.js)
![Inertia](https://img.shields.io/badge/Inertia.js-Adapting-blueviolet?style=for-the-badge)
![Multi-Tenant](https://img.shields.io/badge/Multi--Tenant-Stancl%2FTenancy-orange?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

Um moderno **Sistema de Gestão de Academias** desenvolvido em **Laravel 12**, com arquitetura **Multi-Tenant (bancos separados)** utilizando `stancl/tenancy`, e frontend em **Vue 3 + Inertia.js**.

Cada academia (Tenant) possui seu **próprio banco de dados isolado**, garantindo segurança, escalabilidade e alta performance para um ambiente SaaS.

---

## 📑 Índice

- [✨ Recursos](#-recursos)
- [🚀 Tecnologias Utilizadas](#-tecnologias-utilizadas)
- [📦 Estrutura do Projeto](#-estrutura-do-projeto)
- [🛠 Como Instalar e Rodar](#-como-instalar-e-rodar)
- [🌐 Configuração de Domínios Locais](#-configuração-de-domínios-locais)
- [🗄 Banco de Dados e Migrações](#-banco-de-dados-e-migrações)
- [▶️ Execução do Projeto](#️-execução-do-projeto)
- [🔐 Acesso ao Sistema](#-acesso-ao-sistema)
- [📂 Estrutura de Pastas](#-estrutura-de-pastas)
- [🤝 Contribuição](#-contribuição)
- [📄 Licença](#-licença)

---

## ✨ Recursos

- ✔️ Multi-tenancy completo com bancos independentes  
- ✔️ Criação automática de tenants com migrações isoladas  
- ✔️ Painel central (admin) para gerenciar academias  
- ✔️ Painel do tenant para gerenciar alunos, planos e assinaturas  
- ✔️ Autenticação avançada do Laravel 12  
- ✔️ Frontend leve com Vue 3 + Inertia.js  
- ✔️ Estrutura escalável pronta para SaaS  

---

## 🚀 Tecnologias Utilizadas

### **Backend**
- Laravel **12.x**
- PHP **8.2+**
- Stancl/Tenancy
- MySQL

### **Frontend**
- Vue.js 3
- Inertia.js
- Vite
- Tailwind

### **Outros**
- Composer
- Node.js / npm

---

## 📦 Estrutura do Projeto

app/
├── Http/
│ ├── Controllers/
│ │ ├── Central/
│ │ └── Tenant/
| ├── Requests/
│ │ ├── Central/
│ │ └── Tenant/
├── Models/
resources/
├── js/
│ └── Components/
│ └── Layouts/
│ ├── Pages/
│ │ ├── Central/
│ │ └── Tenant/
routes/
├── web.php
└── tenant.php


---

## 🛠 Como Instalar e Rodar

### 1️⃣ Pré-requisitos

Tenha instalado:

- PHP 8.2+
- Composer
- Node.js + npm
- MySQL
- Extensões padrão do Laravel 12

---

### 2️⃣ Instalação

#### **Clone o projeto**

git clone [URL_DO_REPOSITORIO]
cd [NOME_DO_PROJETO]

Instale dependências
composer install
npm install


Configure o .env
cp .env.example .env
php artisan key:generate

3️⃣ Configuração do .env

DB_DATABASE	academia_central	
APP_URL	http://aplicacao.local:8000
APP_DOMAIN	aplicacao.local
TENANT_DB_USERNAME	root

🌐 Configuração de Domínios Locais

Edite seu arquivo hosts:

Windows: C:\Windows\System32\drivers\etc\hosts
Linux: /etc/hosts

127.0.0.1 aplicacao.local
127.0.0.1 academia1.aplicacao.local
127.0.0.1 academia2.aplicacao.local

🗄 Banco de Dados e Migrações
Criar banco central:

Crie o banco academia_central.

Rodar migrações centrais:
php artisan migrate

Rodar seeds para criar usuario central e 2 Tenants:
php artisan db:seed --class=CentralUserSeeder
php artisan db:seed --class=TenantSeeder

Credenciais padrão:

Email: admin@aplicacao.local

Senha: 123456

▶️ Execução do Projeto
Backend (Laravel)
php artisan serve

Frontend (Vite)
npm run dev

🔐 Acesso ao Sistema
Painel Central (Admin)
http://aplicacao.local:8000


Login:

admin@aplicacao.local

password: 123456

Painel da Academia (Tenant)
http://corpus.aplicacao.local:8000 ou acesse direto pelo link no menu Academias
Use contas criadas no banco do tenant.



