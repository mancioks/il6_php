<?php

declare(strict_types=1);

namespace Helper;

use Model\Session;

class Validator {

    public static function checkPassword(string $pass, string $pass2): bool
    {
        return $pass === $pass2;
    }

    public static function checkEmail(string $email): false|int
    {
        return strpos($email, '@');
    }

    public static function generateSecurityQuestion(): void
    {
        $number1 = rand(0, 10);
        $number2 = rand(0, 10);

        if($number1 < $number2) {
            $temp = $number1;
            $number1 = $number2;
            $number2 = $temp;
        }

        $operators = ["+", "-", "*"];
        $operator = rand(0, count($operators) - 1);

        $string = $number1 . " " . $operators[$operator] . " " . $number2;

        if($operators[$operator] == "+") {
            $answer = $number1 + $number2;
        }
        if($operators[$operator] == "-") {
            $answer = $number1 - $number2;
        }
        if($operators[$operator] == "*") {
            $answer = $number1 * $number2;
        }

        $math = ["question" => $string, "answer" => $answer];

        $session = new Session();
        $session->set("security_question")->value($math);
    }

    public static function getSecurityQuestion(): string
    {
        $session = new Session();
        return $session->get("security_question")["question"];
    }

    public static function getSecurityAnswer(): int
    {
        $session = new Session();
        return (int)$session->get("security_question")["answer"];
    }
}