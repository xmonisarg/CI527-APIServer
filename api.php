<?php
    // Connection to the PHP Database within brighton domains with mysqli method
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

    if(isset($_POST["objId"]) && isset($_POST["name"]) && isset($_POST["comment"])) {
        // Assinging paramters with variables 
        $objId = $_POST["objId"];
        $name = $_POST["name"];
        $comment = $_POST["comment"];

        // Data validation
        $len = strlen($name);
        if ($len < 1 || $len > 64){
            $html = "<p>Name must be between 1 and 64 characters</p>";
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
</html>
