<?php
if($_POST) {
    if($_POST["veiksmas"] == "+")
        echo $_POST["skaicius1"] + $_POST["skaicius2"];
    if($_POST["veiksmas"] == "-")
        echo $_POST["skaicius1"] - $_POST["skaicius2"];
    if($_POST["veiksmas"] == "*")
        echo $_POST["skaicius1"] * $_POST["skaicius2"];
    if($_POST["veiksmas"] == "/")
        echo $_POST["skaicius1"] / $_POST["skaicius2"];
}