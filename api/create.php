<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));
if (isset($data->notes) && isset($data->amount) && isset($data->type)) {
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, notes, amount, type) VALUES (1, ?, ?, ?)"); 
    $stmt->execute([$data->notes, $data->amount, $data->type]);
    echo json_encode(["message" => "Transaction added successfully"]);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
