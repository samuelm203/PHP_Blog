# PHP Blog

A lightweight blogging platform built with vanilla PHP and a simple MVC-like structure. It supports user authentication, creating posts with optional images, profile pages, a friends page, and more — designed to run locally with XAMPP.

> Last updated: 2025-12-11 21:39 (local)


## ✨ Features

- User signup, login, logout
- Create and read blog posts (optional image URL validation)
- Profile page and friends page
- Basic password reset flow
- Clean views with a shared header/footer template
- Simple routing via `routes.php`


## 🧱 Tech Stack

- PHP (vanilla)
- MySQL (via PDO)
- HTML/CSS
- XAMPP for local development

Notes:
- No Composer or NPM package manager is used in this project at the moment.
- Credentials are currently stored in code (see `blog\core\database.php`). For better security, prefer environment variables or a local, non-versioned config file.

## ⚠️ Important Note on Database Connections (Dec 11, 2025)

- Database connections and related settings are adjusted locally but are intentionally not committed to this repository (no sensitive credentials in VCS).
- To run the project locally, update your credentials in `blog\core\database.php`, or preferably, use environment variables or a non-versioned configuration file.
- If you pull updates and a DB connection is missing, that is expected: provide your own local credentials.

## 🗄️ Database Setup & Schema

This app uses MySQL via PDO. Below is a minimal schema that works with the current feature set (users, posts, and a simple friends list). Adjust names as needed.

Recommended database and user (local):

```
CREATE DATABASE IF NOT EXISTS blog_samuel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'blog_user'@'localhost' IDENTIFIED BY 'change_me';
GRANT ALL PRIVILEGES ON blog_samuel.* TO 'blog_user'@'localhost';
FLUSH PRIVILEGES;
```

Tables:

```
-- Users
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Posts
CREATE TABLE IF NOT EXISTS posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  title VARCHAR(150) NOT NULL,
  body TEXT NOT NULL,
  image_url VARCHAR(500) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_posts_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_posts_user_created (user_id, created_at)
) ENGINE=InnoDB;

-- Friends (simple directed relation; store one row per friendship direction)
CREATE TABLE IF NOT EXISTS friends (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  friend_user_id INT UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_friends_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_friends_friend FOREIGN KEY (friend_user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY uq_user_friend (user_id, friend_user_id)
) ENGINE=InnoDB;
```

Seed (optional):

```
INSERT INTO users (username, email, password_hash) VALUES
('demo', 'demo@example.com', '$2y$10$KXjv7u1q8Q0G1sY1XWmQhec2q9mY7ZyFQe7b8oY3m5Q9w8TQYf19a'); -- use your own bcrypt
```

Connection values should match what you configure in `blog\core\database.php` (host, db name, user, password).

## ✅ Requirements

- XAMPP (Apache + MySQL)
- PHP with PDO MySQL driver enabled
- A MySQL database you can connect to (local or remote)


## 🗂️ Project Structure

```
C:\xampp\htdocs\
├─ README.md                # This file (repo root)
└─ blog\
   ├─ core\
   │  ├─ database.php          # DB connection (PDO)
   │  └─ logout.php            # Ends the session
   ├─ css\
   │  └─ styles.css            # Global styles
   ├─ images\
   │  ├─ 404.png               # 404 illustration
   │  └─ 503.png               # 503 illustration / placeholder
   ├─ models\                  # Page handlers / data access
   │  ├─ blog_model.php
   │  ├─ home_model.php
   │  ├─ login_model.php
   │  ├─ profil_model.php
   │  ├─ resetpassword_model.php
   │  ├─ seemyblogpost_model.php
   │  ├─ signup_model.php
   │  └─ write_model.php
   ├─ views\
   │  ├─ 404_view.php
   │  ├─ about_view.php
   │  ├─ blog_view.php
   │  ├─ friends_view.php
   │  ├─ home_view.php
   │  ├─ login_view.php
   │  ├─ notfinished_view.php
   │  ├─ profil_view.php
   │  ├─ signup_view.php
   │  ├─ write_view.php
   │  └─ templates\
   │     ├─ header.php
   │     └─ footer.php
   ├─ index.php                # Front controller / entry point
   └─ routes.php               # Route definitions
```


