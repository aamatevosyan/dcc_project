<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankService extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'api_service_id',
        'name',
        'slug',
        'config'
    ];

    protected $casts = [
        'config' => 'array',
    ];

    public function apiService(): BelongsTo
    {
        return $this->belongsTo(ApiService::class);
    }
}
