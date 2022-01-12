<?php
include 'core.php';
echo 'The game';
echo '<br>';

$tools = [
    TOOL_ROCK => 'Akmuo',
    TOOL_PAPER => 'Popierius',
    TOOL_SCISSORS => 'Zirkles'
];

echo '<form action="index.php" method="post">';
echo '<select name="tool">';
foreach ($tools as $key => $tool) {
    echo '<option value="' . $key . '">' . $tool . '</option>';
}
echo '</select>';
echo '<br>';
echo '<input type="submit" value="Play!!!" name="play">';
echo '</form>';

$winners = readFromCsv("log.csv");
$winners = getLast($winners, 10);

$statistics = winStatistics($winners);

echo "<h1>Žaidimai</h1>";
echo '<table>';
foreach ($winners as $winner) {
    echo '<tr><td><img src="image/' . $winner[0] . '.jpg" width="50px"/></td><td>VS</td><td><img src="image/' . $winner[1] . '.jpg" width="50px"/></td><td>Winner: ' . $winner[2] . '</td></tr>';
}
echo '</table>';

foreach ($statistics as $key => $statistics) {
    echo '<b>'.ucfirst($key).':</b> '.$statistics."<br>";
}