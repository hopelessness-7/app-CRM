<?php

namespace App\Models;

use App\Models\Kanban\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'client_type_id',
        'status',
        'notes',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'client_tasks', 'client_id', 'task_id');
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }
}
