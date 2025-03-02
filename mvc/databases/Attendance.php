<?php

function getAttendance($status): mysqli_result|bool
{
    $conn = getConnection();
    
    $sql = 'SELECT event.event_id, event.creator_id, event.event_name, event.description, event.date, event.location, event.max_participants, event.image
            FROM user
            JOIN registration ON user.user_id = registration.user_id
            JOIN event ON registration.event_id = event.event_id
            LEFT JOIN attendance ON user.user_id = attendance.user_id 
            AND event.event_id = attendance.event_id
            WHERE registration.status = ?
            AND user.user_id = ?';

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $user_id = $_SESSION['user_id'];
    $stmt->bind_param('si', $status, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function addatten($event_id,$status): mysqli_result|bool
{
    $conn = getConnection();
    $user_id = $_SESSION['user_id'];
    $check_in_time = date("Y-m-d H:i:s");
    $sql = 'INSERT INTO attendance (event_id, user_id,check_in_status , check_in_time) VALUES (?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('iiss', $event_id, $user_id,$status, $check_in_time);
    $result = $stmt->execute();
    return $result;
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
