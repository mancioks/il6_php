<?php

namespace Helper;

class Validator {

    public static function checkPassword($pass, $pass2) {
        return $pass === $pass2;
    }

    public static function checkEmail($email) {
        return strpos($email, '@');
    }

    public static function generateSecurityQuestion()
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

        $_SESSION["security_question"] = $math;
    }

    public static function getSecurityQuestion()
    {
        return $_SESSION["security_question"]["question"];
    }

    public static function getSecurityAnswer()
    {
        return $_SESSION["security_question"]["answer"];
    }
}