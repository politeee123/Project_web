<?php
declare(strict_types=1);

if (!isset($_GET['keyword'])) {
    $result = getEvent();
    renderView('Event_get', array('result' => $result));
} elseif ($_GET['keyword'] == '') {
    $result = getEvent();
    renderView('Event_get', array('result' => $result));
} else {
    $result = getEventByKeyword($_GET['keyword']);
    renderView('Event_get', array('result' => $result));
}
