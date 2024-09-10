# Порядок розгортання проекту

## Вимоги

Перед початком розгортання проекту переконайтеся, що у вас встановлені наступні компоненти:

- PHP 8.0 або вище
- MySql 5.7
- Composer
- Symfony CLI

## Кроки розгортання

1. **Клонування репозиторію**

   Склонуйте репозиторій на вашу локальну машину:
   ```
   git clone https://github.com/ChesterProg/GuestBook.git
   cd YourProjectName
   ```

2. **Встановлення залежностей**

    Встановіть усі залежності проекту за допомогою Composer:
   ```
    composer install
   ```

3. **Налаштування .env файлу**

   Скопіюйте файл `.env` у `.env.local` та налаштуйте параметри підключення до бази даних:
   ```
   cp .env .env.local
   ```

4. **Створення бази даних**

   Створіть базу даних, використовуючи команду Doctrine:
   Заходим в контейнер
   ```
   docker exec -it php-skeleton  /bin/bash
   php bin/console doctrine:database:create
   ```

5. **Міграція бази даних**

   Виконайте міграції, щоб створити таблиці в базі даних:
   ```
   php bin/console doctrine:migrations:migrate
   ```

6. **Запуск сервера**

   Запустіть вбудований сервер Symfony:
   ```
   symfony server:start
   ```

7. **Перевірка**

   Відкрийте ваш браузер і перейдіть за адресою `http://localhost`, щоб переконатися, що проект працює.

8. **Наповнення данними**

   Відкрийте контейнер PHP та введіть наступне щоб згенерувати 50 записів:
   ```
   php bin/console app:create-test-messages
   ```

9. **Адмін**

   Данні до адмін акаунту:
   `http://localhost/admin/dashboard`
   ```
   Login: admin@admin.com
   Pass: admin
   ```
   