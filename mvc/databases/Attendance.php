<?php

// function getAttendance($status): mysqli_result|bool
// {
//     $conn = getConnection();
    
//     $sql = 'SELECT event.event_id, event.creator_id, event.event_name, event.description, event.date, event.location, event.max_participants, event.image
//             FROM user
//             JOIN registration ON user.user_id = registration.user_id
//             JOIN event ON registration.event_id = event.event_id
//             LEFT JOIN attendance ON user.user_id = attendance.user_id 
//             AND event.event_id = attendance.event_id
//             WHERE registration.status = ?
//             AND user.user_id = ?';

//     $stmt = $conn->prepare($sql);
//     if (!$stmt) {
//         die("Prepare failed: " . $conn->error);
//     }
//     if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
//         echo "";
//     } else {
//         $user_id = $_SESSION['user_id'];
//     }
    
//     $stmt->bind_param('si', $status, $user_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     return $result;
// }

function getAttendance($status) {
    $conn = getConnection();
    
    $sql = 'SELECT event.event_id, event.creator_id, event.event_name, event.description, event.date, event.location, event.max_participants, event.image, registration.status, attendance.check_in_status
            FROM user
            JOIN registration ON user.user_id = registration.user_id
            JOIN event ON registration.event_id = event.event_id
            LEFT JOIN attendance ON user.user_id = attendance.user_id 
            AND event.event_id = attendance.event_id
            WHERE registration.status = ?
            AND user.user_id = ?';

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }

    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        return false;
    }

    $user_id = $_SESSION['user_id'];

    $stmt->bind_param('si', $status, $user_id);
    $stmt->execute();

    return $stmt->get_result();
}


// function addatten($event_id,$status): mysqli_result|bool
// {
//     $conn = getConnection();
//     $user_id = $_SESSION['user_id'];
//     $check_in_time = date("Y-m-d H:i:s");
//     $sql = 'INSERT INTO attendance (event_id, user_id,check_in_status , check_in_time) VALUES (?, ?, ?, ?)';
//     $stmt = $conn->prepare($sql);
//     if (!$stmt) {
//         die("Prepare failed: " . $conn->error);
//     }
//     $stmt->bind_param('iiss', $event_id, $user_id,$status, $check_in_time);
//     $result = $stmt->execute();
//     return $result;
// }

function addatten($event_id, $status) {
    $conn = getConnection();
    $user_id = $_SESSION['user_id'];
    $check_in_time = date("Y-m-d H:i:s");

    $sql_check = "SELECT * FROM attendance WHERE event_id = ? AND user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    if (!$stmt_check) {
        return false;
    }
    $stmt_check->bind_param('ii', $event_id, $user_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $sql_update = "UPDATE attendance SET check_in_status = ?, check_in_time = ? WHERE event_id = ? AND user_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        if (!$stmt_update) {
            return false;
        }
        $stmt_update->bind_param('ssii', $status, $check_in_time, $event_id, $user_id);
        return $stmt_update->execute();
    } else {
        $sql_insert = "INSERT INTO attendance (event_id, user_id, check_in_status, check_in_time) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        if (!$stmt_insert) {
            return false;
        }
        $stmt_insert->bind_param('iiss', $event_id, $user_id, $status, $check_in_time);
        return $stmt_insert->execute();
    }
}



// function addCheck_in(): mysqli_result|bool
// {
//     $conn = getConnection();
//     $sql = 'SELECT *
//             FROM user
//             JOIN registration ON user.user_id = registration.user_id
//             JOIN event ON registration.event_id = event.event_id
//             LEFT JOIN attendance ON user.user_id = attendance.user_id AND event.event_id = attendance.event_id
//             WHERE registration.status = ?';
// ;
//     $stmt = $conn->prepare($sql);
//     $result = $stmt->execute();
//     return $result;
// }
