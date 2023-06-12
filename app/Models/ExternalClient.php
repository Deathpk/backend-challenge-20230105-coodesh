<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $alias
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ExternalClient extends Model
{
    use HasApiTokens, HasFactory;
    protected $guarded = [];
}
