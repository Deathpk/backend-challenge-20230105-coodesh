<?php

namespace App\Services;

use App\Exceptions\ProductNotFoundException;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class ProductsService
{

    public function listAllProducts(int $perPage): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::paginate($perPage));
    }

    public function showSpecificProduct(string $code): ProductResource 
    {
        $foundProduct = Product::where('code', $code)->first();
        if(!$foundProduct) {
            throw new ProductNotFoundException($code);
        }

        return new ProductResource($foundProduct);
    }

    public function updateProduct(string $code, Collection $attributes): void
    {
        $foundProduct = Product::where('code', $code)->first();
        if(!$foundProduct) {
            throw new ProductNotFoundException($code);
        }

        $foundProduct->updateFromCollection($attributes);
    }

    public function deleteProduct(string $code): void
    {
        $foundProduct = Product::where('code', $code)->first();
        if(!$foundProduct) {
            throw new ProductNotFoundException($code);
        }

        $foundProduct->inactivate();
    }
}