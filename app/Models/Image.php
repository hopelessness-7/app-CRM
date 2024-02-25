<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'patch',
        'type',
        'entity_type',
        'entity_id'
    ];

    public $timestamps = false;
}
