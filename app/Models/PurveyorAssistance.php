<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurveyorAssistance extends Model
{
    use HasFactory;

    protected $table = 'purveyor_assistance';

    protected $fillable = [
        'purveyor_id',
        'assistance_id',
        'start_km',
        'start_value',
        'value_km',
    ];

    public function purveyor()
    {
        return $this->belongsTo(Purveyor::class);
    }

    public function assistance()
    {
        return $this->belongsTo(Assistance::class);
    }
}