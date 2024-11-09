<?php
include 'db.php';

$userId = $_GET['userId'];
$minAmount = $_GET['minAmount'] ?? null;
$maxAmount = $_GET['maxAmount'] ?? null;
$type = $_GET['type'] ?? null;
$notes = $_GET['notes'] ?? null;
$date = $_GET['date'] ?? null;

$query = "SELECT * FROM transactions WHERE user_id = ?";
$params = [$userId];

if ($minAmount) {
    $query .= " AND amount >= ?";
    $params[] = $minAmount;
}
if ($maxAmount) {
    $query .= " AND amount <= ?";
    $params[] = $maxAmount;
}
if ($type && $type !== 'all') {
    $query .= " AND type = ?";
    $params[] = $type;
}
if ($notes) {
    $query .= " AND notes LIKE ?";
    $params[] = "%$notes%";
}
if ($date) {
    $query .= " AND DATE(created_at) = ?";
    $params[] = $date;
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
