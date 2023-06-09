<?php

namespace App\Exceptions;

use App\Exceptions\CustomException;

class ProductNotFoundException extends \Exception implements CustomException
{
    private int $statusCode = 404;

    public function __construct(string $productCode)
    {
        parent::__construct(
            "Não conseguimos encontrar um produto de código {$productCode} na nossa base de dados. Por favor, confira o código inserido e tente novamente."
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}