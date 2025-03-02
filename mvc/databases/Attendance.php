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
        die("Prepare failed: " . $conn->error); // Debug ข้อผิดพลาดถ้า prepare ล้มเหลว
    }

    $user_id = $_SESSION['user_id']; // ดึงค่า user_id จาก session  
    $stmt->bind_param('si', $status, $user_id); // 's' สำหรับ string, 'i' สำหรับ integer  
    $stmt->execute();
    
    $result = $stmt->get_result(); // ใช้ get_result() เพื่อดึงข้อมูล  
    return $result;
}


function addCheck_in(): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'SELECT *
            FROM user
            JOIN registration ON user.user_id = registration.user_id
            JOIN event ON registration.event_id = event.event_id
            LEFT JOIN attendance ON user.user_id = attendance.user_id AND event.event_id = attendance.event_id
            WHERE registration.status = ?';
;
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    return $result;
}
