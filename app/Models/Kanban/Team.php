<?php

namespace App\Models\Kanban;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function banner(): HasOne
    {
        return $this->hasOne(Image::class);
    }
}
