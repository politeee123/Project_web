<?php
// รับข้อมูลอีเวนต์จากการเรียกฟังก์ชัน getEventsByUser
if (isset($data['result']) && $data['result']->num_rows > 0) {
    echo '<div class="container">';
    echo '<div class="row">';

    // ใช้ while เพื่อแสดงแต่ละอีเวนต์ที่ได้จากการดึงข้อมูล
    while ($row = $data['result']->fetch_assoc()) { 
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card shadow-sm h-100">';

        // ตรวจสอบหากมีภาพสำหรับอีเวนต์
        $image_path = !empty($row['image']) ? '/' . htmlspecialchars($row['image']) : '/public/uploads/default.jpg';
        
        // แสดงภาพและข้อมูลอีเวนต์
        echo '<img src="' . $image_path . '" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['event_name']) . '</h5>';
        echo '<p class="card-text"><strong>Date:</strong> ' . htmlspecialchars($row['date']) . '</p>';
        echo '<p class="card-text"><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p class="card-text"><strong>Max Participants:</strong> ' . htmlspecialchars($row['max_participants']) . '</p>';
        echo '<p class="card-text"><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
        echo '<a href="event_view?event_id=' . htmlspecialchars($row['event_id']) . '" class="btn btn-primary">View</a>';


        ?>
        <?php
        echo '</div>'; // ปิด card-body
        echo '</div>'; // ปิด card
        echo '</div>'; // ปิด col-md-4
    }
    echo '</div>'; // ปิด row
    echo '</div>'; // ปิด container
} else {
    echo '<p class="text-center">No events found.</p>';
}
?>
