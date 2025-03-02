<?php

$user_id = $_SESSION['user_id']; 
$events = getEventsByUser($user_id);

renderView('event_manage_get', array('result' => $events));
?>
