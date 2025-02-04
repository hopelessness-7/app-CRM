<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationType extends Model
{
    use HasFactory;

    protected $fillable = ['type'];

    public $timestamps = false;

    // Константы типов коммуникаций
    public const TYPE_EMAIL = 'email';
    public const TYPE_PHONE = 'phone';
    public const TYPE_MEETING = 'meeting';
    public const TYPE_CHAT = 'chat';
    public const TYPE_SOCIAL_MEDIA = 'social_media';
    public const TYPE_VIDEO_CALL = 'video_call';
    public const TYPE_SMS = 'sms';
    public const TYPE_WHATSAPP = 'whatsapp';
    public const TYPE_TELEGRAM = 'telegram';
    public const TYPE_OTHER = 'other';

    // Массив доступных типов
    public static array $getTypes = [
        self::TYPE_EMAIL,
        self::TYPE_PHONE,
        self::TYPE_MEETING,
        self::TYPE_CHAT,
        self::TYPE_SOCIAL_MEDIA,
        self::TYPE_VIDEO_CALL,
        self::TYPE_SMS,
        self::TYPE_WHATSAPP,
        self::TYPE_TELEGRAM,
        self::TYPE_OTHER,
    ];
}
