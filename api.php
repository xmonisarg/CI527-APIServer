<?php
// Connection to the PHP Database within brighton domains with mysqli method
class RestAPI {
    private $servername = "brighton";
    private $username = "msp53_test";
    private $password = "Str0ngPassword!";
    private $dbname = "msp53_ci527-assign2";
    public $conn;

    private $status = null;

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
            $this->status = 500;
            exit;
            
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
                echo $this->respond;
                break;
            }
            http_response_code($this->status);
        }

    private function handlePost()
    {

        if (isset($_POST["oid"]) && isset($_POST["name"]) && isset($_POST["comment"])) {
            // Assinging paramters with variables 
            $oid = $_POST["oid"];
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
            $len = strlen($oid);
            if (!ctype_alnum($oid) || $len > 32) { // alphanumeric check for oid
                $this->status = 400;
                return;
            }
        }


    }

    private function handleGet()
    {
        if (isset($_GET["oid"])) {

            $oid = $_GET["oid"];

            $len = strlen($oid);
            if (!ctype_alnum($oid) || $len > 32) { // alphanumeric check for obid
                $this->status = 400;
                return;
            } else {
                $this->status = 400; // bad request, if no parameter provided.
            }
            // execute mysqli query and format the response with status code with json format.
        } if ($this->status == 200) {
            $stmt = $this->conn->prepare("SELECT * FROM comments WHERE oid=?");
            $stmt->bind_param("s", $obid);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows['curDate'] = date('d F Y', strtotime($row['curDate'])); // format date to "day month year"
                    $rows[] = $row;

                }
                echo json_encode($rows);
            } else {
                $this->status = 204; // if there is 0 rows, then it will return 204 no content code.
            }
           }
    }

}

    $api = new RestAPI();
    $api->handleRequest();
?>

<!-- References
 1. https://www.php.net/manual/en/mysqli.execute-query.php
 2. https://www.php.net/manual/en/mysqli.error.php
-->