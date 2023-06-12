<?php

namespace App\Console\Commands;

use App\Models\ExternalClient;
use Illuminate\Console\Command;

class GenerateNewApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:generate {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a new API Token. If you want to keep track of what token is which, you can pass an alias just after the artisan command.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $externalClient = ExternalClient::first();
        $token = $externalClient->createToken($this->argument('alias'))->plainTextToken;
        echo "Token criado com sucesso!";
        echo"Token: {$token}";
    }
}
