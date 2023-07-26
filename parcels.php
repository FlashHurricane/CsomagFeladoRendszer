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

class Parcel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getParcelByParcelNumber($parcel_number)
    {
        $stmt = $this->conn->prepare("SELECT parcels.id, parcels.parcel_number, parcels.size, users.id AS user_id, users.first_name, users.last_name, users.email_address, users.phone_number 
                                     FROM parcels 
                                     JOIN users ON parcels.user_id = users.id 
                                     WHERE parcels.parcel_number = ?");
        $stmt->bind_param("s", $parcel_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            unset($row['id']); // Ne küldjük vissza az adatbázis belső azonosítóját
            return $row;
        } else {
            http_response_code(404);
            return array("error" => "Parcel not found.");
        }
    }

    public function addParcel($size, $user_id)
    {
        $parcel_number = bin2hex(random_bytes(5)); // Egyedi csomagszám generálása

        // Méret ellenőrzése
        $allowed_sizes = array("S", "M", "L", "XL");
        if (!in_array($size, $allowed_sizes)) {
            http_response_code(400);
            return array("error" => "Invalid parcel size. Allowed sizes are: S, M, L, XL.");
        }

        $stmt = $this->conn->prepare("INSERT INTO parcels (parcel_number, size, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $parcel_number, $size, $user_id);

        if ($stmt->execute()) {
            // Csomag sikeres hozzáadása
            return $this->getParcelByParcelNumber($parcel_number);
        } else {
            http_response_code(400);
            return array("error" => "Failed to add parcel.");
        }
    }
}

// API végpontok kezelése

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$parcel = new Parcel();

if ($method === 'GET') {
    if (isset($_GET['parcel_number'])) {
        $parcel_number = $_GET['parcel_number'];
        $response = $parcel->getParcelByParcelNumber($parcel_number);
    } else {
        http_response_code(400);
        $response = array("error" => "Missing parcel_number parameter.");
    }
} elseif ($method === 'POST') {
    $input_data = json_decode(file_get_contents("php://input"), true);

    if (isset($input_data['size']) && isset($input_data['user_id'])) {
        $size = $input_data['size'];
        $user_id = $input_data['user_id'];
        $response = $parcel->addParcel($size, $user_id);
    } else {
        http_response_code(400);
        $response = array("error" => "Missing size or user_id parameters.");
    }
} else {
    http_response_code(404);
    $response = array("error" => "Endpoint not found.");
}

echo json_encode($response);