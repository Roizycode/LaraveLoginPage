# Docker Deployment Setup

This project includes automated Docker builds and deployments using GitHub Actions.

## Available Workflows

### 1. GitHub Container Registry (Recommended)
- **File**: `.github/workflows/docker-build.yml`
- **Triggers**: Push to main/develop branches, Pull Requests
- **Registry**: `ghcr.io` (GitHub Container Registry)
- **Authentication**: Uses `GITHUB_TOKEN` (automatically provided)

### 2. Docker Hub
- **File**: `.github/workflows/docker-hub.yml`
- **Triggers**: Push to main branch, version tags
- **Registry**: Docker Hub
- **Authentication**: Requires `DOCKERHUB_USERNAME` and `DOCKERHUB_TOKEN` secrets

### 3. Render Deployment
- **File**: `.github/workflows/render-deploy.yml`
- **Triggers**: After successful Docker build
- **Purpose**: Automatically deploy to Render when new image is available

## Setup Instructions

### Option 1: GitHub Container Registry (Easiest)

1. **No additional setup required** - uses built-in GitHub token
2. Images will be available at: `ghcr.io/YOUR_USERNAME/laravel-login-app`
3. Update `render-docker.yaml` with your actual username
4. Use `render-docker.yaml` instead of `render.yaml` for deployment

### Option 2: Docker Hub

1. Create a Docker Hub account
2. Go to your repository settings → Secrets and variables → Actions
3. Add these secrets:
   - `DOCKERHUB_USERNAME`: Your Docker Hub username
   - `DOCKERHUB_TOKEN`: Your Docker Hub access token
4. Images will be available at: `YOUR_USERNAME/laravel-login-app`

### Option 3: Render with Docker Registry

1. Choose either GitHub Container Registry or Docker Hub
2. Get your Render service ID and API key from Render dashboard
3. Add these secrets to your GitHub repository:
   - `RENDER_SERVICE_ID`: Your Render service ID
   - `RENDER_API_KEY`: Your Render API key
4. Use the appropriate `render-docker.yaml` configuration

## Image Tags

The workflows automatically create these tags:
- `latest` - Latest build from main branch
- `main` - Latest build from main branch
- `develop` - Latest build from develop branch
- `pr-123` - Pull request builds
- `main-abc1234` - Specific commit builds

## Manual Docker Commands

```bash
# Build locally
docker build -t laravel-login-app .

# Run locally
docker run -p 8080:80 laravel-login-app

# Push to registry (after login)
docker tag laravel-login-app ghcr.io/YOUR_USERNAME/laravel-login-app:latest
docker push ghcr.io/YOUR_USERNAME/laravel-login-app:latest
```

## Benefits of Docker Registry Deployment

1. **Faster Deployments**: No need to build from source on Render
2. **Consistent Builds**: Same image tested locally and in production
3. **Version Control**: Easy rollback to previous image versions
4. **Caching**: Better build caching and faster subsequent builds
5. **Multi-Environment**: Same image can be deployed to multiple environments
