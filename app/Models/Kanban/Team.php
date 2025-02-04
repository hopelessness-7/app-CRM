<?php

namespace App\Models\Kanban;

use App\Models\Relations\ImageRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory, ImageRelation;

    protected $fillable = ['title', 'description'];

    public function banner(): string
    {
        return $this->images()->where('type', 'banner')->value('patch') ?? '';
    }
}
