<?php

namespace Cocomelon\Captcha\Rules;

use Illuminate\Contracts\Validation\Rule;

class CaptchaRule implements Rule
{
    public function passes($attribute, $value)
    {
        $answer = session('captcha_answer');

        if (is_string($answer)) {
            return strtoupper(trim($value)) === strtoupper($answer);
        }

        return (string) $value === (string) $answer;
    }

    public function message()
    {
        return 'Invalid captcha answer.';
    }
}
