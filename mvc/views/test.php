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
    $array = array(22, 33, 44, 55, 66);
    $array = array_diff($array, [55]);
    var_dump($array);
?>