<?php

namespace Helper;

class Validator {
    private const PLUS_OPERATOR = "+";
    private const SUBTR_OPERATOR = "-";
    private const MULTIP_OPERATOR = "*";

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

        if($operators[$operator] == self::PLUS_OPERATOR) {
            $answer = $number1 + $number2;
        }
        if($operators[$operator] == self::SUBTR_OPERATOR) {
            $answer = $number1 - $number2;
        }
        if($operators[$operator] == self::MULTIP_OPERATOR) {
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