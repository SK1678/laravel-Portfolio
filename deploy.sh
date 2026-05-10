#!/bin/bash
# ============================================================
#  Laravel Deployment Script — meher.logimint.xyz
#  Server Path: ~/public_html/meher
#  Run this on the SERVER via SSH:
#     bash deploy.sh
# ============================================================

set -e  # Exit immediately if any command fails

# --- CONFIG -------------------------------------------------
APP_DIR="$HOME/public_html/meher"
BRANCH="main"
GITHUB_REPO="https://github.com/SK1678/laravel-Portfolio.git"
# ------------------------------------------------------------

echo ""
echo "╔══════════════════════════════════════╗"
echo "║     Laravel Deployment Script        ║"
echo "╚══════════════════════════════════════╝"
echo ""

cd "$APP_DIR" || { echo "❌ Directory $APP_DIR not found!"; exit 1; }

echo "📂 Working directory: $(pwd)"
echo ""

# ── 1. Pull latest code from GitHub ──────────────────────────
echo "🔄 [1/7] Pulling latest code from GitHub ($BRANCH)..."
git fetch --all
git reset --hard origin/$BRANCH
echo "✅ Code updated."
echo ""

# ── 2. Install/update Composer dependencies ──────────────────
echo "📦 [2/7] Installing Composer dependencies (no dev)..."
composer install --no-dev --optimize-autoloader --no-interaction --quiet
echo "✅ Composer done."
echo ""

# ── 3. Clear & cache config/routes/views ─────────────────────
echo "🧹 [3/7] Clearing old cache..."
php artisan optimize:clear
echo ""

echo "⚡ [4/7] Caching config, routes & views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Caches rebuilt."
echo ""

# ── 4. Run migrations (safe — skips already-run ones) ────────
echo "🗄️  [5/7] Running database migrations..."
php artisan migrate --force
echo "✅ Migrations done."
echo ""

# ── 5. Storage link ──────────────────────────────────────────
echo "🔗 [6/7] Linking storage..."
php artisan storage:link --quiet 2>/dev/null || echo "   (link already exists)"
echo "✅ Storage linked."
echo ""

# ── 6. Fix permissions ───────────────────────────────────────
echo "🔐 [7/7] Setting folder permissions..."
chmod -R 755 storage bootstrap/cache
echo "✅ Permissions set."
echo ""

echo "╔══════════════════════════════════════╗"
echo "║  ✅  Deployment Complete!            ║"
echo "║  🌍  https://meher.logimint.xyz      ║"
echo "╚══════════════════════════════════════╝"
echo ""
