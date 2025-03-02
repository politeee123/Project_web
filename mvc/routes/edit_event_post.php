<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = (int) $_POST['event_id'];
    $event_name = trim($_POST['event_name']);
    $description = trim($_POST['description']);
    $date = trim($_POST['datetime']);
    $location = trim($_POST['location']);
    $max_participants = (int) $_POST['max_participants'];
    $image_path = '';

    $upload_dir = __DIR__ . '/../public/uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $image_name = time() . '_' . basename($_FILES['image']['name']);
    $image_path = $upload_dir . $image_name;
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        die("Error uploading image.");
    }

    $image_path_db = 'uploads/' . $image_name;


    if (updateEvent($event_id, $event_name, $description, $date, $location, $max_participants, $image_path_db )) {
        renderView('Event_get');
    } else {
        echo "Error updating event.";
    }
}
