<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";   
    private $dbName = "portfolio_db";
    public $conn;

    public function __construct() {
        $this->connect();
        $this->createDatabase();
        $this->createTable();
    }

    private function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->password);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    private function createDatabase() {
        $sql = "CREATE DATABASE IF NOT EXISTS $this->dbName";
        if ($this->conn->query($sql) === TRUE) {
            echo "Database created successfully or already exists.<br>";
        } else {
            die("Error creating database: " . $this->conn->error);
        }

       
        $this->conn->select_db($this->dbName);
       
    }

  
    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS portfolio_content (
            id INT AUTO_INCREMENT PRIMARY KEY,
            section VARCHAR(100) NOT NULL,      
            title VARCHAR(255) NOT NULL,        
            description TEXT,                   
            image_url VARCHAR(255),             
            project_link VARCHAR(255),          
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        if ($this->conn->query($sql) === TRUE) {
            echo "Table `portfolio_content` created successfully or already exists.<br>";
        } else {
            die("Error creating table: " . $this->conn->error);
        }
    }
    public function createContent($section, $title, $description, $image_url, $project_link = NULL) {
        $sql = "INSERT INTO portfolio_content (section, title, description, image_url, project_link)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $section, $title, $description, $image_url, $project_link);
        return $stmt->execute();
    }

    // Read 
    public function getContentBySection($section) {
        $sql = "SELECT * FROM portfolio_content WHERE section=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $section);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Delete 
    public function deleteContent($id) {
        $sql = "DELETE FROM portfolio_content WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
$db = new Database();
?>


?>