<?php
class student {
    private $conn;
    private $table = "students";
    public $id;
    public $Name;
    public $Email;
    public $Grade;
    public $Class;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (Name, Email, Grade, Class) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('ssis', $this->Name, $this->Email, $this->Grade, $this->Class);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function read() {
        $query = "SELECT ID, Name, Email, Grade, Class FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();  
        return $result;
    }
    

    public function update() {
        $query = "UPDATE " . $this->table . " SET Name=?, Email=?, Grade=?, Class=? WHERE ID=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sisi', $this->Name, $this->Class, $this->Grade, $this->Class, $this->ID);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE ID=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $this->ID);

        return $stmt->execute();
    }
}
