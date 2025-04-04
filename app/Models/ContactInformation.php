<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInformation extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'communication_type_id', 'value'];
    public $timestamps = false;
    protected $table = 'contact_information';

    public function type(): BelongsTo
    {
        return $this->belongsTo(CommunicationType::class);
    }

}
