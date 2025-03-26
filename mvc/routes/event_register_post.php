<?php
$event_id = $_POST['event_id'] ?? null;
$status = $_POST['status'] ?? null;

if (empty($event_id) || empty($status)) {
    $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบ";
}

$res = addRegistration($event_id,$status);
if ($res) {    
    renderView('Event_get');
} else {
    badRequest('คุณลงทะเบียนไปแล้ว');
    renderView('Event_get',array('result' => getEvent()));
}
