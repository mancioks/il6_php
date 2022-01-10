<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Prisijungti</h2>
    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="E-mail">
        <input type="password" name="password" placeholder="Slaptažodis">
        <input type="submit" name="submit" value="Prisijungti">
    </form>
    <hr>
    <h2>Registracijos forma</h2>
    <form action="registration.php" method="post">
        <input type="text" name="first_name" placeholder="Vardas"><br>
        <input type="text" name="last_name" placeholder="Pavardė"><br>
        <input type="email" name="email" placeholder="E-mail"><br>
        <input type="password" name="password1" placeholder="Slaptažodis"><br>
        <input type="password" name="password2" placeholder="Pakartoti slaptažodį"><br>
        <label for="agree_terms">Sutinku su registracijos taisyklėmis</label>
        <input type="checkbox" name="agree_terms" id="agree_terms"><br>
        <input type="submit" name="submit" value="Registruotis">
    </form>
</body>
</html>