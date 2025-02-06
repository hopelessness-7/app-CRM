<?php

namespace App\Models\Kanban;

use App\Models\Relations\ImageRelation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory, ImageRelation;

    protected $fillable = ['title', 'description'];

    public function banner(): string
    {
        return $this->images()->where('type', 'banner')->value('patch') ?? '';
    }

    public function dashboards(): BelongsToMany
    {
        return $this->belongsToMany(Dashboard::class, 'dashboard_team', 'team_id', 'dashboard_id');
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_team', 'team_id', 'task_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }
}
