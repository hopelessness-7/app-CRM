<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'surname',
        'first_name',
        'patronymic',
        'date_birth',
        'address',
        'place_work',
        'job_position'
    ];

    public function communications(): HasMany
    {
        return $this->hasMany(ContactInformation::class);
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }
}
