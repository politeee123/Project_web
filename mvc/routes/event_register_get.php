<?php

$event_id = $_GET['event_id'] ?? null;
$result = getEventById($event_id);
renderView('event_register_get',array('result' => $result));
