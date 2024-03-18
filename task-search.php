<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$connection = new mysqli("localhost", "root", "", "task_list");

if($connection->connect_error) {
	echo "Error: " . $connection->connect_error;
	exit;
}

$searchValue = $_POST["searchValue"];

$stmt = $connection->prepare("SELECT task FROM task_list WHERE task LIKE ?");

$stmt->bind_param("s", $searchValue);

$stmt->execute();

$stmt->bind_result($task);

while($stmt->fetch()) {
	echo json_encode($task);
}

if($task === "") {
	echo "Tarefa não encontrada";
}
// $stmt->close();
?>