# 🚀 Deployment Guide

Panduan lengkap untuk deploy aplikasi Academic & Tech Support ke production server.

---

## 📋 Pre-Deployment Checklist

Sebelum deploy ke production, pastikan:

### ✅ Code Quality
- [ ] Tidak ada debug code atau `dd()` statements
- [ ] Tidak ada `print_r()` atau `var_dump()` di production code
- [ ] Error logging dikonfigurasi dengan baik
- [ ] Security headers sudah di-set
- [ ] CORS sudah dikonfigurasi (jika ada API)

### ✅ Database
- [ ] Database migration sudah tested di local
- [ ] Database backup strategy sudah ada
- [ ] Database user credentials aman
- [ ] Foreign keys & constraints sudah di-test
- [ ] Backup automation sudah setup

### ✅ Security
- [ ] APP_KEY sudah di-generate: `php artisan key:generate`
- [ ] APP_DEBUG = false
- [ ] APP_ENV = production
- [ ] Password hashing algorithm set
- [ ] HTTPS/SSL certificate sudah ready
- [ ] CSRF protection enabled
- [ ] File upload validation complete
- [ ] Admin credentials sudah changed

### ✅ Performance
- [ ] Views/queries sudah optimized
- [ ] Eager loading untuk relationships
- [ ] Caching strategy implemented
- [ ] Database indexes sudah added
- [ ] Static assets sudah minified
- [ ] CDN setup (optional)

### ✅ Monitoring
- [ ] Error tracking setup (Sentry, etc)
- [ ] Performance monitoring setup
- [ ] Log aggregation setup
- [ ] Uptime monitoring setup
- [ ] Alert notifications configured

---

## 🌍 Option 1: Deploy ke Shared Hosting (cPanel)

### Step 1: Prepare Files

```bash
# Local - Bersihkan unnecessary files
rm -rf storage/logs/*
rm -rf bootstrap/cache/*
rm -rf node_modules/
rm -rf .env.local
rm -rf .git (optional)
```

### Step 2: Upload Files

```bash
# Via FTP or File Manager
# Upload semua files ke public_html atau subdomain folder

Structure:
/public_html/
├── app/
├── database/
├── resources/
├── routes/
├── vendor/
├── .env (create after upload)
├── public/ (symlink atau langsung)
└── ... other files
```

### Step 3: Setup Composer

```bash
# SSH ke server
ssh user@yourdomain.com

# Navigate ke project
cd public_html

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate key
php artisan key:generate

# Create .env file
cp .env.example .env
# Edit .env dengan production credentials
nano .env
```

### Step 4: Configure Database

```bash
# SSH ke server
mysql -u user -p

# Create database
CREATE DATABASE bantutugas_prod;
CREATE USER 'tugas_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON bantutugas_prod.* TO 'tugas_user'@'localhost';
FLUSH PRIVILEGES;
```

### Step 5: Run Migrations

```bash
# SSH ke server
cd public_html

# Run migrations
php artisan migrate --force

# Seed data (first time only)
php artisan db:seed --force

# Create storage symlink
php artisan storage:link
```

### Step 6: Configure Web Server

**For cPanel with Apache:**

1. Go to cPanel → Addon Domains
2. Add your domain
3. Create `.htaccess` in public folder:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Step 7: Setup SSL/HTTPS

```bash
# cPanel → AutoSSL
# atau manual setup dengan Let's Encrypt
```

### Step 8: Configure Permissions

```bash
# SSH ke server
cd public_html

# Set proper permissions
chmod -R 755 .
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/

# Set ownership
chown -R nobody:nobody storage/
chown -R nobody:nobody bootstrap/cache/
```

### Step 9: Test Website

- Visit http://yourdomain.com
- Test homepage load
- Test admin login
- Test order form
- Check error logs

---

## 🐳 Option 2: Deploy dengan Docker

### Step 1: Create Dockerfile

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    mysql-client \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
```

### Step 2: Create docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build: .
    container_name: bantutugas_app
    working_dir: /var/www/html
    volumes:
      - ./:/var/www/html
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
      - DB_HOST=db
    depends_on:
      - db
    networks:
      - laravel

  db:
    image: mysql:8.0
    container_name: bantutugas_db
    environment:
      MYSQL_DATABASE: bantutugas
      MYSQL_USER: tugas_user
      MYSQL_PASSWORD: strong_password
      MYSQL_ROOT_PASSWORD: root_password
    volumes:
      - dbdata:/var/lib/mysql
    networks:
      - laravel

  nginx:
    image: nginx:latest
    container_name: bantutugas_nginx
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www/html
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
      - ./ssl:/etc/nginx/ssl
    depends_on:
      - app
    networks:
      - laravel

volumes:
  dbdata:

networks:
  laravel:
```

### Step 3: Deploy

```bash
# Build dan run
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate --force

# Run seeders
docker-compose exec app php artisan db:seed --force

# Create storage symlink
docker-compose exec app php artisan storage:link
```

---

