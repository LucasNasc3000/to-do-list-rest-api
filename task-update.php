<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$connection = new mysqli("localhost", "root", "", "task_list");

if($connection->connect_error) {
	echo "Error: " . $connection->connect_error;
	exit;
}

$task = $_POST["task"];
$urlid = $_POST["urlid"];

$stmt = $connection->prepare("UPDATE task_list SET task=? WHERE idtask=?");

$stmt->bind_param("si", $task, $urlid);

$stmt->execute();
?>