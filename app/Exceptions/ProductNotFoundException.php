<?php

namespace App\Exceptions;

class ProductNotFoundException extends AbstractException
{
    public function __construct(string $productCode)
    {
        parent::__construct(
            responseMessage: "Não conseguimos encontrar um produto de código {$productCode} na nossa base de dados. Por favor, confira o código inserido e tente novamente.",
            statusCode: 404
        );
    }
}