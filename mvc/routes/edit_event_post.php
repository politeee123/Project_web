<?php
$event_id = (int) $_POST['event_id'] ?? '';
$event_name = $_POST['event_name'] ?? '';
$date = $_POST['datetime'] ?? '';
$location = $_POST['location'] ?? '';
$max_participants = (int) $_POST['max_participants'];
$description = $_POST['description'] ?? '';

$upload_dir = '/home/demoweblnw/public_html/public/uploads/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$image_paths = [];
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_file_size = 5 * 1024 * 1024;

if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
            echo json_encode(["error" => "❌ File upload error: " . $_FILES['images']['name'][$key]]);
            exit;
        }

        $image_name = time() . '_' . basename($_FILES['images']['name'][$key]);
        $image_path = $upload_dir . $image_name;
        $file_type = mime_content_type($tmp_name);
        $file_size = $_FILES['images']['size'][$key];

        if (!in_array($file_type, $allowed_types)) {
            echo json_encode(["error" => "❌ Invalid file type: " . $_FILES['images']['name'][$key]]);
            exit;
        }
        if ($file_size > $max_file_size) {
            echo json_encode(["error" => "❌ File too large: " . $_FILES['images']['name'][$key]]);
            exit;
        }

        if (move_uploaded_file($tmp_name, $image_path)) {
            $image_paths[] = 'uploads/' . $image_name;
        } else {
            echo json_encode(["error" => "❌ Failed to upload: " . $_FILES['images']['name'][$key]]);
            exit;
        }
    }
}

    $res = updateEvent($event_id,$event_name,$description,$date,$location,$max_participants,$image_paths);
    if ($res) {
        renderView('Event_get',array('result' => getEvent()));
    } else {
        badRequest('Failed to update event.');
        renderView('Event_get',array('result' => getEvent()));
    }

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $event_id = (int) $_POST['event_id'];
//     $event_name = trim($_POST['event_name']);
//     $description = trim($_POST['description']);
//     $date = trim($_POST['datetime']);
//     $location = trim($_POST['location']);
//     $max_participants = (int) $_POST['max_participants'];
//     $image_path = '';

//     $upload_dir = __DIR__ . '/../public/uploads/';

//     if (!is_dir($upload_dir)) {
//         mkdir($upload_dir, 0777, true);
//     }

//     $image_name = time() . '_' . basename($_FILES['image']['name']);
//     $image_path = $upload_dir . $image_name;
//     if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
//         die("Error uploading image.");
//     }

//     $image_path_db = 'uploads/' . $image_name;


//     if (updateEvent($event_id, $event_name, $description, $date, $location, $max_participants, $image_path_db )) {
//         renderView('Event_get');
//     } else {
//         echo "Error updating event.";
//     }
// }
