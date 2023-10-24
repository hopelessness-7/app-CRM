<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cleint extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'client_type_id',
        'status',
        'notes',
        'worker_id',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
