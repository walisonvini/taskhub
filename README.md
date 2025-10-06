# Taskhub

## Description

TaskHub is an application to manage tasks in an organized way, with status control, priority, and data export. It supports multiple users within companies (multi-tenant) with an intuitive interface.

## Technologies

- Vue.js 2
- Laravel 8
- MySQL

## ✨ Implemented Bonus Requirements

### 🏢 User Creation
- ✅ **Interactive command**: Implemented `setup:first-company` command to register the first company and first user interactively

### 📧 Queues and Emails
- ✅ **Queue system**: Full implementation with Laravel Queues
- ✅ **Asynchronous emails**: Emails sent using queues for better performance
- ✅ **Optimized backend**: Redis used as the queue driver for high performance

### 📊 File Export
- ✅ **CSV export**: Complete system for exporting tasks to CSV
- ✅ **Asynchronous generation**: Files generated in the background using queues
- ✅ **Download available**: Interface to download exported files
- ✅ **Progress status**: Tracking export status (pending, processing, completed, error)

### 🐳 Docker
- ✅ **Complete containerization**: Entire project configured with Docker
- ✅ **Multi-container**: Separation of services (PHP, Node.js, Redis, MySQL)

## 💻 Prerequisites
* **Docker** `^24.0`
* **Docker Compose** `^2.0`

## 🐋 Installation

1. Copy the .env file (inside the backend folder)
```bash
cd backend
cp .env.example .env
```

2. Build the Docker images
```bash
docker compose build
```

3. Start the containers
```bash
docker compose up -d
```

4. Access the application container
```bash
docker exec -it taskhub_php bash
```

5. Install PHP dependencies
```bash
composer install
```

6. Generate the Laravel key
```bash
php artisan key:generate
```

7. Generate the JWT secret
```bash
php artisan jwt:secret
```

8. Run the migrations
```bash
php artisan migrate
```

9. Seed the database
```bash
php artisan db:seed
```

10. Run the queues (in a new terminal)
```bash
docker exec -it taskhub_php php artisan queue:work
```

11. Access the application
```bash
# Open your browser and go to:
http://localhost:8080
```

12. To test emails, Mailpit was used (captures emails in development)
```bash
# Open Mailpit web interface to view sent emails
http://localhost:8025
```