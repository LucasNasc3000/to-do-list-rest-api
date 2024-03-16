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

$stmt = $connection->query("UPDATE task_list SET task='$task' WHERE idtask='$urlid'");
// Adicionar close()?

?>