<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['device', 'device_ip', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
