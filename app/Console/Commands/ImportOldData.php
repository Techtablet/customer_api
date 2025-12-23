<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ImportFromOldServer\ImportOldDataController;

class ImportOldData extends Command
{
    // run the command with: php artisan import:old_data
    protected $signature = 'import:old_data';
    protected $description = 'Importer les data de l\'ancienne base de données vers la nouvelle';

    public function handle()
    {
        $importOldDataController = new ImportOldDataController();
        $this->info('Début de l\'importation des data...');

        $this->importProducts($importOldDataController);
        
        $this->info('Importation terminée.');
    }

    private function importProducts(ImportOldDataController $importOldDataController, $page = 1)
    {
        $importOldDataController->importFromOldDbToNewDB($page);
    }
}
