<?php
$event_name = $_POST['event_name'] ?? '';
$date = $_POST['datetime'] ?? '';
$location = $_POST['location'] ?? '';
$max_participants = isset($_POST['max_participants']) ? (int)$_POST['max_participants'] : 0;
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


$res = addEvent(
    $event_name,
    $description,
    $date,
    $location,
    $max_participants,
    $image_paths
);

if ($res) {
    $_SESSION['message'] = '✅ Event added successfully!';
    renderView('Event_get');
} else {
    echo json_encode(["error" => "❌ Failed to add event"]);
    exit;
}

// $event_name = isset($_POST['event_name']) ? $_POST['event_name'] : '';
// $date = isset($_POST['datetime']) ? $_POST['datetime'] : '';
// $location = isset($_POST['location']) ? $_POST['location'] : '';
// $max_participants = isset($_POST['max_participants']) ? (int) $_POST['max_participants'] : 0;
// $description = isset($_POST['description']) ? $_POST['description'] : '';

// $image_path = '';

// $upload_dir = '/home/demoweblnw/public_html/public/uploads/';

// if (!is_dir($upload_dir)) {
//     mkdir($upload_dir, 0777, true); 
// }

// $image_name = time() . '_' . basename($_FILES['image']['name']);
// $image_path = $upload_dir . $image_name;
// if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
//     die("❌ Error uploading image.");
// }

// $image_path_db = 'uploads/' . $image_name;

// // ตรวจสอบว่ามีค่าครบทุกช่องหรือไม่
// if (empty($event_name) || empty($date) || empty($location) || empty($max_participants) || empty($description) || empty($image_path)) {
//     echo json_encode(["error" => "❌ All fields are required"]);
//     exit;
// }

// // เพิ่มข้อมูลลงฐานข้อมูล
// $res = addEvent(
//     $event_name,
//     $description,
//     $date,
//     $location,
//     $max_participants,
//     $image_path_db
// );

// if ($res) {    
//     $_SESSION['message'] = '✅ Course added successfully!';
//     renderView('Event_get');
// }
