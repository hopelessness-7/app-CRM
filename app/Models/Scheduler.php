<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Scheduler extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'label',
        'start_date',
        'end_date',
        'all_day',
        'event_url',
        'location',
        'description',
    ];

    public const LABEL_PERSONAL = 'Personal';
    public const LABEL_BUSINESS = 'Business';
    public const LABEL_FAMILY = 'Family';
    public const LABEL_HOLIDAY = 'Holiday';
    public const LABEL_ETC = 'ETC';
    public const LABEL_WEEKEND = 'Weekend';

    public static array $labels = [
        self::LABEL_PERSONAL,
        self::LABEL_BUSINESS,
        self::LABEL_FAMILY,
        self::LABEL_HOLIDAY,
        self::LABEL_ETC,
        self::LABEL_WEEKEND,
    ];

    public const TYPE_VIEW_MONTH = 'month';
    public const TYPE_VIEW_WEEK = 'week';
    public const TYPE_VIEW_DAY = 'day';
    public const TYPE_VIEW_LIST = 'list';

    public static array $typeViews = [
        self::TYPE_VIEW_MONTH,
        self::TYPE_VIEW_WEEK,
        self::TYPE_VIEW_DAY,
        self::TYPE_VIEW_LIST,
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deals(): BelongsToMany
    {
        return $this->belongsToMany(Deal::class, 'deal_schedulers', 'scheduler_id', 'deal_id');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'client_schedulers', 'scheduler_id', 'client_id');
    }

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'worker_schedulers', 'scheduler_id', 'worker_id');
    }
}
