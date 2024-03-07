<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$connection = new mysqli("localhost", "root", "", "task_list");

if($connection->connect_error) {
	echo "Error: " . $connection->connect_error;
	exit;
} 

$result = $connection->query("SELECT * FROM task_list");

//Este while vai retornar em um array os dados da coluna deslogin da tabela usuários enquanto houverem linhas. Quando acabarem as linhas retorna null

$data = array();

while($row = $result->fetch_assoc()) {
	array_push($data, $row);
}

echo json_encode($data);
?>