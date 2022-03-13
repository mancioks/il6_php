<?php

include 'parts/header.php';

?>
<form action="register.php" method="post">
<h1>Registracija</h1>
    <input type="text" name="name" placeholder="name"><br>
    <input type="text" name="lastname" placeholder="lastname"><br>
    <input type="email" name="email" placeholder="email"><br>
    <input type="password" name="password" placeholder="password"><br>
    <input type="password" name="password2" placeholder="repeat password"><br>
    <input type="text" name="phone" placeholder="phone number"><br>
    <input type="submit" name="register" value="register">
</form>
<?php

include 'parts/footer.php';

?>