## 📊 Project Statistics

Static counts based on the repository at the time of writing (snapshot):

- Total files in `blog/`: 27
- PHP files in `blog/`: 24
- CSS files: 1
- Image assets: 2
- Models: 8
- Views (including templates): 12

## 🚀 Getting Started (Local with XAMPP)

1. Place the project under your XAMPP `htdocs` folder as `C:\xampp\htdocs\blog`.
2. Ensure Apache and MySQL are running via XAMPP Control Panel.
3. Create a MySQL database and user. Update DB credentials in `blog\core\database.php` if needed.
4. Import the schema shown in the “Database Setup & Schema” section (tables: `users`, `posts`, `friends`).
5. Open in the browser: `http://localhost/blog/`

Entry point: `blog\index.php` loads `blog\routes.php`, which includes the appropriate view based on the URL segment.


## 🔐 Configuration

- Database connection is handled by `blog\core\database.php` via helpers `connectToLocalDatabase()` and `connectToDatabase()` (PDO).
- Sessions are used to track user authentication (`$_SESSION['user_id']`).

Important:
- Local credentials are intentionally not committed. After cloning or pulling, open `blog\core\database.php` and set your own host, database name, username, and password.
- Alternatively, externalize credentials via environment variables or a local, ignored config file (see next section).


## 🧭 Main Pages

Common routes/pages in this project include:

- Home: `/`
- Blog/Read: `/blog` or `/read`
- Write: `/write`
- Login: `/login`
- Signup: `/signup`
- Profile: `/profil`
- Friends: `/friends`
- About: `/about`
- 404: `/404`

Note: Actual paths are defined in `blog\routes.php`.

## 📜 Routes and Entry Points

- Front controller: `blog\index.php`
- Router: `blog\routes.php`
- Routing strategy: checks the last segment of `REQUEST_URI` and includes the corresponding view or handler.
- Examples:
  - `/blog` → home (`views/home_view.php`)
  - `/blog/login` → login view
  - `/blog/profil` → profile view (requires session)
  - Unmatched → `views/404_view.php` with HTTP 404

## 📦 Scripts / Package Management

- There are currently no package manager scripts (no Composer, no NPM). All PHP is run by Apache via XAMPP.
- Common developer actions:
  - Start Apache and MySQL in XAMPP
  - Open `http://localhost/blog/`


## 🛠️ Development Notes

- Input is sanitized using `htmlspecialchars()` and server-side checks before DB writes.
- Image field for posts may accept a URL and can be validated (e.g., with `getimagesize()` in the model layer if implemented).
- Views are composed with `views\templates\header.php` and `views\templates\footer.php`.

## 🔧 Environment Variables

Currently, database credentials are hard-coded in `blog\core\database.php` for both local and remote connections. To improve security and portability, you can move these to environment variables or a non-versioned config file.

Suggested variables:

```
DB_HOST=localhost
DB_NAME=blog_samuel
DB_USER=root
DB_PASS=
```

Non-committed local configuration:
- Keep your personal DB credentials only on your machine. Do not commit them. Consider adding or keeping any local config files in `.gitignore`.

## 🧪 Tests

There is no automated test suite configured in this repository yet.

Future improvements:
- Add PHPUnit as a dev dependency (via Composer) and configure a basic test bootstrap.
- Add unit tests around models (e.g., input validation) and integration tests for routing.


## 🧪 Quick Manual Test Guide

1. Signup and login flows (invalid inputs, existing users, wrong password).
2. Create a new post with:
   - No image
   - Valid image URL
   - Invalid image URL (should be ignored gracefully)
3. Navigate to Profile and Friends pages.
4. Logout and confirm protected pages redirect to Login.

## 🎉 Cool Facts

- Zero external PHP dependencies — boots fast on a fresh XAMPP install.
- Entire app fits in a few dozen files (about 27 items under `blog/`).
- Pure PHP + PDO: easy to inspect, step through, and learn from.
- Router is intentionally simple: URLs map directly to view handlers defined in `routes.php`.
- Designed for local-first hacking: clone, set DB creds, and you’re live in minutes.

## 📄 License

This project is currently unlicensed. 
