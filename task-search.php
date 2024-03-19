<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$connection = new mysqli("localhost", "root", "", "task_list");

if($connection->connect_error) {
	echo "Error: " . $connection->connect_error;
	exit;
}

$param = "%{$_POST["searchValue"]}%";

$stmt = $connection->prepare("SELECT task FROM task_list WHERE task LIKE ?");

$stmt->bind_param("s", $param);

$stmt->execute();

$result = $stmt->get_result();

$data = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($data);

// $stmt->bind_result($task);
// while($stmt->fetch()) {
// 	echo json_encode($task);
// }
// $stmt->close();
?>