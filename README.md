# Projeto Laravel + Vue TODO list

Este projeto é composto por duas partes:

- **Backend (Laravel)**: localizado em `api`
- **Frontend (Vue.js + Vite)**: localizado em `frontend`

```plaintext
├── api/    
│   ├── app/
│   │   ├── Http/Controllers/TaskController.php
│   │   └── Models/Task.php
│   ├── config/app.php
│   ├── database/
│   │   ├── factories/TaskFactory.php
│   │   ├── migrations/
│   │   │   ├── 2025_05_11_125002_create_tasks_table.php
│   │   │   └── 2025_05_11_132020_add_columns_to_tasks_table.php
│   │   ├── seeders/
│   │   │   ├── DatabaseSeeder.php
│   │   │   └── TaskSeeder.php
│   ├── routes/api.php
│   └── storage/api-docs/api-docs.json
│
├── frontend/
│   └── src/
│       ├── App.vue
│       ├── components/TaskCard.vue
│       ├── views/TaskList.vue
│       └── router/index.js
```
---

## ✅ Pré-requisitos

Certifique-se de ter os seguintes softwares instalados:

- PHP 8.1+ com extensões comuns (`pdo`, `mbstring`, `openssl`, etc.)
- Composer
- Node.js 18+
- npm ou yarn
- MySQL ou outro banco de dados compatível

---

## 🚀 Como rodar o projeto

### 1. Clonar o repositório

```bash
git clone <url-do-repo>
```
#
# Backend
```bash
cd api

# Instalar dependências PHP
composer install

# Copiar e configurar o arquivo de ambiente
cp .env.example .env
```
 Configurar as variáveis de ambiente (.env) com suas credenciais de banco de dados

### Tratando erros de cors

Laravel já inclui suporte a CORS via middleware. Verifique o arquivo:

backend/config/cors.php
Garanta que os domínios do front estejam permitidos:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['http://localhost:5173'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### Gerar chave da aplicação
php artisan key:generate

### Rodar migrações (e seeds se necessário)
php artisan migrate --seed

### Iniciar o servidor Laravel
php artisan serve

### A API estará disponível em: 
http://localhost:8000

### Swagger
php artisan l5-swagger:generate

### A documentação da API estará em:

http://localhost:8000/api/documentation

#
# Frontend

cd ../frontend

### Instalar dependências JS
npm install

### Rodar em modo de desenvolvimento
npm run dev

### O front estará disponível em: 
http://localhost:5173

### Configurações para integração com o backend:
vite.config.js
```js
server: {
    host: true,
    port: 5173,
    proxy: {
      // Redireciona chamadas /api para o backend Laravel
      '/api': {
        target: 'http://localhost:8000',
        changeOrigin: true,
        rewrite: path => path.replace(/^\/api/, '/api')
      }
    }
  }
```
#
# Respostas para:
* "Como você garantiria a escalabilidade deste
código?"
```
Para garantir a escalabilidade do código, aplicaria o seguinte:

Separação responsabilidades:
O backend (Laravel) e frontend (Vue) já estão separados, o que permite escalar cada parte independentemente — para crescimento modular.

Uso de migrations, seeders:
Isso facilita a replicação e gerenciamento do banco de dados em diferentes ambientes e times.

Camadas bem definidas:
Controllers não devem conter lógica de negócio — usar Services ou Models para separar regras complexas.

Por último, aplicar sempre que possivel o SOLID no desenvolvimento e para operações em lote ou com alto volume, adotar Jobs/Queues do Laravel.

No frontend, componentes como TaskCard.vue e TaskList.vue são reutilizáveis e modulares, o que ajuda a escalar a interface com facilidade, e um bom versionamento e documentação da API, preocupação com documentação, essencial para manutenção e escalabilidade.

Esses pontos são basicos, mas já ajudam para um bom inicio e para o crescimento do projeto.
```


* "Qual princípio do SOLID você aplicou e por quê?"
```
Princípio aplicado: SRP — Single Responsibility Principle (Princípio da Responsabilidade Única)

TaskController.php - foca em requisições HTTP, sem misturar regras de negócio complexas.

Task.php - cuida apenas da camada de acesso a dados e definição de relacionamentos.

Só com esse principio num projeto simples como esse já ajuda a deixar tudo organizado e preparado para novas funcionalidades e crescimento.
```