<main>
    <h1 class="text-center mt-4">กิจกรรม</h1>
    <div class="container mt-3 mb-3">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <form class="p-3 bg-light rounded shadow" action="Event" method="get">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="keyword" class="form-label fw-bold">ค้นหา กิจกรรม:</label>
                            <input type="text" id="keyword" name="keyword" class="form-control" placeholder="พิมพ์ชื่อกิจกรรม">
                        </div>

                        <div class="col-md-3">
                            <label for="start_date" class="form-label fw-bold">วันที่เริ่มต้น:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label for="end_date" class="form-label fw-bold">วันที่สิ้นสุด:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control">
                        </div>

                        <div class="col-md-2 text-center">
                            <button type="submit" class="btn btn-primary w-100">🔍 ค้นหา</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4 text-lg-end text-center mt-3 mt-lg-0">
                <form action="create_event" method="get">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold">➕ สร้างกิจกรรม</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($data['result'])) {
        if ($data['result']->num_rows > 0) {
            echo '<div class="container">';
            echo '<div class="row">';

            $current_time = date("Y-m-d H:i:s");

            while ($row = $data['result']->fetch_assoc()) {

                $event_id = $row['event_id'];
                $unique_id_count = getUniqueParticipantsCount($event_id);
                $max_participants = $row['max_participants'];
                $available_slots = $max_participants - $unique_id_count;

                $images = json_decode($row['image'], true);
                $image_urls = !empty($images) && is_array($images) 
                    ? array_map(fn($img) => htmlspecialchars($img), $images) 
                    : ['uploads/No_Image.png'];
                
                $image_json = json_encode($image_urls);
                $first_image = $image_urls[0];
                
    ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="<?= $first_image ?>" id="eventImage<?= $event_id ?>" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;" data-images='{"images": <?= $image_json ?>}'>
                        <div class="image-controls d-flex mt-2">
                            <button onclick="prevImage(<?= $event_id ?>)" class="btn btn-secondary">⬅️ ก่อนหน้า</button>
                            <button onclick="nextImage(<?= $event_id ?>)" class="btn btn-secondary">ถัดไป ➡️</button>
                        </div>

                        <!-- ใช้ flex-column ทำให้เนื้อหาภายในจัดเรียงแนวตั้ง -->
                        <div class="card-body d-flex flex-column">
                            <h2 class="card-title"><?= $row['event_name'] ?></h2>
                            <p class="card-text"><strong>วันที่:</strong> <?= $row['date'] ?></p>
                            <p class="card-text"><strong>ที่ตั้ง:</strong> <?= $row['location'] ?></p>
                            <p class="card-text"><strong>จำนวนผู้เข้าร่วมสูงสุด:</strong> <?= $row['max_participants'] ?></p>
                            <p class="card-text"><strong>คำอธิบาย:</strong> <?= $row['description'] ?></p>

                            <?php if ($current_time > $row['date']) { ?>
                                <!-- ทำให้ปุ่มติดด้านล่าง -->
                                <p class="card-text"><strong>ตำแหน่งที่เหลือ:</strong> ปิดรับลงทะเบียนแล้ว</p>
                                <button class="btn btn-danger mt-auto" disabled>หมดเวลาสมัคร</button>

                            <?php } elseif ($available_slots > 0) { ?>
                                <p class="card-text"><strong>ตำแหน่งที่เหลือ:</strong> <?= $unique_id_count ?>/<?= $available_slots ?></p>
                                <p class="card-text"><strong>เพอร์เซท:</strong> <?= floor(($unique_id_count / $available_slots) * 100) ?>%</p>
                                <form action="event_register" method="POST">
                                    <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                                    <input type="hidden" name="status" value="pending">
                                    <button type="submit" class="btn btn-primary mt-2">ขอเข้าร่วม</button>
                                </form>

                            <?php } else { ?>
                                <p class="card-text"><strong>ตำแหน่งที่เหลือ:</strong> เต็ม</p>
                                <button class="btn btn-secondary mt-auto" disabled>เต็มแล้ว</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>

    <?php
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo '<p class="text-center">No events found.</p>';
        }
    }
    ?>
</main>

<style>
    .image-controls button {
        width: 48%;

    }

    .image-controls {
        display: flex;
        justify-content: space-between;

    }


    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    h1 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
        margin-top: 20px;
        margin-bottom: 20px;
    }


    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }


    input[type="text"],
    input[type="date"],

    button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        font-size: 1rem;
        border-radius: 5px;
        border: 1px solid #ddd;
        box-sizing: border-box;
    }

    .btn-primary,
    .btn-danger {
        font-weight: bold;
        text-align: center;
        border-radius: 5px;
        border: none;
        transition: box-shadow 0.3s ease;
        width: 100%;
        padding: 10px;
        font-size: 1rem;
    }


    .btn {
        font-weight: bold;
        text-align: center;
        border: none;
        transition: box-shadow 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }

    .btn-primary:hover {
        background-color: #0056b3;
        box-shadow: 0 8px 16px rgba(0, 123, 255, 0.3);
    }

    /* ปุ่ม หมดเวลาสมัคร (disabled) ให้เหมือนปุ่มปกติแต่เป็นสีเทา */
    .btn-danger {
        background-color: #6c757d !important;
        color: white !important;
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.2);
        cursor: not-allowed;
    }


    .btn-secondary {
        background-color: #007bff;

        color: white;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);

    }


    .btn-secondary:hover {
        background-color: #0069d9;

        box-shadow: 0 8px 16px rgba(0, 123, 255, 0.3);

    }

    button {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }


    .card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-body {
        padding: 20px;
    }


    .card-text {
        color: #555;
    }


    .card-body .btn {
        background-color: #28a745;
        /* ปุ่มสีเขียว */
        color: white;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    .card-body .btn:hover {
        background-color: #218838;
        /* สีเข้มขึ้นเมื่อโฮเวอร์ */
    }

    .card-body .btn[disabled] {
        background-color: #28a745;
        /* ทำให้ปุ่มที่กดไม่ได้มีสีเขียวเหมือนปุ่มปกติ */
        opacity: 0.6;
        /* ลดความเข้มให้ดูแตกต่าง */
        cursor: not-allowed;
    }


    .card-body .btn:hover {
        background-color: #218838;
    }

    .card-body .btn[disabled] {
        background-color: #ccc;
        cursor: not-allowed;
    }
</style>

<script>
    function prevImage(eventId) {
        const imgElement = document.getElementById('eventImage' + eventId);
        const imageData = JSON.parse(imgElement.getAttribute('data-images'));
        const images = imageData.images;
        let currentIndex = images.indexOf(imgElement.src);

        if (currentIndex > 0) {
            imgElement.src = images[currentIndex - 1];
        } else {
            imgElement.src = images[images.length - 1];
        }
    }

    function nextImage(eventId) {
        const imgElement = document.getElementById('eventImage' + eventId);
        const imageData = JSON.parse(imgElement.getAttribute('data-images'));
        const images = imageData.images;
        let currentIndex = images.indexOf(imgElement.src);

        if (currentIndex < images.length - 1) {
            imgElement.src = images[currentIndex + 1];
        } else {
            imgElement.src = images[0];
        }
    }
</script>