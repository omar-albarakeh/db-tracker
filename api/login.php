<?php
include "../api/cdb.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['password'];

    $query = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $results=$query->get_result();
    $user=$results->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
            header("Location: ../html/index.html?user=" . urlencode($username));
            exit();
        } 
   else {
            header("Location: login-page.html?error=Invalid%20username%20or%20password");
            exit();
        }
}
?>