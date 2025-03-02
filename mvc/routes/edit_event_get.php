<?php
$event_id = $_GET['event_id'] ?? null;
$result = getEventById($event_id);
renderView('edit_event_get',array('result' => $result));
