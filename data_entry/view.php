<?php 
require_once "./util/dbhelper.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "Diko Kita ID";
}
$db = new DbHelper();
$displayAll_Details = $db->Joiningtables($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIEW DETAILS</title>
</head>
<body>
        <center><h1>YOUR DETAILS</h1></center>
<table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>NAME</th>
                                <th>AGE</th>
                                <th>SEX</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($displayAll_Details as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($row->name); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->age); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->sex); ?></td>
                                    <td class="text-center">
                                    <a href="../crud_form/edit_pod.php?id=<?= $row->id ?>&purchase_order_id=<?= $row->purchase_order_id ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="../logic/delete_pod_items.php?id=<?= $row->id ?>&purchase_order_id=<?= $row->purchase_order_id ?>" class="btn btn-danger btn-sm">Delete</a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
    
</body>
</html>