<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once("Task.php");

$tasks = new Task();

$dboperation = $_POST["dboperation"];
$task = $_POST["task"];
$searchValue = $_POST["searchValue"];
$urlid = $_POST["urlid"];

switch ($dboperation) {
    case "read": {
      $tasks->TaskList();
      break;
    }
    case "create": {
      $tasks->setTask($task);
      $tasks->CreateTask();
      break;
    }
    case "update": {
      $tasks->setUrlid($urlid);
      $tasks->setTask($task);
      $tasks->UpdateTask();
      break;
    }
    case "search": {
      $tasks->setSearchValue($searchValue);
      $tasks->TaskSearch();
      break;
    }
}

?>