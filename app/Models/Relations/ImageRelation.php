<?php

namespace App\Models\Relations;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ImageRelation
{
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'entity');
    }
}
