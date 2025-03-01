<?php

function getEvent(): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'SELECT * FROM event';
    return $conn->query($sql);
}

function getEventByKeyword(string $keyword): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'SELECT * FROM event WHERE event_name LIKE ?';
    $stmt = $conn->prepare($sql);
    $keyword = '%' . $keyword . '%';
    $stmt->bind_param('s', $keyword);
    $stmt->execute();
    return $stmt->get_result();
}
function getEventById(int $event_id):mysqli_result|bool{
    $conn = getConnection();
    $sql = 'SELECT * FROM event WHERE event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getEventsByUser(int $user_id): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'SELECT * FROM event WHERE creator_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

function addEvent(string $event_name, string $description, string $date, string $location, int $max_participants, string $image) {
    $conn = getConnection();
    $sql = 'INSERT INTO event (creator_id, event_name, description, date, location, max_participants, image) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param(
        'issssis', 
        $_SESSION['user_id'],
        $event_name, 
        $description, 
        $date, 
        $location, 
        $max_participants, 
        $image
    );
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

