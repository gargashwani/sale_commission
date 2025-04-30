# Development Setup Guide

## Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and NPM
- Docker and Docker Compose
- MySQL 5.7 or higher
- Redis

## Installation Steps

1. **Clone the Repository**
   ```bash
   git clone [repository-url]
   cd boylesadmin.com
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update the `.env` file with your local configuration:
   - Database credentials
   - Redis settings
   - Mail configuration
   - Other environment-specific variables

5. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Start Development Servers**
   ```bash
   # Start Docker containers
   docker-compose up -d
   
   # Start Laravel development server
   php artisan serve
   
   # Start webpack dev server
   npm run dev
   ```

## Development Workflow

1. **Code Style**
   - Follow PSR-12 coding standards
   - Use Laravel's coding style guide
   - Run PHP CS Fixer before committing

2. **Testing**
   ```bash
   # Run PHPUnit tests
   php artisan test
   
   # Run specific test file
   php artisan test tests/Feature/YourTest.php
   ```

3. **Asset Compilation**
   ```bash
   # Development
   npm run dev
   
   # Production
   npm run prod
   ```

## Common Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Queue management
php artisan queue:work
php artisan horizon

# Database
php artisan migrate
php artisan migrate:rollback
php artisan db:seed
```

## Troubleshooting

1. **Permission Issues**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

2. **Docker Issues**
   ```bash
   docker-compose down
   docker-compose up -d --build
   ```

3. **Cache Issues**
   ```bash
   php artisan optimize:clear
   ```

## IDE Setup

- Install Laravel IDE Helper
  ```bash
  composer require --dev barryvdh/laravel-ide-helper
  php artisan ide-helper:generate
  ```

- Recommended Extensions:
  - Laravel Artisan
  - PHP Intelephense
  - Vue Language Features
  - ESLint 
