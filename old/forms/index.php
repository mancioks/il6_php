<html>
<head>
    <title>Formos</title>
</head>
<body>
    <div class="header">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">some pages</a></li>
            <li><a href="#">log in</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Musu title</h1>
        <p>Lorem ipsum..</p>
        <form action="functions.php" method="post">
            <input type="number" name="skaicius1">
            <select name="veiksmas">
                <option value="*">*</option>
                <option value="-">-</option>
                <option value="+">+</option>
                <option value="/">/</option>
            </select>
            <input type="number" name="skaicius2">
            <input type="submit" value="OK" name="submit">
        </form>
    </div>
</body>
<style>
    .header{background: #0000ff; color:#ccc;}
    .header ul{display:flex;flex-wrap: wrap;list-style:none;}
    .header li{margin-left:20px;}
    .header a{color:#ff0000;text-decoration: none;}
    .content{width:800px; margin:0; background: beige;}
</style>
</html>