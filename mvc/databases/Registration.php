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

