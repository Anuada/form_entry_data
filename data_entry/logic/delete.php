<?php

include "../util/dbhelper.php";

$db = new DbHelper;

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = $_GET["id"];
    $deleteEmployee = $db->deleteRecord("employees", ["id" => $id]);
    if ($deleteEmployee > 0) {
        header("Location: ../?m=EMPLOYEE+DELETED+SUCCESSFULLY");
        exit();
    } else {
        header("Location: ../");
        exit();
    }
} else {
    header("Location: ../");
    exit();
}