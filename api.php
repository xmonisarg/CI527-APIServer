<?php
    // Connection to the PHP Database within brighton domains with mysqli method
    Class Database {
        private $servername = "brighton";
        private $username = "msp53_test";
        private $password = "Str0ngPassword!";
        private $dbname = "msp53_ci527-assign2";
        public $conn;

        private $status; 

        private $respond;

        public function __construct()() {
            $this->conn = new mysqli(
                $this->servername, 
                $this->username, 
                $this->password, 
                $this->dbname);
            
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
                $this->status = 500; 
            }
        }

        public function __destruct() {
            $this->conn->close();
        }

        public function handleRequest() {
            header("Content-Type: application/json");
            if ($this->status == 500) {
                http_response_code($this->status);
                return; // if connection  failed, do not handle any request
            }
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'POST':
                    $this->handlePost();
                    break;
                case 'GET':
                    $this->handleGet();
                    break;
                default:
                    $this->status = 405;
                    break;
                http_response_code($this->status);
                echo $this->respond;
            }
        }

    private function handlePost() {

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
        $len = strlen($comment);
        if ($len < 1 || $len > 255){
            $html = "<p>Comment must be between 1 and 255 characters</p>";
        }
        if (! ctype_alnum($objId)) {
            
        }}

        
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
