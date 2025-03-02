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

function getUser_status($event_id,$status): ?mysqli_result {
    $conn = getConnection();

    if (!$conn) {
        die("❌ Connection failed: " . mysqli_connect_error());
    }
        $sql = "SELECT * 
                FROM user, registration 
                WHERE user.user_id = registration.user_id 
                AND registration.event_id = ? 
                AND registration.status = ?";
        
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $event_id,$status);
    if (!$stmt->execute()) {
        error_log("❌ Query failed: " . $conn->error);
        return null;
    }
    $result = $stmt->get_result();
    return $result ?: null;
}
function deleteRegistration($user_id, $event_id): bool {
    $conn = getConnection();
    $sql = "DELETE FROM registration WHERE status = 'rejected' AND user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    return $stmt->execute();
}
function UpdateStatus($user_id, $event_id, $status): bool {
    $conn = getConnection();

    $sql = "UPDATE registration SET status = ? WHERE user_id = ? AND event_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii",$status, $user_id,$event_id);
    
    $result = $stmt->execute();
    
    $stmt->close();
    $conn->close();

    return $result;
}
