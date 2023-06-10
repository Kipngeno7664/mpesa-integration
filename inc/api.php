<?php
header('Content-Type: application/json');

require 'config.inc.php';

$sqlQuery = "SELECT * FROM 12345 ";

$result = mysqli_query($db,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>