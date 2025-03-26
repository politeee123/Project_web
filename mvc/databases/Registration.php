<?php

function getRegistration() {
    $conn = getConnection();
    $sql = 'SELECT * FROM registration';

    // ตรวจสอบว่าคำสั่ง SQL ทำงานสำเร็จหรือไม่
    $result = $conn->query($sql);
    if (!$result) {
        return false; // คืนค่า false หากเกิดข้อผิดพลาด
    }

    return $result;
}
function addRegistration($event_id, $status = 'pending') {
    $conn = getConnection();
    $user_id = $_SESSION['user_id'];
    $date = date('Y-m-d H:i:s'); 

    $check_sql = "SELECT COUNT(*) FROM registration WHERE event_id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $event_id, $user_id);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        return false; 
    }

    $sql = "INSERT INTO registration (event_id, user_id, status, registration_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $event_id, $user_id, $status, $date);

    return $stmt->execute();
}

// function getUser_status($event_id,$status): ?mysqli_result {
//     $conn = getConnection();

//     if (!$conn) {
//         die("❌ Connection failed: " . mysqli_connect_error());
//     }
//         $sql = "SELECT * 
//                 FROM User, Registration 
//                 WHERE user.user_id = registration.user_id 
//                 AND registration.event_id = ? 
//                 AND registration.status = ?";
        
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("is", $event_id,$status);
//     if (!$stmt->execute()) {
//         error_log("❌ Query failed: " . $conn->error);
//         return null;
//     }
//     $result = $stmt->get_result();
//     return $result ?: null;
// }
function getUser_status($event_id, $status) {
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
    if (!$stmt) {
        die("❌ Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("is", $event_id, $status);
    
    if (!$stmt->execute()) {
        error_log("❌ Query failed: " . $stmt->error);
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

function updateRegistrationStatus($user_id, $event_id): bool {
    $conn = getConnection();
    $sql = "UPDATE registration SET status = 'rejected' WHERE  user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii",  $user_id, $event_id);
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
