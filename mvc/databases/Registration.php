<?php

function getRegistration(): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'select * from registration';
    $result = $conn->query($sql);
    return $result;
}
function addRegistration($event_id, $status = 'pending') {
    $conn = getConnection();
    $date = date('Y-m-d H:i:s'); 

    $sql = 'INSERT INTO registration (event_id, user_id, status, registration_date) VALUES (?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiss', $event_id, $_SESSION['user_id'], $status, $date);
    
    if ($stmt->execute()) {
        return true; 
    } else {
        return false; 
    }
}

function getUser_status(): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'SELECT user.username, registration.status 
            FROM user, registration 
            WHERE user.user_id = registration.user_id;';
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    return $result;
}
function UpdateStatus($user_id, $event_id, $status): bool {
    $conn = getConnection();

    $sql = "UPDATE registration SET status = ? WHERE user_id = ? AND event_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $status, $user_id, $event_id);
    
    $result = $stmt->execute();
    
    $stmt->close();
    $conn->close();

    return $result;
}
