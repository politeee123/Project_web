<?php
$event_id = $_GET['event_id'] ?? null;
$user_id = $_SESSION['user_id'];
$result = getEventById($event_id);
renderView('check_get', array('result' => $result));