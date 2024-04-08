<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// Todas as requisições deverão ser POST devido ao campo dboperation, que não é um campo na base de dados mas
// informação de qual operação será feita com o banco de dados.
// Assim sendo, todas as requisições do front-end deverão ter um corpo e o campo "dboperation", informando o 
// tipo de operação (read, create, update ou search). Delete ainda não foi implementado.

require_once("Task.php");

$tasks = new Task();


if(isset($_POST["task"])) $task = $_POST["task"];
if(isset($_POST["table"])) $table = $_POST["table"];
if(isset($_POST["searchValue"])) $searchValue = $_POST["searchValue"];
if(isset($_POST["urlid"])) $urlid = $_POST["urlid"];
if(isset($_POST["dboperation"])) $dboperation = $_POST["dboperation"];


switch ($dboperation) {
    case "read": {
      $tasks->TaskList($table);
      break;
    }
    case "create": {
      $tasks->setTask($task);
      $tasks->CreateTask($table);
      break;
    }
    case "update": {
      $tasks->setUrlid($urlid);
      $tasks->setTask($task);
      $tasks->UpdateTask($table);
      break;
    }
    case "search": {
      $tasks->setSearchValue($searchValue);
      $tasks->TaskSearch($table);
      break;
    }
}

?>