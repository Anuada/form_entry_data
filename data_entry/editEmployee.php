<?php

include "./util/dbhelper.php";

$db = new DbHelper;

$employee = $db->getRecord("employees", ["id" => $_GET["id"]]);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <form action="./logic/updateEmployee.php" method="post">
            <input type="hidden" name="id" value="<?php echo $employee["id"] ?>">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" value="<?php echo $employee["fname"] ?>" required>
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" value="<?php echo $employee["lname"] ?>" required>
            <label for="age">Age</label>
            <input type="text" id="age" name="age" value="<?php echo $employee["age"] ?>" required>
            <label for="position">Position</label>
            <input type="text" id="position" name="position" value="<?php echo $employee["position"] ?>" required>

            <input type="submit" value="Add Employee" name="submit">
        </form>
    </div>
</body>

</html>