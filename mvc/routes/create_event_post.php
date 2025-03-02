<?php
$event_name = $_POST['event_name'] ?? '';
$date = $_POST['datetime'] ?? '';
$location = $_POST['location'] ?? '';
$max_participants = isset($_POST['max_participants']) ? (int) $_POST['max_participants'] : 0;
$description = $_POST['description'] ?? '';

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


if (empty($event_name) || empty($date) || empty($location) || empty($max_participants) || empty($description)|| empty($image_path)) {
    badRequest("All fields are required");
}

$res = addEvent(
    $event_name,
    $description,
    $date,
    $location,
    $max_participants,
    $image_path_db
);
if ($res) {    
    $_SESSION['message'] = 'Course added successfully!';
    renderView('Event_get');
} else {
    badRequest(message: 'Error: Could not insert event.');
}