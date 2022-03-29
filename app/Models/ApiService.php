<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperApiService
 */
class ApiService extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'config'
    ];

    protected $casts = [
      'config' => 'array',
    ];

    public function apiLogs(): HasMany
    {
        return $this->hasMany(ApiLog::class);
    }
}
