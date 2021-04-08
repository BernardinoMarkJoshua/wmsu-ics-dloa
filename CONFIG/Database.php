<?php

    class Database {
        private $host = 'localhost';
        private $db_name = 'root';
        private $username = 'root';
        private $password = ' ';
        private $conn;

        public function connect() {
            $this->conn = null; 

            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, 
                $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOExecption $e) {
                echo 'Connection Error: '.$e->getMessage();
            }

            return $this->conn;
        }
    }

?>