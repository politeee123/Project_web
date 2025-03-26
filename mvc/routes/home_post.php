<?php
$status = $_POST['status'] ?? 'pending';

if ($status == 'approved') {
    $result = getAttendance('approved');
} elseif ($status == 'rejected') {
    $result = getAttendance('rejected');
} else {
    $result = getAttendance('pending');
}

renderView('home_get', array('result' => $result));
