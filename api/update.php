<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));
if (isset($data->id) && isset($data->notes) && isset($data->amount) && isset($data->type)) {
    $stmt = $conn->prepare("UPDATE transactions SET notes = ?, amount = ?, type = ? WHERE id = ?");
    $stmt->execute([$data->notes, $data->amount, $data->type, $data->id]);
    echo json_encode(["message" => "Transaction updated successfully"]);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
