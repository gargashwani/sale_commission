# Database Documentation

## Database Schema

### Core Tables

1. **users**
   ```sql
   CREATE TABLE users (
       id bigint unsigned NOT NULL AUTO_INCREMENT,
       name varchar(255) NOT NULL,
       email varchar(255) NOT NULL,
       email_verified_at timestamp NULL,
       password varchar(255) NOT NULL,
       remember_token varchar(100) NULL,
       created_at timestamp NULL,
       updated_at timestamp NULL,
       PRIMARY KEY (id),
       UNIQUE KEY users_email_unique (email)
   );
   ```

2. **password_resets**
   ```sql
   CREATE TABLE password_resets (
       email varchar(255) NOT NULL,
       token varchar(255) NOT NULL,
       created_at timestamp NULL,
       KEY password_resets_email_index (email)
   );
   ```

3. **failed_jobs**
   ```sql
   CREATE TABLE failed_jobs (
       id bigint unsigned NOT NULL AUTO_INCREMENT,
       uuid varchar(255) NOT NULL,
       connection text NOT NULL,
       queue text NOT NULL,
       payload longtext NOT NULL,
       exception longtext NOT NULL,
       failed_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
       PRIMARY KEY (id),
       UNIQUE KEY failed_jobs_uuid_unique (uuid)
   );
   ```

4. **personal_access_tokens**
   ```sql
   CREATE TABLE personal_access_tokens (
       id bigint unsigned NOT NULL AUTO_INCREMENT,
       tokenable_type varchar(255) NOT NULL,
       tokenable_id bigint unsigned NOT NULL,
       name varchar(255) NOT NULL,
       token varchar(64) NOT NULL,
       abilities text NULL,
       last_used_at timestamp NULL,
       created_at timestamp NULL,
       updated_at timestamp NULL,
       PRIMARY KEY (id),
       UNIQUE KEY personal_access_tokens_token_unique (token),
       KEY personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id)
   );
   ```

## Migrations

### Creating Migrations
```bash
php artisan make:migration create_table_name
```

### Running Migrations
```bash
# Run all pending migrations
php artisan migrate

# Rollback the last migration
php artisan migrate:rollback

# Rollback all migrations
php artisan migrate:reset

# Rollback and re-run all migrations
php artisan migrate:refresh
```

## Seeders

### Creating Seeders
```bash
php artisan make:seeder TableNameSeeder
```

### Running Seeders
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=TableNameSeeder
```

## Database Relationships

### One-to-One
```php
// In User model
public function profile()
{
    return $this->hasOne(Profile::class);
}

// In Profile model
public function user()
{
    return $this->belongsTo(User::class);
}
```

### One-to-Many
```php
// In User model
public function posts()
{
    return $this->hasMany(Post::class);
}

// In Post model
public function user()
{
    return $this->belongsTo(User::class);
}
```

### Many-to-Many
```php
// In User model
public function roles()
{
    return $this->belongsToMany(Role::class);
}

// In Role model
public function users()
{
    return $this->belongsToMany(User::class);
}
```

## Database Optimization

1. **Indexes**
   - Add indexes to frequently queried columns
   - Use composite indexes for multiple column queries
   - Avoid over-indexing

2. **Query Optimization**
   - Use eager loading for relationships
   - Implement database caching
   - Use database transactions for multiple operations

3. **Maintenance**
   ```bash
   # Optimize tables
   php artisan db:optimize
   
   # Backup database
   php artisan db:backup
   ```

## Database Security

1. **Best Practices**
   - Use prepared statements
   - Implement proper access control
   - Regular backups
   - Encryption of sensitive data
   - Input validation and sanitization

2. **Environment Configuration**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ``` 
