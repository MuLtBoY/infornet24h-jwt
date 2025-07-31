<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assistance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
    ];

    public function purveyorAssistances(): HasMany
    {
        return $this->hasMany(PurveyorAssistance::class);
    }

    public function purveyors()
    {
        return $this->belongsToMany(Purveyor::class)
                    ->withPivot('start_km', 'start_value', 'value_km')
                    ->withTimestamps();
    }
}