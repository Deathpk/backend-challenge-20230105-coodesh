<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
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
        $this->importCount = 99;
    }

    public function importFromOpenFoodAttachment(): void
    {
        $this->importedFiles->each(function(SplFileInfo $file) {
            $this->resolveImport($file);
        });
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

        $this->importCount = 0;
    }

    private function importProduct(object &$product): void
    {
        if(Product::alreadyExists($product->code)) {
            return;
        }

        try {
            Product::create()->fromImport($product);
            $this->importCount += 1;
        } catch(\Throwable $e) {
            // TODO CRIAR EXCEPTION CUSTOMIZADA...
            Log::error($e->getMessage());
        }
    }
}