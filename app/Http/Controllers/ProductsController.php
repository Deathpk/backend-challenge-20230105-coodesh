<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Exceptions\FailedToListProductException;
use App\Exceptions\FailedToListProductsException;
use App\Exceptions\FailedToUpdateProductException;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
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
        try {
            $perPage = (int) request()->query('perPage', 15);
            return $this->service->listAllProducts($perPage);
        }
        catch(CustomException $e) {
            throw $e;
        }
        catch(\Throwable $e) {
            throw new FailedToListProductsException($e);
        }
    }
    
    public function show(string $code): ProductResource
    {
        try {
            return $this->service->showSpecificProduct($code);
        } 
        catch(CustomException $e) {
            throw $e;
        }
        catch(\Throwable $e) {
            throw new FailedToListProductException($e);
        }
    }

    public function update(string $code, UpdateProductRequest $request): JsonResponse
    {
        try {
            $this->service->updateProduct($code, $request->getAttributes());
            return response()->json([
                'success' => true,
                'message' => 'Produto atualizado com sucesso!'
            ]);
        } catch(CustomException $e) {
            throw $e;
        } catch(\Throwable $e) {
            throw new FailedToUpdateProductException($e);
        }
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
