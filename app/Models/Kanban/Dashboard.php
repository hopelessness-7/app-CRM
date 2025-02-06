<?php

namespace App\Models\Kanban;

use App\Models\Relations\ImageRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dashboard extends Model
{
    use HasFactory, ImageRelation;

    protected $fillable = ['title', 'description'];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'dashboard_team', 'dashboard_id', 'team_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function banner(): string
    {
        return $this->images()->where('type', 'banner')->value('patch') ?? '';
    }
}
