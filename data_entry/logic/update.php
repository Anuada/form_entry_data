<?php

include "../util/dbhelper.php";

$db = new DbHelper;

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $age = $_POST["age"];
    $position = $_POST["position"];

    if (!empty(trim($fname)) && !empty(trim($lname)) && !empty(trim($age)) && !empty(trim($position))) {
        $updateEmployee = $db->updateRecord("employees", ["id" => $id, "fname" => $fname, "lname" => $lname, "age" => $age, "position" => $position]);
        if ($updateEmployee > 0) {
            header("Location: ../?m=EMPLOYEE+UPDATED+SUCCESSFULLY");
            exit();
        } else {
            header("Location: ../?m=NO+DATA+WAS+UPDATED");
            exit();
        }
    }
} else {
    header("Location: ../");
    exit();
}