<form action="" method="POST" enctype="multipart/form-data">
    <input type="number" name="test[]">
    <input type="number" name="test[]">
    <input type="number" name="test[]">
    <input type="number" name="test[]">
    <input type="number" name="test[]">
    <input type="number" name="test[]">
    <input type="submit" value="Submit">
</form>

<?php
    $num = -1;
    if (!filter_var($num, FILTER_VALIDATE_INT)) {
        echo "k phai so nguyen";
    } else {
        echo "so nguyen";
    }
?>