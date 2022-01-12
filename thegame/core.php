<?php
const TOOL_ROCK = 'rock';
const TOOL_PAPER = 'paper';
const TOOL_SCISSORS = 'scissors';

function writeToCsv($data, $fileName) {
    $file = fopen($fileName, 'a');

    foreach ($data as $element) {
        fputcsv($file, $element);
    }

    fclose($file);
}

function readFromCsv($fileName) {
    $data = [];
    $fh = fopen($fileName, 'r');

    while (!feof($fh)) {
        $line = fgetcsv($fh);
        if(!empty($line)) {
            $data[] = $line;
        }
    }

    fclose($fh);
    return $data;
}

function debug($data) {
    echo '<pre>';
    var_dump($data);
    die();
}

function getLast($data, $howMuch) {
    $dataCount = count($data);

    if($dataCount < $howMuch) {
        $howMuch = $dataCount;
    }

    $last = [];

    for($x = $dataCount - 1; $x > $dataCount - $howMuch - 1; $x--) {
        $last[] = $data[$x];
    }

    return $last;
}

function winStatistics($data) {
    $winners = [
        'pc' => 0,
        'player' => 0,
        'draw' => 0
    ];

    foreach ($data as $line) {
        $winners[$line[2]]++;
    }

    return $winners;
}

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

    $winner = "player";

    if ($playerChoice == $pcChoice) {
        echo 'Lygiosios';
        $winner = "draw";
    } elseif ($playerChoice == TOOL_ROCK && $pcChoice == TOOL_SCISSORS) {
        echo 'Laimėjote';
    } elseif ($playerChoice == TOOL_PAPER && $pcChoice == TOOL_ROCK) {
        echo 'Laimėjote';
    } elseif ($playerChoice == TOOL_SCISSORS && $pcChoice == TOOL_PAPER) {
        echo 'Laimėjote';
    } else {
        echo 'Pralaimėjote';
        $winner = "pc";
    }

    $data = [];
    $data[] = [$playerChoice, $pcChoice, $winner];

    writeToCsv($data, 'log.csv');

    echo "<br><br>";
}