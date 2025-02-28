<?php

function getUser(): mysqli_result|bool{
    $conn = getConnection();
    $sql = 'select * from users';
    $result = $conn->query($sql);
    return $result;
}