<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

class Task {
	public $connection;
    public $task;
	public $urlid;
	public $searchValue;
	public $isfinished = "not-finished";

	public function setFinished($value) {
       $this->isfinished = $value;
	}
	public function setTask($value) {
       $this->task = $value;
	}
	public function setUrlid($value) {
       $this->urlid = $value;
	}
	public function setSearchValue($value) {
       $this->searchValue = $value;
	}

	public function __construct() {
		$this->connection = new mysqli("localhost", "root", "", "task_list");

        if($this->connection->connect_error) {
	       echo "Error: " . $this->connection->connect_error;
	       exit;
        }
	}

	public function TaskList() {
		$result = $this->connection->query("SELECT * FROM task_list");

        $data = array();

        while($row = $result->fetch_assoc()) {
	       array_push($data, $row);
        } 

        echo json_encode($data);
	}

	public function CreateTask() {
		$stmt = $this->connection->prepare("INSERT INTO task_list (task, isfinished) VALUES (?, ?)");

        $stmt->bind_param("ss", $this->task, $this->isfinished); 

        $stmt->execute();

        echo json_encode(array(
			$this->task,
			$this->isfinished
		));
	}

	public function UpdateTask() {
		$stmt = $this->connection->prepare("UPDATE task_list SET task=? WHERE idtask=?");

        $stmt->bind_param("si", $this->task, $this->urlid);

        $stmt->execute(); 
		
		echo json_encode(array(
			$this->task,
			$this->isfinished,
		));
	}

	public function FinishTask() {
		$stmt = $this->connection->prepare("UPDATE task_list SET isfinished=? WHERE idtask=?");

        $stmt->bind_param("si", $this->isfinished, $this->urlid);

        $stmt->execute();
	}

	public function NotFinished() {
		   $stmt = $this->connection->prepare("UPDATE task_list SET isfinished=? WHERE idtask=?");

           $stmt->bind_param("si", $this->isfinished, $this->urlid);

		   $stmt->execute();
	}

	public function TaskSearch() {
		$param = "%{$this->searchValue}%";

        $stmt = $this->connection->prepare("SELECT task FROM task_list WHERE task LIKE ?");

        $stmt->bind_param("s", $param);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($data);
	}

}

?>