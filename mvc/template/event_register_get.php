<?php
// ตรวจสอบว่ามีค่า event_id ใน URL หรือไม่
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // เชื่อมต่อกับฐานข้อมูล (ต้องปรับตามการเชื่อมต่อฐานข้อมูลของคุณ)
    $conn = getConnection();

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ดึงข้อมูลกิจกรรมจากฐานข้อมูล
    $sql = "SELECT * FROM events WHERE event_id = $event_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // แสดงข้อมูลกิจกรรม
        $row = $result->fetch_assoc();
        echo '<div class="container">';
        echo '<h1>' . $row['event_name'] . '</h1>';
        echo '<p><strong>Date:</strong> ' . $row['date'] . '</p>';
        echo '<p><strong>Location:</strong> ' . $row['location'] . '</p>';
        echo '<p><strong>Max Participants:</strong> ' . $row['max_participants'] . '</p>';
        echo '<p><strong>Description:</strong> ' . $row['description'] . '</p>';
        // เพิ่มปุ่ม Register หรืออื่นๆ ตามที่ต้องการ
        echo '<a href="register_action.php?id=' . $row['event_id'] . '" class="btn btn-success">Confirm Registration</a>';
        echo '</div>'; // container
    } else {
        echo '<p>Event not found.</p>';
    }

    $conn->close();
} else {
    echo '<p>No event ID provided.</p>';
}
?>
