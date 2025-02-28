<?php

function getRegistration(): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'select * from registration';
    $result = $conn->query($sql);
    return $result;
}
