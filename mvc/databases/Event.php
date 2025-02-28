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
