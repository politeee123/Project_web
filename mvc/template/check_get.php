<?php
// ตรวจสอบว่ามีผลลัพธ์จากฐานข้อมูลหรือไม่

if (!empty($data['result']) && $data['result']->num_rows > 0) {
    // ดึงข้อมูลกิจกรรมจากผลลัพธ์
    $event = $data['result']->fetch_assoc();

    echo '<h1 class="text-center">Event Details</h1>';
    echo '<div class="container">';
    echo '<div class="row justify-content-center">';
    echo '<div class="col-md-6 mb-4">';
    echo '<div class="card shadow-sm h-100">';

    // แสดงภาพกิจกรรม
    $image_path = !empty($event['image']) ? '/' . htmlspecialchars($event['image']) : '/public/uploads/default.jpg';
    echo sprintf('<img src="%s" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">', $image_path);

    // ข้อมูลกิจกรรม
    echo '<div class="card-body">';
    echo sprintf('<h5 class="card-title">%s</h5>', htmlspecialchars($event['event_name']));
    echo sprintf('<p class="card-text"><strong>Date:</strong> %s</p>', htmlspecialchars($event['date']));
    echo sprintf('<p class="card-text"><strong>Location:</strong> %s</p>', htmlspecialchars($event['location']));
    echo sprintf('<p class="card-text"><strong>Max Participants:</strong> %s</p>', htmlspecialchars($event['max_participants']));
    echo sprintf('<p class="card-text"><strong>Description:</strong> %s</p>', htmlspecialchars($event['description']));
    echo '</div>'; // ปิด card-body

    // ปุ่มสำหรับการแก้ไขอีเวนต์
    echo '<div class="card-footer text-center">';
?>
    <main>
        <form action="check" method="POST">
            <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['event_id']); ?>">
            <label for="status">Status:</label>
            <select name="status" class="form-select">
                <option value="pending">Check in</option>
                <option value="rejected">Check Out</option>
            </select>
            <button>Summit</button>
        </form>
        </select>
    </main>

<?php
    echo '</div>'; // ปิด card-footer

    echo '</div>'; // ปิด card
    echo '</div>'; // ปิด col-md-6
    echo '</div>'; // ปิด row
    echo '</div>'; // ปิด container



} else {
    echo '<p class="text-center">Event not found.</p>';
}
?>