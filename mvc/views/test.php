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
    if (isset($_POST['test'])) {
        $test = $_POST['test'];
        echo count($test);

        echo $test[0];
        echo $test[1];
        echo $test[2];
        echo $test[3];
        echo $test[4];
        echo $test[5];
    }
    $a = "áo thun";
    // echo ucwords(mb_strtolower($a, 'UTF-8'));
    echo mb_convert_case($a, MB_CASE_TITLE, "UTF-8");
?>