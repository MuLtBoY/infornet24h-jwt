<?php

namespace App\Rules;

use App\Models\Purveyor;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PurveyorExists implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Purveyor::where('id', $value)->exists()) {
            $fail("O id {$attribute} informado não existe na tabela de prestadores.");
        }
    }
}