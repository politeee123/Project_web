<?php
$event_id = $_GET['event_id'] ?? null;
$result = getUser_status($event_id,'pending');
renderView('check_status_get',array('result' => $result));