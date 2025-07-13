# Laravel Booking System

A comprehensive booking management system built with Laravel, featuring user authentication, booking management, admin dashboard, and real-time notifications.

## Features

- **User Authentication**: Registration, login, and profile management
- **Booking Management**: Create, edit, view, and cancel bookings
- **Admin Dashboard**: Manage users, bookings, and system statistics
- **Real-time Notifications**: Email notifications for booking confirmations
- **Responsive Design**: Modern UI built with Tailwind CSS
- **Calendar Integration**: Visual booking calendar interface

## Live Demo

**🚀 Live Application**: [Your Railway URL will be here after deployment]

## Deployment Guide

This application has been deployed using **Railway** for easy and reliable hosting.

### Deployment Steps Followed

1. **Platform Selection**: Chose Railway for its simplicity, free tier, and excellent Laravel support
2. **Configuration Files Created**:
   - `railway.json`: Railway-specific configuration
   - `nixpacks.toml`: Build configuration for PHP and Node.js
   - `Procfile`: Process definition for Railway
   - `.env.example`: Production environment template

3. **Build Process**:
   - PHP 8.2 with all necessary extensions
   - Composer dependencies installation
   - Node.js 20 for asset compilation
   - Vite build for CSS/JS assets
   - Laravel optimization commands

4. **Database Setup**: Using SQLite for simplicity (can be upgraded to PostgreSQL/MySQL)

### Deployment Instructions

#### Option 1: Deploy to Railway (Recommended)

1. **Install Railway CLI**:
   ```bash
   npm install -g @railway/cli
   ```

2. **Login to Railway**:
   ```bash
   railway login
   ```

3. **Initialize Railway Project**:
   ```bash
   railway init
   ```

4. **Deploy the Application**:
   ```bash
   railway up
   ```

5. **Set Environment Variables**:
   - Go to your Railway dashboard
   - Navigate to your project
   - Add the following environment variables:
     ```
     APP_ENV=production
     APP_DEBUG=false
     APP_URL=https://your-app-name.railway.app
     DB_CONNECTION=sqlite
     DB_DATABASE=/tmp/database.sqlite
     ```

6. **Run Database Migrations**:
   ```bash
   railway run php artisan migrate --force
   ```

7. **Generate Application Key**:
   ```bash
   railway run php artisan key:generate
   ```

8. **Seed the Database** (Optional):
   ```bash
   railway run php artisan db:seed --force
   ```

#### Option 2: Deploy to Heroku

1. **Install Heroku CLI**
2. **Create Heroku App**:
   ```bash
   heroku create your-booking-app
   ```

3. **Add Buildpacks**:
   ```bash
   heroku buildpacks:add heroku/php
   heroku buildpacks:add heroku/nodejs
   ```

4. **Set Environment Variables**:
   ```bash
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   heroku config:set APP_URL=https://your-app-name.herokuapp.com
   ```

5. **Deploy**:
   ```bash
   git push heroku main
   ```

6. **Run Migrations**:
   ```bash
   heroku run php artisan migrate --force
   ```

#### Option 3: Shared Hosting

1. **Upload Files**: Upload all project files to your hosting directory
2. **Set Permissions**:
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   chmod 644 .env
   ```
3. **Configure Database**: Update `.env` with your hosting database credentials
4. **Run Commands**: Execute via SSH or hosting control panel:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Environment Configuration

#### Production Environment Variables

```env
APP_NAME="Laravel Booking System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=sqlite
DB_DATABASE=/tmp/database.sqlite

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Local Development Setup

1. **Clone the Repository**:
   ```bash
   git clone <repository-url>
   cd finalproject
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Asset Compilation**:
   ```bash
   npm run dev
   ```

6. **Start Development Server**:
   ```bash
   php artisan serve
   ```

### Troubleshooting

#### Common Issues and Solutions

1. **Storage Permissions Error**:
   ```bash
   chmod -R 775 storage/
   chmod -R 775 bootstrap/cache/
   ```

2. **Asset Loading Issues**:
   - Ensure `npm run build` completed successfully
   - Check that `public/build` directory exists
   - Verify Vite configuration in `vite.config.js`

3. **Database Connection Issues**:
   - Verify database credentials in `.env`
   - Ensure database server is running
   - Check database permissions

4. **Mail Configuration**:
   - Update SMTP settings in `.env`
   - Test email functionality with `php artisan tinker`

### Security Considerations

- ✅ Environment variables properly configured
- ✅ Debug mode disabled in production
- ✅ HTTPS enforced
- ✅ Database credentials secured
- ✅ File permissions set correctly
- ✅ CSRF protection enabled
- ✅ Input validation implemented

### Performance Optimization

- ✅ Route caching enabled
- ✅ Config caching enabled
- ✅ View caching enabled
- ✅ Asset compilation optimized
- ✅ Database queries optimized
- ✅ Composer autoloader optimized

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For deployment issues or questions, please refer to:
- [Railway Documentation](https://docs.railway.app/)
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
