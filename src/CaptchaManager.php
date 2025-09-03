<?php

namespace Cocomelon\Captcha;

class CaptchaManager
{
    public static function generate($type = 'numeric')
    {
        switch ($type) {
            case 'alphabetical': return self::generateAlphabetical();
            case 'alphanumeric': return self::generateAlphanumeric();
            case 'numeric':
            default: return self::generateNumeric();
        }
    }

    private static function generateNumeric()
    {
        $numbers = range(1, 9);
        $operators = ['+', '-', '*', '/'];

        $num1 = $numbers[array_rand($numbers)];
        $num2 = $numbers[array_rand($numbers)];
        $operator = $operators[array_rand($operators)];

        switch ($operator) {
            case '+': $result = $num1 + $num2; break;
            case '-': $result = $num1 - $num2; break;
            case '*': $result = $num1 * $num2; break;
            case '/': $result = $num2 != 0 ? intdiv($num1, $num2) : 0; break;
        }

        session(['captcha_answer' => (string)$result]);

        return [
            'type' => 'numeric',
            'num1' => asset("vendor/captcha/numbers/$num1@2x.png"),
            'operator' => asset("vendor/captcha/operators/" . self::operatorFile($operator)),
            'num2' => asset("vendor/captcha/numbers/$num2@2x.png"),
        ];
    }

    private static function generateAlphabetical()
    {
        $letters = range('A', 'Z');
        $captchaText = '';
        for ($i = 0; $i < 5; $i++) {
            $captchaText .= $letters[array_rand($letters)];
        }

        session(['captcha_answer' => $captchaText]);

        return [
            'type' => 'alphabetical',
            'text' => $captchaText,
        ];
    }

    private static function generateAlphanumeric()
    {
        $characters = array_merge(range('A', 'Z'), range(0, 9));
        $captchaText = '';
        for ($i = 0; $i < 6; $i++) {
            $captchaText .= $characters[array_rand($characters)];
        }

        session(['captcha_answer' => $captchaText]);

        return [
            'type' => 'alphanumeric',
            'text' => $captchaText,
        ];
    }

    private static function operatorFile($operator)
    {
        return match ($operator) {
            '+' => 'plus.png',
            '-' => 'minus.png',
            '*' => 'mul.png',
            '/' => 'div.png',
        };
    }
}
