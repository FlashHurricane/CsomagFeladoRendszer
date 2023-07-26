<?php
class Database
{
    private $conn;

    public function __construct()
    {
        // Adatbázis kapcsolódás
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dbname = "my_database";

        $this->conn = new mysqli($servername, $username, $password, $dbname);
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
class User
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllUsers()
    {
        $result = $this->conn->query("SELECT id, first_name, last_name, email_address, phone_number FROM users");

        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    public function addUser($first_name, $last_name, $email_address, $password, $phone_number = null)
    {
        // Jelszó hashelése Bcrypt-el
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("INSERT INTO users (first_name, last_name, email_address, password, phone_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email_address, $hashed_password, $phone_number);

        if ($stmt->execute()) {
            // Felhasználó sikeres hozzáadása
            $user_id = $stmt->insert_id;
            $response = array(
                "id" => $user_id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email_address" => $email_address,
                "phone_number" => $phone_number
            );
            return $response;
        } else {
            http_response_code(400);
            return array("error" => "Failed to add user.");
        }
    }
}

// API végpontok kezelése

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$user = new User();

if ($method === 'GET') {
    $response = $user->getAllUsers();
} elseif ($method === 'POST') {
    $input_data = json_decode(file_get_contents("php://input"), true);

    if (isset($input_data['first_name']) && isset($input_data['last_name']) && isset($input_data['email_address']) && isset($input_data['password'])) {
        $first_name = $input_data['first_name'];
        $last_name = $input_data['last_name'];
        $email_address = $input_data['email_address'];
        $password = $input_data['password'];
        $phone_number = isset($input_data['phone_number']) ? $input_data['phone_number'] : null;

        $response = $user->addUser($first_name, $last_name, $email_address, $password, $phone_number);
    } else {
        http_response_code(400);
        $response = array("error" => "Missing required parameters.");
    }
} else {
    http_response_code(404);
    $response = array("error" => "Endpoint not found.");
}

echo json_encode($response);