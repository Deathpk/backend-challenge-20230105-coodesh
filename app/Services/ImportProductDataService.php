<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Finder\SplFileInfo;

class ImportProductDataService
{
    CONST MAX_IMPORT_PER_FILE = 100;
    private Collection $importedFiles;
    private int $importCount;
    
    public function __construct()
    {
        $this->importedFiles = collect( File::allFiles(public_path('imports/')) );
        $this->importCount = 0;
    }

    public function importFromOpenFoodAttachment(): void
    {
        $this->importedFiles->each(function(SplFileInfo $file) {
            Log::channel('imports')->info("Checando se há novos produtos para importação no arquivo {$file->getFilenameWithoutExtension()}.\n");
            $this->resolveImport($file);
        });
        
        Cache::put(env('IMPORT_CRON_LASTRUN_CACHE_KEY'), Carbon::now());
    }

    private function resolveImport(SplFileInfo &$file): void
    {
        $decodedContent = collect( json_decode($file->getContents()) );
        $decodedContent->each(function(object $fileContent) {
            if($this->importCount === self::MAX_IMPORT_PER_FILE) {
                return;
            }
            $this->importProduct($fileContent);
        });

        Log::channel('imports')->info("{$this->importCount} Novos produtos importados com sucesso.\n");
        $this->importCount = 0;
    }

    private function importProduct(object &$product): void
    {
        if(Product::alreadyExists($product->code)) {
            return;
        }

        try {
            Product::create()->fromImport($product);
            echo "Produto de código {$product->code} importado com sucesso.\n";
            $this->importCount += 1;
        } catch(\Throwable $e) {
            Log::channel('imports')->error(
                "Ocorreu um erro ao importar o produto de código: {$product->code}.\n Erro: {$e->getMessage()}\n Trace: {$e->getTraceAsString()}"
            );
        }
    }
}