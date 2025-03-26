<?php
$event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;
$event_name = $_POST['event_name'] ?? '';
$date = $_POST['datetime'] ?? '';
$location = $_POST['location'] ?? '';
$max_participants = isset($_POST['max_participants']) ? (int)$_POST['max_participants'] : 0;
$description = $_POST['description'] ?? '';

$upload_dir = __DIR__ . '/../public/uploads/';

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
        $result = getEventById($event_id);
        $image_name = time() . '_' . basename($_FILES['images']['name'][$key]);
        $image_path = $upload_dir . $image_name;
        $file_type = mime_content_type($tmp_name);
        $file_size = $_FILES['images']['size'][$key];

        if (!in_array($file_type, $allowed_types)) {
            $_SESSION['error'] = "❌ ประเภทไฟล์นี้ไม่ถูกต้อง, jpeg, png, gif เท่านั้น: " . $_FILES['images']['name'][$key];
            renderView('edit_event_get',array('result' => $result));
            exit;
        }
        if ($file_size > $max_file_size) {
            $_SESSION['error'] = "❌ ไฟล์นี้ใหญ่เกิน: " . $_FILES['images']['name'][$key];
            renderView('edit_event_get',array('result' => $result));
            exit;
        }
        
        if (move_uploaded_file($tmp_name, $image_path)) {
            $image_paths[] = 'uploads/' . $image_name;
        } else {
            $_SESSION['error'] = "❌ ไฟล์นี้ไม่สามารถอัพโหลดได้: " . $_FILES['images']['name'][$key];
            renderView('edit_event_get',array('result' => $result));
            exit;
        }
        
    }
} else {
    $event_data = getEventById($event_id);
    $image_paths = json_decode($event_data['images'], true) ?? [];
}

$res = updateEvent($event_id, $event_name, $description, $date, $location, $max_participants, $image_paths);

if ($res) {
    $_SESSION['message'] = '✅ Event updated successfully!';
    renderView('Event_get', ['result' => getEvent()]);
} else {
    badRequest('❌ Failed to update event.');
    renderView('Event_get', ['result' => getEvent()]);
}