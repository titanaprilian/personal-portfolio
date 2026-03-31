<div align="center">

# 🧑‍💻 titanaprilian — Personal Portfolio

[![Laravel](https://img.shields.io/badge/Laravel-v12-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-v4-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/license-MIT-green?style=flat-square)](LICENSE)

A personal portfolio and blog built with Laravel — showcasing projects, writing, and professional experience.

**🌐 [titanic.my.id](https://titanic.my.id)**

</div>

---

## About

This is a full-stack personal portfolio web application serving as a project showcase, blog platform, and CV replacement. Built and maintained by [@titanaprilian](https://github.com/titanaprilian).

---

## Features

- **Project Showcase** — list of projects with detail pages, category/tag filtering, and a featured section that highlights up to 3 key projects
- **Blog** — writing with rich text support (EasyMDE), categories, tags, search, and reading time
- **About & CV** — about page and downloadable resume PDF managed through the admin panel
- **Contact Form** — public contact form with messages stored and viewable in the admin panel
- **Admin Panel** — full CRUD for projects, blog posts, skills, experiences, contacts, and resume uploads; protected by authentication
- **Inline Order Editing** — drag-free reordering of projects and blog posts directly from the admin table
- **Dark Mode** — UI supports light and dark themes across admin and public pages

---

## Tech Stack

| Layer            | Technology                        |
| ---------------- | --------------------------------- |
| Language         | PHP 8.3                           |
| Framework        | Laravel 12                        |
| Authentication   | Laravel Breeze 2                  |
| Frontend         | Blade, Alpine.js, Tailwind CSS v4 |
| Rich Text Editor | EasyMDE                         |
| Build Tool       | Vite                              |
| Testing          | PHPUnit 11                        |
| Code Style       | Laravel Pint                      |
| Database         | MySQL                             |

---

## Getting Started

### Prerequisites

- PHP >= 8.3
- Composer
- Node.js & npm
- MySQL

### Installation

```bash
# Clone the repository
git clone https://github.com/titanaprilian/personal-portfolio.git
cd personal-portfolio

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file and configure it
cp .env.example .env
php artisan key:generate

# Run database migrations and seed
php artisan migrate
php artisan db:seed

# Build frontend assets
npm run build

# Start the development server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

### Development Commands

```bash
# Start Vite dev server (hot reload)
npm run dev

# Run tests
php artisan test

# Format code
vendor/bin/pint
```

### Admin Panel

After creating an account, access the admin panel at `/admin`.

---

## Deployment

A `bundle.sh` script is available to package the app into a `.zip` ready for cPanel shared hosting, with `public_html/` separated from the Laravel app root.

```bash
bash bundle.sh
```

---

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Admin panel controllers
│   └── Public/         # Public-facing controllers
├── Models/             # Eloquent models
└── Rules/              # Custom validation rules
database/
├── migrations/         # Database migrations
└── seeders/            # Database seeders
resources/
└── views/
    ├── components/
    │   └── admin/      # Reusable admin Blade components
    └── public/         # Public-facing views
routes/
├── web.php
└── auth.php
tests/
├── Feature/            # Feature tests
└── Unit/               # Unit tests
```

---

## License

This project is open-sourced under the [MIT License](LICENSE).

---

<div align="center">
  <sub>Built by <a href="https://github.com/titanaprilian">@titanaprilian</a> · <a href="https://titanic.my.id">titanic.my.id</a></sub>
</div>
