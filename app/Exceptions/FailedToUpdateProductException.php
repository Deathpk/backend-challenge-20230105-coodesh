<?php

namespace App\Exceptions;

class FailedToUpdateProductException extends AbstractException
{
    public function __construct(\Throwable $thrownException = null)
    {
        $exceptionId = bin2hex(random_bytes(8));
        parent::__construct(
            responseMessage: "Oops, ocorreu um erro inesperado ao atualizar um produto. Por favor, tente novamente mais tarde, caso o problema persista contacte o suporte e informe o seguinte identificador do erro: {$exceptionId}",
            logMessage: "Ocorreu um erro inesperado ao tentar atualizar um produto específico.",
            thrownException: $thrownException,
            exceptionId: $exceptionId
        );
    }
}