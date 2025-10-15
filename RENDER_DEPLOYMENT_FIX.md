# Fix for 419 PAGE EXPIRED Error on Render

## Problem
You're getting "419 | PAGE EXPIRED" error when trying to register or reset password on Render deployment. This is a CSRF token issue.

## Solution

### 1. Update Render Environment Variables
In your Render dashboard, go to your service and add these environment variables:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://laravite-myloginpage.onrender.com
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
DB_CONNECTION=sqlite
DB_DATABASE=/opt/render/project/src/database/database.sqlite
```

### 2. Update Build Command
Change your build command in Render to:
```bash
composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force
```

### 3. Update Start Command
Change your start command to:
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

### 4. Generate New App Key
Run this command locally and add the key to Render:
```bash
php artisan key:generate --show
```

### 5. Database Setup
Make sure your database file is in the correct location:
- Local: `database/database.sqlite`
- Render: `/opt/render/project/src/database/database.sqlite`

## Why This Happens
1. **Session Driver**: Using 'file' driver on Render doesn't work well
2. **CSRF Tokens**: Expire too quickly or aren't properly stored
3. **HTTPS**: Session cookies need secure settings for HTTPS
4. **Database**: Sessions need to be stored in database for production

## After Making Changes
1. Redeploy your service on Render
2. Clear browser cache and cookies
3. Try registering again

The 419 error should be resolved!
