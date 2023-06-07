<?php

namespace App\Console\Commands;

use App\Services\ImportProductDataService;
use Illuminate\Console\Command;

class ImportNewProductsFromOpenFood extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a total of 100 new products from each json file defined at public/imports.';

    /**
     * Execute the console command.
     */
    public function handle(ImportProductDataService $service): void
    {
        echo "Iniciando processo de importação de produtos.\n";
        $service->importFromOpenFoodAttachment();
    }
}
