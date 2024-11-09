<?php
include "../api/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo 'Registration successful! <a href="../html/login.html">Login here</a>';
        } else {
            echo 'Error: No rows were inserted. Please try again.';
        }
    } else {
        echo 'Error executing query. Please try again.';
    }

    $stmt->close();
}
?>