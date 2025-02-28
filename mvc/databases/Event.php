<?php

function getEvent(): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'select * from event';
    $result = $conn->query($sql);
    return $result;
}
function getEventByKeyword(string $keyword): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'select * from event where event_name like ?';
    $stmt = $conn->prepare($sql);
    $keyword = '%'. $keyword .'%';
    $stmt->bind_param('s',$keyword);
    $res = $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function addEvent(string $event_name, string $date, string $location, int $max_participants, string $description, string $image): bool
{
    $conn = getConnection();
    $sql = 'insert into event (event_name, description, date, location, description, max_participants, image) values (?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssis', $event_name,$description,$date,$location,$max_participants,$image);
    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}
