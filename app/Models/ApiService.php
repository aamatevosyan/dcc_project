<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
