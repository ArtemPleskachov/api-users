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
docker exec -it api-users-php bash
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

### Step 5 – Load Fixtures (optional)

```bash
php bin/console doctrine:fixtures:load
```

⚠️ This will purge the database and create 12 unique users.

---

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

- Symfony 6.x
- PHP 8.3+
- MySQL
- Docker

---

## 👤 Author

**Artem Pleskachov**  
[GitHub Profile](https://github.com/ArtemPleskachov)