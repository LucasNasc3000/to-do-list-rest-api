<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// Todas as requisições deverão ser POST devido ao campo dboperation, que não é um campo na base de dados mas
// informação de qual operação será feita com o banco de dados.
// Assim sendo, todas as requisições do front-end deverão ter um corpo e o campo "dboperation", informando o 
// tipo de operação (read, create, update ou search). Delete ainda não foi implementado.

require_once("Task.php");

$tasks = new Task();

$dboperation = $_POST["dboperation"];
$task;
$searchValue;
$urlid;

if(isset($_POST["task"]))$task = $_POST["task"];
if(isset($_POST["searchValue"]))$searchValue = $_POST["searchValue"];
if(isset($_POST["urlid"]))$urlid = $_POST["urlid"];

// Verifica se o id enviado na requisição é numérico e se tem mais de 3 dígitos. Estas verificações servem para
// evitar sql injection.
if(!is_numeric($urlid) || strlen($urlid) > 3) {
  exit("Valor inválido para ID");
}

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
    case "finish": {
      $tasks->setUrlid($urlid);
      $tasks->setFinished("finished");
      $tasks->FinishTask();
    }
}

?>