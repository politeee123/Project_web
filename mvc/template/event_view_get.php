<?php
// ตรวจสอบว่ามีผลลัพธ์จากฐานข้อมูลหรือไม่
if (isset($data['result']) && $data['result']->num_rows > 0) {
    // ดึงข้อมูลกิจกรรมจากผลลัพธ์
    $event = $data['result']->fetch_assoc();

    echo '<h1 class="text-center">Event Details</h1>';
    echo '<div class="container">';
    echo '<div class="row justify-content-center">';
    echo '<div class="col-md-6 mb-4">';
    echo '<div class="card shadow-sm h-100">';

    // แสดงภาพกิจกรรม
    $image_path = !empty($event['image']) ? '/' . htmlspecialchars($event['image']) : '/public/uploads/default.jpg';
    echo '<img src="' . $image_path . '" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">';

    // ข้อมูลกิจกรรม
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . htmlspecialchars($event['event_name']) . '</h5>';
    echo '<p class="card-text"><strong>Date:</strong> ' . htmlspecialchars($event['date']) . '</p>';
    echo '<p class="card-text"><strong>Location:</strong> ' . htmlspecialchars($event['location']) . '</p>';
    echo '<p class="card-text"><strong>Max Participants:</strong> ' . htmlspecialchars($event['max_participants']) . '</p>';
    echo '<p class="card-text"><strong>Description:</strong> ' . htmlspecialchars($event['description']) . '</p>';
    echo '</div>'; // ปิด card-body

    // ปุ่มสำหรับการแก้ไขอีเวนต์
    echo '<div class="card-footer text-center">';
    echo '<a href="event_edit.php?event_id=' . htmlspecialchars($event['event_id']) . '" class="btn btn-primary">Edit Event</a>';
    echo '</div>'; // ปิด card-footer

    echo '</div>'; // ปิด card
    echo '</div>'; // ปิด col-md-6
    echo '</div>'; // ปิด row
    echo '</div>'; // ปิด container

    // ตรวจสอบคำขอที่ส่งเข้าร่วมกิจกรรม (จากฐานข้อมูล)
    echo '<h2 class="text-center mt-4">Requests for Joining</h2>';
    // สมมุติว่า $requests เป็นการดึงคำขอเข้าร่วมจากฐานข้อมูล
    

    if ($requests && $requests->num_rows > 0) {
        echo '<table class="table table-bordered mt-3">';
        echo '<thead><tr><th>User</th><th>Status</th><th>Action</th></tr></thead>';
        echo '<tbody>';

        // ลูปเพื่อแสดงคำขอจากผู้ใช้
        while ($request = $requests->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($request['username']) . '</td>';
            echo '<td>' . htmlspecialchars($request['status']) . '</td>';
            echo '<td>';

            // ถ้าสถานะคำขอเป็น "pending" ให้แสดงปุ่มยอมรับและยกเลิก
            if ($request['status'] === 'pending') {
                echo '<a href="accept_request.php?request_id=' . htmlspecialchars($request['registration_id']) . '" class="btn btn-success">Accept</a>';
                echo ' <a href="reject_request.php?request_id=' . htmlspecialchars($request['registration_id']) . '" class="btn btn-danger">Reject</a>';
            } else {
                echo '-';
            }

            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="text-center">No requests found.</p>';
    }

} else {
    echo '<p class="text-center">Event not found.</p>';
}
?>
