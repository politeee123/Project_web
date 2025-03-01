<?php
$event_id = $_POST['event_id'];
$status = $_POST['status'];

if (empty($event_id) || empty($status)) {
    $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบ";
}

$res = addRegistration($event_id,$status);
if ($res) {    
    renderView('Event_get');
} else {
    badRequest(message: 'มีคนใช้ชื่อนี้แล้ว');
}