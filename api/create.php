<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));
if (isset($data->userId) && isset($data->amount) && isset($data->description)) {
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, amount, description) VALUES (?, ?, ?)");
    $stmt->execute([$data->userId, $data->amount, $data->description]);
    echo json_encode(["message" => "Transaction added successfully"]);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
