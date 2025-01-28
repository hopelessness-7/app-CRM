<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'status',
        'amount',
        'stage',
    ];

    public const STAGE_LEAD = 'lead';                // Лид (первоначальный интерес)
    public const STAGE_NEGOTIATION = 'negotiation';  // Переговоры
    public const STAGE_PROPOSAL = 'proposal';        // Отправлено коммерческое предложение
    public const STAGE_DECISION = 'decision';        // Принятие решения
    public const STAGE_CLOSED_WON = 'closed_won';    // Сделка выиграна
    public const STAGE_CLOSED_LOST = 'closed_lost';  // Сделка проиграна

    public static array $stages = [
        self::STAGE_LEAD,
        self::STAGE_NEGOTIATION,
        self::STAGE_PROPOSAL,
        self::STAGE_DECISION,
        self::STAGE_CLOSED_WON,
        self::STAGE_CLOSED_LOST,
    ];

    public const STATUS_NEW = 'new';                 // Новая сделка
    public const STATUS_IN_PROGRESS = 'in_progress'; // В процессе обработки
    public const STATUS_PENDING = 'pending';         // Ожидает подтверждения
    public const STATUS_CONFIRMED = 'confirmed';     // Подтверждена
    public const STATUS_CANCELLED = 'cancelled';     // Отменена
    public const STATUS_COMPLETED = 'completed';     // Завершена

    public static array $statuses = [
        self::STATUS_NEW,
        self::STATUS_IN_PROGRESS,
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_CANCELLED,
        self::STATUS_COMPLETED,
    ];

    public static function getStages(): array
    {
        return self::$stages;
    }

    public static function getStatuses(): array
    {
        return self::$statuses;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
