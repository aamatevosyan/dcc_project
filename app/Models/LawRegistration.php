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

    public const STATUS_NEW = 0;
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_TO_BANK_APPLY = 2;
    public const STATUS_SUCCESS = 3;

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

    public function lawService(): BelongsTo
    {
        return $this->belongsTo(LawService::class);
    }

    public function getStatusName(): string
    {
        switch ($this->status) {
            case self::STATUS_NEW:
                return 'New Request';
            case self::STATUS_IN_PROGRESS:
                return "Request In Progress";
            case self::STATUS_TO_BANK_APPLY:
                return "To Bank Apply";
            case self::STATUS_SUCCESS:
                return "Request Completed";
            default:
                return "Undefined Request";
        }
    }
}
