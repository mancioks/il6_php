<?php include 'parts/header.php'; ?>
<form action="submitad.php" method="post">
    <input type="text" name="title" placeholder="title"><br>
    <textarea name="content" placeholder="details"></textarea><br>
    <input type="number" name="price" placeholder="price"><br>
    <select name="year">
        <?php for($i = 1990; $i <= date("Y"); $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
    </select><br>
    <input type="submit" value="create" name="create">
</form>
<?php include 'parts/footer.php'; ?>