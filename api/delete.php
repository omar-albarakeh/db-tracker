<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));
if (isset($data->id)) {
    $stmt = $conn->prepare("DELETE FROM transactions WHERE id = ?");
    $stmt->execute([$data->id]);
    echo json_encode(["message" => "Transaction deleted successfully"]);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
