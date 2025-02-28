<?php

function getUser(): mysqli_result|bool{
    $conn = getConnection();
    $sql = 'select * from users';
    $result = $conn->query($sql);
    return $result;
}
function addUser(string $username, string $password, string $email, string $role): bool
{
    $conn = getConnection();
    $sql = 'insert into users (username, password, email, role) values (?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $username, $password, $email, $role);
    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}
