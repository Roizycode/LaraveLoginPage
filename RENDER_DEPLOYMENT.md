# Deploy Laravel + Vite to Render

## ✅ **Why Render Instead of Vercel?**

- **Vercel**: Great for static sites, not full PHP applications
- **Render**: Perfect for Laravel with database, authentication, and server-side logic

## 🚀 **Deploy to Render (Recommended)**

### **Step 1: Prepare Your Repository**
Your project is already configured with:
- ✅ `render.yaml` - Render configuration
- ✅ `Procfile` - Web server configuration  
- ✅ `vite.config.js` - Updated for production
- ✅ API routes - Ready to use

### **Step 2: Deploy to Render**

1. **Go to [render.com](https://render.com)**
2. **Connect your GitHub repository**
3. **Select "Web Service"**
4. **Render will auto-detect the `render.yaml` configuration**

### **Step 3: Set Environment Variables**
In Render dashboard, add these environment variables:

**Required:**
- `APP_KEY` - Generate with: `php artisan key:generate --show`
- `APP_URL` - Will be your Render domain (e.g., `https://your-app.onrender.com`)

**Already configured:**
- `APP_ENV` = "production"
- `APP_DEBUG` = "false" 
- `DB_CONNECTION` = "sqlite"
- `DB_DATABASE` = "/opt/render/project/src/database/database.sqlite"

### **Step 4: Deploy!**
Click "Deploy" and Render will:
- Install PHP dependencies
- Install Node.js dependencies  
- Build your Vite assets
- Run database migrations
- Start your Laravel app

## 🔧 **Your API Endpoints**

Once deployed, your API will be available at:
- `https://your-app.onrender.com/api/users`
- `https://your-app.onrender.com/api/users/{id}`

## 📱 **Frontend Usage**

Your JavaScript can now call:
```javascript
// This will work on your Render domain
axios.get('/api/users')

// Or with full URL
axios.get('https://your-app.onrender.com/api/users')
```

## 🎯 **What You Get**

- ✅ Full Laravel application with authentication
- ✅ Database support (SQLite)
- ✅ Vite-built frontend assets
- ✅ API endpoints
- ✅ Automatic deployments from GitHub
- ✅ Free tier available

Your Laravel app will work perfectly on Render! 🚀
