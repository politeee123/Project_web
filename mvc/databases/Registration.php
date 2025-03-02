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

function getUser_status($event_id): ?mysqli_result {
    $conn = getConnection();

    if (!$conn) {
        die("❌ Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT user.username, registration.status 
            FROM user
            JOIN registration ON user.user_id = registration.user_id
            WHERE registration.event_id = ? 
            AND registration.status = 'approved'";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    if (!$stmt->execute()) {
        error_log("❌ Query failed: " . $conn->error);
        return null;
    }
    $result = $stmt->get_result();
    return $result ?: null;
}

function UpdateStatus($user_id, $event_id, $status): bool {
    $conn = getConnection();

    $sql = "UPDATE registration SET status = ? WHERE user_id = ? AND event_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $event_id, $_SESSION['user_id'], $status);
    
    $result = $stmt->execute();
    
    $stmt->close();
    $conn->close();

    return $result;
}
