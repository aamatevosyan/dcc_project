<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperLawRegistration
 */
class LawRegistration extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_TO_BANK_APPLY = 'to_bank_apply';

    protected $fillable = [
        'id',
        'user_id',
        'law_service_id',
        'status',
        'ind_code',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bankService(): BelongsTo
    {
        return $this->belongsTo(LawService::class);
    }
}
