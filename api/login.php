<?php
include "../api/cdb.php";
if(isset($_SERVER['Requested_Method'] == 'POST')){
    $username=$_Post['user'];
    $password=$Post['password'];

    $query=$connection->prepare("SELECT * FROM users WHERE id WHERE username = ?");
    $query->bind_parm("s",$username);
    $query->excute();
    $results=$querry->get_result();
    $user=$results->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
            header("Location: ../index.html?user=" . urlencode($username));
            exit();
        } 
else {
            header("Location: login-page.html?error=Invalid%20username%20or%20password");
            exit();
        }
}
?>