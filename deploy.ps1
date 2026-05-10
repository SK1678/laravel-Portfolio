# ============================================================
#  Laravel Local Deploy Script (Windows PowerShell)
#  Run this from your project root: .\deploy.ps1
#  What it does:
#    1. Commit all local changes with a message
#    2. Push to GitHub (triggers auto-deploy via GitHub Actions)
# ============================================================

param(
    [string]$Message = "deploy: update $(Get-Date -Format 'yyyy-MM-dd HH:mm')"
)

Write-Host ""
Write-Host "╔══════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║     Local → GitHub → Server          ║" -ForegroundColor Cyan
Write-Host "╚══════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""

# ── 1. Stage all changes ─────────────────────────────────────
Write-Host "📁 [1/3] Staging all changes..." -ForegroundColor Yellow
git add .

# ── 2. Commit ────────────────────────────────────────────────
Write-Host "💬 [2/3] Committing: $Message" -ForegroundColor Yellow
git commit -m $Message

if ($LASTEXITCODE -ne 0) {
    Write-Host "ℹ️  Nothing new to commit." -ForegroundColor Gray
}

# ── 3. Push to GitHub (GitHub Actions will deploy) ───────────
Write-Host "🚀 [3/3] Pushing to GitHub (main)..." -ForegroundColor Yellow
git push origin main

Write-Host ""
Write-Host "✅ Pushed! GitHub Actions is now deploying to the server." -ForegroundColor Green
Write-Host "🔍 Monitor at: https://github.com/SK1678/laravel-Portfolio/actions" -ForegroundColor Cyan
Write-Host "🌍 Site: https://meher.logimint.xyz" -ForegroundColor Cyan
Write-Host ""
