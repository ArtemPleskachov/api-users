# 🧑‍💼 API Users

A REST API built with Symfony for managing users (CRUD) with simplified Bearer Token authorization.

---

## 🔧 Installation and Setup

### Step 1 – Clone the Repository

```bash
git clone https://github.com/ArtemPleskachov/api-users.git
cd api-users
```

### Step 2 – Copy `.env` and Configure Environment

1. Create a `.env` file based on the example:

```bash
cp .env.example .env
```
> ⚠️ **Note:** Since this is a test project, the `.env.example` file includes all necessary environment variables (including sensitive keys) for quick setup. In a real-world project, you should never expose secrets or API keys in version-controlled `.env.example` files.

2. Configure environment variables:

```dotenv
PROJECT_NAME=api_users
WORKDIR=/app

DB_CONNECTION=mysql
DB_HOST=db_mysql

DB_DATABASE=api-users
DB_USERNAME=dbuser
DB_PASSWORD=pass4dbuser
DB_PORT=3306

HTTP_PORT=80
HTTPS_PORT=443

SECRET_ADMIN_TOKEN=cz90zrWLZtGr95bpc/J23M2hQ4upOAGlGUw5mCSWNRg=
SECRET_USER_TOKEN=slJqYddeoGh0k9xfN/OQzPCSFzjk2sT7CBWh1mmcliM=
SECRET_USER_PUBLIC_ID=3
```

> 🛡 `SECRET_ADMIN_TOKEN` — token with full access  
> 🙍 `SECRET_USER_TOKEN` — token with limited access (only for the assigned `publicId`)  
> 🆔 `SECRET_USER_PUBLIC_ID` — ID of the user assigned to `testUser`
> 
> WORKDIR=/app must match the root path configured in the Nginx server configuration file (e.g. root {WORKDIR}/public;).

---

### Step 3 – Build and Run Docker Containers

```bash
docker-compose up --build -d
```

This will launch:
- **PHP** (Symfony)
- **MySQL**
- **Nginx**

---

### Step 4 – Initialize the Application

Access the PHP container:

```bash
docker exec -it php_{PROJECT_NAME} bash
```

Install PHP dependencies:

```bash
composer install
```

Run migrations:

```bash
php bin/console doctrine:migrations:migrate
```
---

### Step 5 – Load Initial Users (SQL Dump or Fixtures)

To get started quickly with the API right after launching the project, there are two options for loading test users.

#### 🗃 Option 1 — SQL Dump (preferred method)

After the containers are up and running, the database will be automatically populated using the SQL dump.

> 📂 The `dump/users.sql` file includes 10 unique users for testing the API.  
> ⚠️ If the dump is not applied automatically or you encounter issues (e.g., file not found or access denied to `mysql`), use the fallback option below.

#### ✅ Option 2 — Symfony Fixtures (fallback method)

```bash
php bin/console doctrine:fixtures:load
```

> ⚠️ This command will purge the database and generate new test records.  
> It is intended as a backup method in case the SQL dump fails to load.

## 🔐 Authorization

⚠️ This project uses a simplified, **fake authorization** mechanism based on `.env` tokens.  
No user authentication/registration is implemented.

### Authorization Type: Bearer Token

| Token        | Access                                                               |
|--------------|----------------------------------------------------------------------|
| `testAdmin`  | ✅ Full access to GET, POST, PUT, DELETE                              |
| `testUser`   | ✅ GET, PUT — only for their own `publicId`  
|              | ❌ POST, DELETE — not allowed (due to REST limitations and lack of user identity)

---

## 📦 Postman Collection

The Postman collection is located at:

```
/postman/Api-users.postman_collection.json
```

API documentation (if available) can be published with tools like [Postman Documenter](https://documenter.getpostman.com/view/42711876/2sB3B7MtbH).

---
---

## 🔒 Коментар щодо використання `publicId`

Згідно з технічним завданням, у POST-запиті передається `id` користувача.  
Оскільки відповідно до REST-принципів створення ресурсу (`POST`) не повинно вимагати передачі внутрішнього `id`, було прийнято рішення використовувати окреме публічне поле `publicId`.

`publicId` зберігається в базі як унікальне поле, яке надходить у запитах `POST`, `PUT`, `GET`, `DELETE` та слугує зовнішнім ідентифікатором користувача.  
Технічний `id` — автоінкрементне поле, що не експонується через API.

Такий підхід забезпечує:
- ✅ відповідність REST-підходу;
- 🔒 відокремлення внутрішніх структур від публічного API;
- 🔄 гнучкість для майбутніх змін (наприклад, перехід на UUID).

Це рішення прийняте для збереження узгодженості логіки, уникнення порушення best practices і з урахуванням обмеженого часу на уточнення деталей завдання.


## 🛠 Technologies Used

- Symfony 7.x
- PHP 8.3+
- MySQL
- Docker

---

## 👤 Author

**Artem Pleskachov**  
[GitHub Profile](https://github.com/ArtemPleskachov)