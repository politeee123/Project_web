<?php

declare(strict_types=1);

$username = $_POST['username']?? '';
$password = $_POST['password']?? '';
if (empty($username) || empty($password)) {
    $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบ";
    header('Location: /login');
    exit();
}
$user = findByUsername($username);
if ($username && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $unix_timestamp = time();
    $_SESSION['timestamp'] = $unix_timestamp;
    header('Location: /');
} else {
    $_SESSION['error'] = "Username หรือ Password ไม่ถูกต้อง";
    login('login_get');
}
// Assume that login success
// $unix_timestamp = time();
// $_SESSION['timestamp'] = $unix_timestamp;

// header('Location: /');

