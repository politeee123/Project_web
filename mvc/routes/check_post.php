<?php
$event_id = $_POST['event_id'];
$Attandance = $_POST['status'];

if (empty($event_id) || empty($Attandance)) {
    badRequest("All fields are required");
}

$res = addatten($event_id, $Attandance);
if ($res) {
    renderView('Event_get');
}else{
    badRequest("Error");
}