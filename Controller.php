<?php

class Database
{
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pass = '';
    private $name = 'tms';
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
    
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function establishConnection()
    {
        return $this->conn;
    }
}

class TaskManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addTask($taskName, $user_id)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("INSERT INTO tasks (taskName, user_id) VALUES (?,?)");
        $query->bind_param("si", $taskName, $user_id);
        $query->execute();
        $query->close();
    }

    public function markTaskAsDone($taskId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("UPDATE tasks SET is_done = IF(is_done = 0, 1, 0) WHERE taskId = ?");
        $query->bind_param("i", $taskId);
        $query->execute();
        $query->close();
    }

    public function getTasks()
    {
        $conn = $this->db->establishConnection();
        $taskQuery = $conn->query("select *,users.name from tasks JOIN users on user_id = users.userId");
        // $tasks = $taskQuery->fetch_all(MYSQLI_ASSOC);

        $tasks = [];
        while ($row = $taskQuery->fetch_assoc()) {
            $tasks[] = $row;
        }

        return $tasks;
    }
}

class UserManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createUser($name)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("INSERT INTO users (name) VALUES (?)");
        $query->bind_param("s", $name);
        $query->execute();
        $query->close();
    }

    public function deleteUser($userId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("DELETE FROM users WHERE userId = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        $query->close();
    }

    public function updateUser($userId, $name)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("UPDATE users SET name = ? WHERE userId = ?");
        $query->bind_param("si", $name, $userId);
        $query->execute();
        $query->close();
    }

    public function getUsers()
    {
        $conn = $this->db->establishConnection();
        $userQuery = $conn->query("SELECT * FROM users");

        $users = [];
        while ($row = $userQuery->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

}

?>
