<?php

function getUser(): mysqli_result|bool{
    $conn = getConnection();
    $sql = 'select * from users';
    $result = $conn->query($sql);
    return $result;
}
function findByUsername(string $username) {
    $conn = getConnection();
    $sql = "SELECT user_id, username, password FROM user WHERE username = ?";
    $stmt = $conn -> prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
function addUser(string $user_name, string $password, string $email, string $role): bool {
    $conn = getConnection();

    // ตรวจสอบว่า username มีอยู่ในฐานข้อมูลหรือยัง
    $sql_check = 'SELECT COUNT(*) FROM user WHERE username = ?';
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('s', $user_name);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        return false;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = 'INSERT INTO user (username, password, email, role) VALUES (?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param('ssss', $user_name, $hashed_password, $email, $role);
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}
