# Taskhub

## Descrição

TaskHub é uma aplicação para gerenciar tarefas de forma organizada, com controle de status, prioridade e exportação de dados. Permite múltiplos usuários dentro de empresas (multi-tenant) com interface intuitiva.

## ✨ Requisitos Bônus Implementados

### 🏢 Criação de Usuário
- ✅ **Comando interativo**: Implementado comando `setup:first-company` para cadastrar a primeira empresa e primeiro usuário de forma interativa

### 📧 Filas e E-mails
- ✅ **Sistema de filas**: Implementação completa com Laravel Queues
- ✅ **E-mails assíncronos**: Envio de e-mails utilizando filas para melhor performance
- ✅ **Banco otimizado**: Utilização de Redis como driver de filas para alta performance

### 📊 Exportação de Arquivos
- ✅ **Exportação CSV**: Sistema completo de exportação de tarefas em formato CSV
- ✅ **Geração assíncrona**: Arquivos gerados em background utilizando filas
- ✅ **Download disponível**: Interface para download dos arquivos exportados
- ✅ **Status de progresso**: Acompanhamento do status da exportação (pendente, processando, concluído, erro)

### 🐳 Docker
- ✅ **Containerização completa**: Todo o projeto configurado com Docker
- ✅ **Multi-container**: Separação de serviços (PHP, Node.js, Redis, MySQL)

## 💻 Pré-requisitos
* **Docker** `^24.0`
* **Docker Compose** `^2.0`

## 🐋 Instalação

1. Copie o arquivo .env (dentro da pasta backend)
```bash
cd backend
cp .env.example .env
```

2. Construa as imagens Docker
```bash
docker compose build
```

3. Inicie os containers
```bash
docker compose up -d
```

4. Acesse o container da aplicação
```bash
docker exec -it taskhub_php bash
```

5. Instale as dependências PHP
```bash
composer install
```

6. Gere a chave do Laravel
```bash
php artisan key:generate
```

7. Gere a chave JWT
```bash
php artisan jwt:secret
```

8. Execute as migrações
```bash
php artisan migrate
```

9. Popule o banco de dados
```bash
php artisan db:seed
```

10. Execute as filas (em um novo terminal)
```bash
docker exec -it taskhub_php php artisan queue:work
```

11. Acesse a aplicação
```bash
# Abra seu navegador e navegue para:
http://localhost:8080
```

12. Para testar os emails, usei o Mailpit (intercepta emails em desenvolvimento)
```bash
# Acesse a interface web do Mailpit para ver os emails sendo enviados
http://localhost:8025
```