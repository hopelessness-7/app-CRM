<?php

namespace App\Models\Chat;

use App\Models\Relations\ImageRelation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory, ImageRelation;

    protected $fillable = ['title', 'type'];

    protected array $types = ['private', 'group'];

    public function getRoomAvatar(): Model|null
    {
        return $this->images()->where('type', 'avatar_chat')->first();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_user');
    }
}