## ☁️ Option 3: Deploy ke Cloud (AWS/DigitalOcean/Heroku)

### AWS EC2 Deployment

```bash
# 1. Launch EC2 instance (Ubuntu 22.04)
# Choose t3.micro or larger

# 2. Connect via SSH
ssh -i your-key.pem ubuntu@ec2-xxx.amazonaws.com

# 3. Install PHP & Dependencies
sudo apt update
sudo apt install -y php8.2-cli php8.2-fpm php8.2-mysql \
    php8.2-mbstring php8.2-xml php8.2-curl composer

# 4. Install Nginx
sudo apt install -y nginx
sudo systemctl start nginx
sudo systemctl enable nginx

# 5. Install MySQL
sudo apt install -y mysql-server
sudo mysql_secure_installation

# 6. Clone repository
cd /var/www
git clone https://github.com/yourusername/bantutugas.git
cd bantutugas

# 7. Install dependencies
composer install --no-dev --optimize-autoloader

# 8. Setup environment
cp .env.example .env
php artisan key:generate

# 9. Setup database
mysql -u root -p
CREATE DATABASE bantutugas;
# ... setup user and permissions

# 10. Run migrations
php artisan migrate --force
php artisan db:seed --force

# 11. Configure Nginx
sudo nano /etc/nginx/sites-available/bantutugas
# ... add vhost configuration

# 12. Enable site
sudo ln -s /etc/nginx/sites-available/bantutugas /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# 13. Setup SSL with Let's Encrypt
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com

# 14. Set permissions
sudo chown -R www-data:www-data /var/www/bantutugas/storage
sudo chown -R www-data:www-data /var/www/bantutugas/bootstrap/cache
```

### DigitalOcean App Platform

1. Push code ke GitHub
2. Connect GitHub account ke DigitalOcean
3. Create App Platform app
4. Configure environment variables
5. Add MySQL database
6. Deploy

---

## 🔄 Post-Deployment Tasks

### Step 1: Verify Installation

```bash
# SSH ke server
php artisan tinker

# Test database connection
>>> DB::connection()->getPDO()

# Exit
>>> exit
```

### Step 2: Setup Monitoring

```bash
# Install Laravel Telescope (optional)
composer require laravel/telescope

# Publish assets
php artisan telescope:publish

# Migrate
php artisan migrate
```

### Step 3: Setup Logging

Update `.env`:
```env
LOG_CHANNEL=stack
LOG_LEVEL=error
```

### Step 4: Setup Email

Configure SMTP in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=app_password
```

### Step 5: Setup Cron Jobs

```bash
# Add to crontab
crontab -e

# Add this line:
* * * * * cd /var/www/bantutugas && php artisan schedule:run >> /dev/null 2>&1
```

### Step 6: Setup Backups

```bash
# Using Laravel Backup package (install first)
composer require spatie/laravel-backup

# Publish config
php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"

# Schedule backup
* 2 * * * cd /var/www/bantutugas && php artisan backup:run
```

---

## 📊 Monitoring & Maintenance

### Health Check Endpoint

Add to `routes/web.php`:
```php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'database' => DB::connection()->getPDO() ? 'connected' : 'failed'
    ]);
});
```

### Log Monitoring

```bash
# SSH ke server
cd /var/www/bantutugas

# View logs
tail -f storage/logs/laravel.log

# Clear old logs
php artisan logs:clear
```

### Database Maintenance

```bash
# Monthly optimization
php artisan db:seed --class=MaintenanceSeeder

# Backup
mysqldump -u user -p database > backup.sql

# Restore
mysql -u user -p database < backup.sql
```

---

## 🔒 Security Hardening

### After Deployment

```bash
# 1. Change admin password
# Login as admin and change password

# 2. Update APP_KEY
php artisan key:generate

# 3. Disable registration (if needed)
# Edit routes/auth.php to remove register routes

# 4. Setup firewall
# Configure ufw or AWS Security Groups

# 5. Enable HTTPS
# Use certbot/Let's Encrypt

# 6. Hide Laravel version
# Remove X-Powered-By header in nginx config

# 7. Rate limiting
# Configure in config/cache.php

# 8. Security headers
# Add headers in nginx config or .env
```

---

## 🆘 Troubleshooting

### Website Blank (500 Error)

```bash
# Check logs
tail -f storage/logs/laravel.log

# Check permissions
ls -la storage/
ls -la bootstrap/cache/

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### Database Connection Error

```bash
# Check .env credentials
cat .env | grep DB_

# Test connection
php artisan tinker
>>> DB::connection()->getPDO()

# Check MySQL status
sudo systemctl status mysql
```

### Nginx 404 Error

```bash
# Check nginx config
sudo nginx -t

# Reload nginx
sudo systemctl reload nginx

# Check permissions
ls -la public/
```

---

## 📞 Support

For deployment issues:
- Email: support@academictechsupport.com
- WhatsApp: +62-812-3456-7890

---

**Deployment Checklist: 100% ✅**
