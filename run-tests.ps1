# Script PowerShell pour exécuter les tests PHPUnit
# Usage: .\run-tests.ps1 [option]

param(
    [Parameter(Position=0)]
    [string]$Command = "all",
    
    [Parameter(Position=1)]
    [string]$Filter = ""
)

# Couleurs
function Write-ColorOutput($ForegroundColor) {
    $fc = $host.UI.RawUI.ForegroundColor
    $host.UI.RawUI.ForegroundColor = $ForegroundColor
    if ($args) {
        Write-Output $args
    }
    $host.UI.RawUI.ForegroundColor = $fc
}

Write-ColorOutput Cyan "╔════════════════════════════════════════╗"
Write-ColorOutput Cyan "║   Customer API - Tests PHPUnit         ║"
Write-ColorOutput Cyan "╚════════════════════════════════════════╝"
Write-Host ""

# Fonction d'aide
function Show-Help {
    Write-Host "Usage: .\run-tests.ps1 [option]"
    Write-Host ""
    Write-Host "Options:"
    Write-Host "  all         Exécuter tous les tests (défaut)"
    Write-Host "  feature     Exécuter uniquement les tests Feature"
    Write-Host "  unit        Exécuter uniquement les tests Unit"
    Write-Host "  coverage    Exécuter avec rapport de couverture"
    Write-Host "  parallel    Exécuter en parallèle (plus rapide)"
    Write-Host "  filter      Exécuter un test spécifique (ex: .\run-tests.ps1 filter CustomerCountryTest)"
    Write-Host "  help        Afficher cette aide"
    Write-Host ""
}

# Vérifier que vendor existe
if (-not (Test-Path "vendor")) {
    Write-ColorOutput Yellow "⚠️  Le dossier vendor n'existe pas. Installation des dépendances..."
    composer install
}

# Traiter les commandes
switch ($Command) {
    "all" {
        Write-ColorOutput Green "▶ Exécution de tous les tests..."
        php artisan test
    }
    
    "feature" {
        Write-ColorOutput Green "▶ Exécution des tests Feature..."
        php artisan test --testsuite=Feature
    }
    
    "unit" {
        Write-ColorOutput Green "▶ Exécution des tests Unit..."
        php artisan test --testsuite=Unit
    }
    
    "coverage" {
        Write-ColorOutput Green "▶ Exécution avec couverture de code..."
        php artisan test --coverage --min=70
    }
    
    "parallel" {
        Write-ColorOutput Green "▶ Exécution en parallèle..."
        php artisan test --parallel
    }
    
    "filter" {
        if ([string]::IsNullOrEmpty($Filter)) {
            Write-ColorOutput Yellow "⚠️  Veuillez spécifier un nom de test"
            Write-Host "Exemple: .\run-tests.ps1 filter CustomerCountryTest"
            exit 1
        }
        Write-ColorOutput Green "▶ Exécution du test: $Filter"
        php artisan test --filter=$Filter
    }
    
    "help" {
        Show-Help
    }
    
    default {
        Write-ColorOutput Yellow "⚠️  Option inconnue: $Command"
        Show-Help
        exit 1
    }
}

Write-Host ""
Write-ColorOutput Green "✅ Terminé!"
