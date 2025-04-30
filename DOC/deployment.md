# Deployment Guide

## Production Environment Requirements

- Linux server (Ubuntu 20.04 LTS recommended)
- Nginx
- PHP 8.1 or higher with required extensions
- MySQL 5.7 or higher
- Redis
- Node.js and NPM
- Composer
- Git

## Deployment Steps

1. **Server Preparation**
   ```bash
   # Update system packages
   sudo apt update && sudo apt upgrade -y
   
   # Install required packages
   sudo apt install -y nginx mysql-server redis-server
   sudo apt install -y php8.1-fpm php8.1-mysql php8.1-redis php8.1-curl php8.1-gd php8.1-mbstring php8.1-xml php8.1-zip
   ```

2. **Application Deployment**
   ```bash
   # Clone repository
   git clone [repository-url] /var/www/boylesadmin.com
   cd /var/www/boylesadmin.com
   
   # Install dependencies
   composer install --no-dev --optimize-autoloader
   npm install
   npm run prod
   
   # Set permissions
   sudo chown -R www-data:www-data /var/www/boylesadmin.com
   sudo chmod -R 775 /var/www/boylesadmin.com/storage
   sudo chmod -R 775 /var/www/boylesadmin.com/bootstrap/cache
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   # Edit .env file with production settings
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

5. **Nginx Configuration**
   Create `/etc/nginx/sites-available/boylesadmin.com`:
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       root /var/www/boylesadmin.com/public;
   
       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";
   
       index index.php;
   
       charset utf-8;
   
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
   
       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }
   
       error_page 404 /index.php;
   
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
   
       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```
   ```bash
   sudo ln -s /etc/nginx/sites-available/boylesadmin.com /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl restart nginx
   ```

6. **Queue Worker Setup**
   Create `/etc/supervisor/conf.d/boylesadmin-worker.conf`:
   ```ini
   [program:boylesadmin-worker]
   process_name=%(program_name)s_%(process_num)02d
   command=php /var/www/boylesadmin.com/artisan queue:work redis --sleep=3 --tries=3
   autostart=true
   autorestart=true
   user=www-data
   numprocs=8
   redirect_stderr=true
   stdout_logfile=/var/www/boylesadmin.com/storage/logs/worker.log
   ```
   ```bash
   sudo supervisorctl reread
   sudo supervisorctl update
   sudo supervisorctl start all
   ```

## SSL Configuration

1. **Install Certbot**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   ```

2. **Obtain SSL Certificate**
   ```bash
   sudo certbot --nginx -d your-domain.com
   ```

## Maintenance

1. **Application Updates**
   ```bash
   cd /var/www/boylesadmin.com
   git pull origin main
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   npm install
   npm run prod
   php artisan optimize:clear
   ```

2. **Backup Strategy**
   ```bash
   # Database backup
   mysqldump -u username -p database_name > backup.sql
   
   # Files backup
   tar -czf backup.tar.gz /var/www/boylesadmin.com
   ```

## Monitoring

1. **Log Monitoring**
   ```bash
   # Application logs
   tail -f /var/www/boylesadmin.com/storage/logs/laravel.log
   
   # Nginx logs
   tail -f /var/log/nginx/error.log
   tail -f /var/log/nginx/access.log
   ```

2. **Performance Monitoring**
   - Use Laravel Telescope for application monitoring
   - Set up server monitoring (e.g., New Relic, Datadog)
   - Configure error tracking (e.g., Sentry) 
