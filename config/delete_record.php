<?php 

include "connection.php";

$status = true;
$query = "DELETE FROM ".$_REQUEST['name']." WHERE id='".$_REQUEST['id']."'";
$delete = mysqli_query($conn, $query)or die (mysqli_error($conn));
if (!$delete)
    $status = false;

echo json_encode($status);

?>