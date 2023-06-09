<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductsController extends Controller
{
    public function __construct(
        private ProductsService $service = new ProductsService()
    )
    {}

    public function index(): AnonymousResourceCollection
    {
        $perPage = (int) request()->query('perPage', 15);
        return $this->service->listAllProducts($perPage);
    }
    
    public function show(string $code)
    {
        return $this->service->showSpecificProduct($code);
    }

    public function update(string $code, UpdateProductRequest $request): JsonResponse
    {
        $this->service->updateProduct($code, $request->getAttributes());
        return response()->json([
            'success' => true,
            'message' => 'Produto atualizado com sucesso!'
        ]);
    }

    public function destroy(string $code): JsonResponse
    {
        $this->service->deleteProduct($code);
        return response()->json([
            'success' => true,
            'message' => 'Produto inativado com sucesso!'
        ]);
    }
}
