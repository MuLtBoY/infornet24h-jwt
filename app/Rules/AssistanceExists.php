<?php

namespace App\Rules;

use App\Models\Assistance;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AssistanceExists implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Assistance::where('id', $value)->exists()) {
            $fail("O id {$attribute} informado não existe na tabela de serviços.");
        }
    }
}