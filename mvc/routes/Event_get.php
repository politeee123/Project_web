<?php
declare(strict_types=1);

$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;

if ($start_date && $end_date) {
    $result = getEventbyDate($start_date, $end_date);
} elseif (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
    $result = getEventByKeyword($_GET['keyword']);
} else {
    $result = getEvent();
}

renderView('Event_get', array('result' => $result));