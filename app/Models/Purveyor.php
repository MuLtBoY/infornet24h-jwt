<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purveyor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'street',
        'neighborhood',
        'number',
        'latitude',
        'longitude',
        'city',
        'uf',
    ];

    public function purveyorAssistances(): HasMany
    {
        return $this->hasMany(PurveyorAssistance::class);
    }

    public function assistances()
    {
        return $this->belongsToMany(Assistance::class)
                    ->withPivot('start_km', 'start_value', 'value_km')
                    ->withTimestamps();
    }
}
