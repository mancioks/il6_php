<?php
const TOOL_ROCK = 'rock';
const TOOL_PAPER = 'paper';
const TOOL_SCISSORS = 'scissors';

$toolsArray = [
    0 => TOOL_ROCK,
    1 => TOOL_PAPER,
    2 => TOOL_SCISSORS
];

if (isset($_POST['play'])) {
    $playerChoice = $_POST["tool"];
    $pcChoice = $toolsArray[rand(0, 2)];

    echo '<table>';
    echo '<tr><td><img src="image/' . $playerChoice . '.jpg" width="150px"/></td><td>VS</td><td><img src="image/' . $pcChoice . '.jpg" width="150px"/></td></tr>';
    echo '</table>';

    if ($playerChoice == $pcChoice) {
        echo 'Lygiosios';
    } elseif ($playerChoice == TOOL_ROCK && $pcChoice == TOOL_SCISSORS) {
        echo 'Laimėjote';
    } elseif ($playerChoice == TOOL_PAPER && $pcChoice == TOOL_ROCK) {
        echo 'Laimėjote';
    } elseif ($playerChoice == TOOL_SCISSORS && $pcChoice == TOOL_PAPER) {
        echo 'Laimėjote';
    } else {
        echo 'Pralaimėjote';
    }
    echo "<br><br>";
}