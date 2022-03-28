<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperApiLog
 */
class ApiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'api_service_id',
        'request',
        'response',
    ];

    protected $casts = [
        'request' => 'array',
        'response' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function apiService(): BelongsTo
    {
        return $this->belongsTo(ApiService::class);
    }
}
