# MCPay Test

## Описание

Проект **MCPay Test** — это Laravel-приложение, предназначенное для демонстрации системы управления пользователями, аутентификации и юнит-тестирования. В данном руководстве описаны шаги по клонированию репозитория, установке зависимостей, настройке окружения, миграции и наполнению базы данных, запуску сервера и тестированию приложения.

## Клонирование репозитория

Для клонирования репозитория на ваше локальное устройство используйте один из следующих методов:

### Клонирование через SSH
```bash
git clone git@github.com:Aldamzhar/mcpay-test.git
```

### Клонирование через HTTPS
```bash
git clone https://github.com/Aldamzhar/mcpay-test.git
```

### После клонирования перейдите в директорию проекта:

```bash
cd mcpay-test
```

### Установка зависимостей
Для загрузки всех необходимых пакетов и зависимостей выполните следующую команду:

```bash
composer install
```

### Настройка конфигурации
Скопируйте файл .env.example в .env

```bash
cp .env.example .env
```

Сгенерируйте ключ приложения:

```bash
php artisan key:generate
```

Настройка базы данных

```bash
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=название_вашей_базы_данных
DB_USERNAME=имя_пользователя
DB_PASSWORD=пароль

```

### Миграции базы данных
```bash
php artisan migrate
```

### Наполнение базы данных

```bash
php artisan db:seed
```

### Юнит-тестирование

```bash
php artisan test
```

### Запуск локального сервера

```bash
php artisan serve
```
