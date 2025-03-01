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
function addEvent(string $event_name,string $description,string $date,string $location,int $max_participants,string $image): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'INSERT INTO event (event_name,description,date,location,max_participants,image) VALUES (?,?,?,?,?,?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $event_name);
    $stmt->bind_param('s', $description);
    $stmt->bind_param('s', $date);
    $stmt->bind_param('s', $location);
    $stmt->bind_param('i', $max_participants);
    $stmt->bind_param('s', $image);
    $stmt->execute();
    return $stmt->get_result();
}