<?php
    // Connection to the PHP Database within brighton domains
    Class Database {
        private $servername = "brighton";
        private $username = "msp53_test";
        private $password = "Str0ngPassword!";
        private $dbname = "msp53_ci527-assign2";
        public $conn;

        public function connect() {
            $this->conn = new mysqli(
                $this->servername, 
                $this->username, 
                $this->password, 
                $this->dbname);
            
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
    }


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CI527 - API Server</title>
    </head>
    <body>
        <h1>CI527 - Web Application Development</h1>
        <p>Assessment 2 - REST API Server</p>
    </body>
