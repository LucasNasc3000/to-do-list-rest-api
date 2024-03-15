<?php
header('Content-Type: application/json');
$connection = new mysqli("localhost", "root", "", "task_list");

if($connection->connect_error) {
	echo "Error: " . $connection->connect_error;
	exit;
}
$stmt = $connection->prepare("INSERT INTO task_list (task) VALUES (?)");

$task = $_POST["task"];

//ss quer dizer que os dois campos (usuário e senha) serão string
//o método bind não recebe as strings dos campos do BD diretamente, eles precisam ser enviados por referência
$stmt->bind_param("s", $task); 

$stmt->execute();
?>