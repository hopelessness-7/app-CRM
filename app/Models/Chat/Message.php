<?php

namespace App\Models\Chat;

use App\Models\Relations\ImageRelation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Message extends Model
{
    use HasFactory, ImageRelation;

    protected $fillable = ['room_id', 'user_id', 'text'];

    public function attachments(): Collection
    {
        return $this->images()->where('type', 'attachments')->get();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
