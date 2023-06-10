<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AbstractException extends \Exception implements CustomException
{
    protected string $responseMessage;
    protected string|null $logMessage;
    protected \Throwable|null $thrownException;
    protected int $statusCode;
    protected string|null $exceptionId;

    public function __construct(
        string $responseMessage,
        ?string $logMessage = null, 
        ?\Throwable $thrownException = null, 
        int $statusCode = 500,
        ?string $exceptionId = null
    )
    {
        $this->responseMessage = $responseMessage;
        $this->logMessage = $logMessage;
        $this->thrownException = $thrownException;
        $this->statusCode = $statusCode;
        $this->exceptionId = $exceptionId;

        parent::__construct($this->responseMessage, $this->statusCode);
    }

    public function report(): void
    {
        if($this->logMessage) {
            $exceptionTraceId = $this->exceptionId ? "ID: {$this->exceptionId}" : "";
            $reportMessage = $this->resolveReportedMessage();
            Log::error("{$exceptionTraceId} {$reportMessage}. {$this->resolveDebuggingMessages()}");
        }
    }

    private function resolveReportedMessage(): string
    {
        return $this->getReportMessageForUserEntity();
    }

    private function getReportMessageForUserEntity(): string 
    {
        $userId = Auth::user()->id;
        return "{$this->logMessage}, o erro ocorreu com o usuário de ID : {$userId}";
    }

    private function resolveDebuggingMessages(): string
    {
        if ($this->thrownException) {
            return "\n - Message: {$this->thrownException->getMessage()} \n - Trace: {$this->thrownException->getTraceAsString()}";
        }
        return " ";
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}