#!/usr/bin/env bash

# Script pour exécuter les tests PHPUnit avec différentes options
# Usage: ./run-tests.sh [option]

set -e

# Couleurs pour l'affichage
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${BLUE}╔════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   Customer API - Tests PHPUnit         ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════╝${NC}"
echo ""

# Fonction pour afficher l'aide
show_help() {
    echo "Usage: ./run-tests.sh [option]"
    echo ""
    echo "Options:"
    echo "  all         Exécuter tous les tests (défaut)"
    echo "  feature     Exécuter uniquement les tests Feature"
    echo "  unit        Exécuter uniquement les tests Unit"
    echo "  coverage    Exécuter avec rapport de couverture"
    echo "  parallel    Exécuter en parallèle (plus rapide)"
    echo "  watch       Mode watch (relance automatique)"
    echo "  filter      Exécuter un test spécifique (ex: ./run-tests.sh filter CustomerCountryTest)"
    echo "  help        Afficher cette aide"
    echo ""
}

# Vérifier que vendor existe
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW}⚠️  Le dossier vendor n'existe pas. Installation des dépendances...${NC}"
    composer install
fi

# Traiter les arguments
case "${1:-all}" in
    all)
        echo -e "${GREEN}▶ Exécution de tous les tests...${NC}"
        php artisan test
        ;;
    
    feature)
        echo -e "${GREEN}▶ Exécution des tests Feature...${NC}"
        php artisan test --testsuite=Feature
        ;;
    
    unit)
        echo -e "${GREEN}▶ Exécution des tests Unit...${NC}"
        php artisan test --testsuite=Unit
        ;;
    
    coverage)
        echo -e "${GREEN}▶ Exécution avec couverture de code...${NC}"
        php artisan test --coverage --min=70
        ;;
    
    parallel)
        echo -e "${GREEN}▶ Exécution en parallèle...${NC}"
        php artisan test --parallel
        ;;
    
    watch)
        echo -e "${GREEN}▶ Mode watch activé (Ctrl+C pour quitter)...${NC}"
        php artisan test --watch
        ;;
    
    filter)
        if [ -z "$2" ]; then
            echo -e "${YELLOW}⚠️  Veuillez spécifier un nom de test${NC}"
            echo "Exemple: ./run-tests.sh filter CustomerCountryTest"
            exit 1
        fi
        echo -e "${GREEN}▶ Exécution du test: $2${NC}"
        php artisan test --filter="$2"
        ;;
    
    help)
        show_help
        ;;
    
    *)
        echo -e "${YELLOW}⚠️  Option inconnue: $1${NC}"
        show_help
        exit 1
        ;;
esac

echo ""
echo -e "${GREEN}✅ Terminé!${NC}"
