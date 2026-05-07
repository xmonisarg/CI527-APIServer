<?php
// Connection to the PHP Database within brighton domains with mysqli method
class Database
{
    private $servername = "brighton";
    private $username = "msp53_test";
    private $password = "Str0ngPassword!";
    private $dbname = "msp53_ci527-assign2";
    public $conn;

    private $status;

    private $respond;

    public function __construct()
    {
        $this->conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->dbname
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
            $this->status = 500;
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function handleRequest()
    {
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

    private function handlePost()
    {

        if (isset($_POST["objId"]) && isset($_POST["name"]) && isset($_POST["comment"])) {
            // Assinging paramters with variables 
            $objId = $_POST["objId"];
            $name = $_POST["name"];
            $comment = $_POST["comment"];

            // Data validation
            $len = strlen($name);
            if (($len < 1 || $len > 64)) { // min length is 1, max length is 64
                $this->status = 400;
                return;
            }
            $len = strlen($comment);
            if ($len < 1) { // min length is 1
                $this->status = 400;
                return;
            }
            $len = strlen($objId);
            if (!ctype_alnum($objId) || $len > 32) { // alphanumeric check for objId
                $this->status = 400;
                return;
            }
        }


    }

    private function handleGet()
    {
        if (isset($_GET["objId"])) {

            $objId = $_GET["objId"];

            $len = strlen($objId);
            if (!ctype_alnum($objId) || $len > 32) { // alphanumeric check for objId
                $this->status = 400;
                return;
            }
            // execute mysqli query and format the response with status code with json format.
        } mysqli_query($this->conn, "SELECT * FROM comments WHERE objId='$objId'")
            or die("Error: " . mysqli_error($this->conn));
    }

}

?>

<!-- References
 1. https://www.php.net/manual/en/mysqli.execute-query.php
 2. https://www.php.net/manual/en/mysqli.error.php
-->