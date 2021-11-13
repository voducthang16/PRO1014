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
    $a = array("Volvo", "BMW", "Toyota", "Volvo 2", "BMW 2", "Toyota 2");
    $b = array("a", "b", "c", "a 2", "b 2", "c 2");
    foreach ($a as $value) {
        echo $value . "<br>";
        echo $b[0];
        array_shift($b);
    }
?>