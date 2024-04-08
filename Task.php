<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

class Task {
	public $connection;
    public $task;
	public $urlid;
	public $searchValue;
	
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

	public function TaskList($table) {
		$result = $this->connection->query("SELECT * FROM $table");

        $data = array();

        while($row = $result->fetch_assoc()) {
	       array_push($data, $row);
        } 

		echo json_encode($data);
	}

	public function CreateTask($table) {
		$stmt = $this->connection->prepare("INSERT INTO $table (task) VALUES (?)");

        $stmt->bind_param("s", $this->task); 

        $stmt->execute();

		echo json_encode($this->task);
	}

	public function UpdateTask($table) {
		$stmt = $this->connection->prepare("UPDATE $table SET task=? WHERE idtask=?");

        $stmt->bind_param("si", $this->task, $this->urlid);

        $stmt->execute(); 
		
		echo json_encode($this->task);
	}

	public function TaskSearch($table) {
		$param = "%{$this->searchValue}%";

        $stmt = $this->connection->prepare("SELECT task FROM $table WHERE task LIKE ?");

        $stmt->bind_param("s", $param);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($data);
	}

}

?>