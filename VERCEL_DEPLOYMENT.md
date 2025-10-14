# Vercel Deployment Guide for Laravel

## Issue Resolution
The "No Output Directory named 'dist' found" error has been resolved by:

1. **Created `vercel.json`** - Configured Vercel to properly handle Laravel applications
2. **Updated `vite.config.js`** - Specified the correct output directory (`public/build`)
3. **Added build command** - Ensures assets are built during deployment

## Required Environment Variables

Before deploying, you need to set these environment variables in your Vercel dashboard:

### Required Variables:
- `APP_KEY` - Generate with: `php artisan key:generate --show`
- `APP_URL` - Your Vercel app URL (e.g., `https://your-app.vercel.app`)

### Optional Variables (for production):
- `APP_NAME` - Your application name
- `DB_CONNECTION` - Set to `sqlite` (already configured)
- `DB_DATABASE` - Set to `/tmp/database.sqlite` (already configured)

## Steps to Deploy:

1. **Generate Application Key:**
   ```bash
   php artisan key:generate --show
   ```
   Copy the generated key and set it as `APP_KEY` in Vercel.

2. **Set Environment Variables in Vercel:**
   - Go to your Vercel project dashboard
   - Navigate to Settings > Environment Variables
   - Add the required variables listed above

3. **Deploy:**
   - Push your changes to your connected Git repository
   - Vercel will automatically build and deploy using the `vercel.json` configuration

## Build Process:
The `vercel.json` file now includes a build command that:
1. Installs PHP dependencies with Composer
2. Installs Node.js dependencies with npm
3. Builds frontend assets with Vite (outputs to `public/build`)

## File Structure:
- Laravel app files: Root directory
- Built assets: `public/build/` (created during build)
- Entry point: `public/index.php`
- Configuration: `vercel.json`

The configuration ensures Vercel knows how to handle your Laravel application and where to find the built assets.
