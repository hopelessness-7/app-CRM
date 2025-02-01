<?php

namespace App\Models\Kanban;

use App\Models\Image;
use App\Models\Relations\ImageRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dashboard extends Model
{
    use HasFactory, ImageRelation;

    protected $fillable = ['title', 'description', 'team_id'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function banner(): string
    {
        return $this->images()->where('type', 'banner')->value('patch') ?? '';
    }
}
