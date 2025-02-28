<?php

$event_name = $_POST['event_name'] ?? '';
$date = $_POST['date'] ?? '';
$location = $_POST['location'] ?? '';
$max_participants = $_POST['max_participants'] ?? '';
$description = $_POST['description'] ?? '';
$image = $_FILES['image']['name'] ?? '';

if (empty($event_name) || empty($date) || empty($location) || empty($max_participants) || empty($description) || empty($image)) {
    badRequest("All fields are required");
}
$res = addEvent($event_name, $description,$date, $location, $max_participants, $image);

if ($res) {
    $_SESSION['message'] = 'Event added successfully!';
    renderView('Event_get');
} else {
    badRequest(message: 'Something went wrong! on insert event');
}

