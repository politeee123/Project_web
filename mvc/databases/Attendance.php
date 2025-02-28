<?php

function getAttendanece(): mysqli_result|bool{
    $conn = getConnection();
    $sql = 'select * from attendance';
    $result = $conn->query($sql);
    return $result;
}