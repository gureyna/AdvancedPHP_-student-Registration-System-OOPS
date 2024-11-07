<?php
class dbstudent{
    public $conn;
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "school";

    public function getConnection(){
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $this->conn;
    }
}