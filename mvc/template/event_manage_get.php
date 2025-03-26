<?php

if (isset($data['result']) && $data['result']->num_rows > 0): ?>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <?php while ($row = $data['result']->fetch_assoc()):
                $event_id = $row['event_id'];
                $unique_id_count = getUniqueParticipantsCount($event_id);
                $max_participants = $row['max_participants'];
                $available_slots = $max_participants - $unique_id_count;

                $images = json_decode($row['images'], true);
                $image_urls = !empty($images)
                    ? array_map(fn($img) => 'http://www.demoweb.lnw.mn/public/' . htmlspecialchars($img), $images)
                    : ['http://www.demoweb.lnw.mn/public/default_image.jpg'];
                $image_json = htmlspecialchars(json_encode($image_urls));
            ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <img src="<?= $image_urls[0] ?>" id="eventImage<?= $event_id ?>"
                            class="card-img-top" alt="Event Image"
                            style="height: 200px; object-fit: cover;"
                            data-images='<?= $image_json ?>'>

                    
                        <div class="image-controls text-center mt-2">
                            <button onclick="prevImage(<?= $event_id ?>)" class="btn btn-secondary">⬅️ ก่อนหน้า</button>
                            <button onclick="nextImage(<?= $event_id ?>)" class="btn btn-secondary">ถัดไป ➡️</button>
                        </div>

                        <div class="card-body">
                            <h2 class="card-title"><?= htmlspecialchars($row['event_name']) ?></h2>
                            <p class="card-text"><strong>วันที่:</strong> <?= htmlspecialchars($row['date']) ?></p>
                            <p class="card-text"><strong>ที่ตั้ง:</strong> <?= htmlspecialchars($row['location']) ?></p>
                            <p class="card-text"><strong>จำนวนผู้เข้าร่วมสูงสุด:</strong> <?= $max_participants ?></p>

                            <?php if ($available_slots > 0): ?>
                                <p class="card-text"><strong>ตำแหน่งที่เหลือ:</strong> <?= $unique_id_count ?>/<?= $available_slots ?></p>
                                <p class="card-text"><strong>เปอร์เซ็นต์:</strong> <?= floor(($unique_id_count / $available_slots) * 100) ?>%</p>
                            <?php else: ?>
                                <p class="card-text"><strong>ตำแหน่งที่เหลือ:</strong> Full</p>
                            <?php endif; ?>

                            <p class="card-text"><strong>คำอธิบาย:</strong> <?= $row['description'] ?></p>
                        </div>

                        <div class="card-footer text-center">
                            <a href="edit_event?event_id=<?= $event_id ?>" class="btn btn-warning text-dark fw-bold px-4 py-2 shadow-sm">✏️ แก้ไขกิจกรรม</a>
                            <a href="check_status?event_id=<?= $event_id ?>" class="btn btn-success text-white fw-bold px-4 py-2 shadow-sm">✅ ตรวจสอบสถานะ</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php else: ?>
    <p class="text-center">No events found.</p>
<?php endif; ?>


<style>
    
    .btn {
        font-weight: bold;
        text-align: center;
        border: none;
        transition: box-shadow 0.3s ease;

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

 
    .btn-warning {
        background-color: #f0ad4e;
     
        color: white;
        box-shadow: 0 4px 8px rgba(240, 173, 78, 0.2);

    }

  
    .btn-warning:hover {
        background-color: #ec971f;
      
        box-shadow: 0 8px 16px rgba(240, 173, 78, 0.3);
    
    }


    .btn-success {
        background-color: #5cb85c;
    
        color: white;
        box-shadow: 0 4px 8px rgba(76, 156, 76, 0.33);
    
    }

    
    .btn-success:hover {
        background-color: #4cae4c;
 
        box-shadow: 0 8px 16px rgba(92, 184, 92, 0.3);
  
    }


    .card {
        border-radius: 15px;
 
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    
        margin: 10px;
    }

    .card-body {
        padding: 15px;
    }

    .card-img-top {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        transition: none;
    }

    .card-footer .btn {
        transition: box-shadow 0.3s ease;
   
    }

    .card-footer .btn:hover {
        box-shadow: 0 8px 16px rgba(0, 123, 255, 0.3);
     
    }
</style>


<script>
    function prevImage(eventId) {
        const imgElement = document.getElementById('eventImage' + eventId);
        const images = JSON.parse(imgElement.getAttribute('data-images'));
        let currentIndex = images.indexOf(imgElement.src);

        if (currentIndex > 0) {
            imgElement.src = images[currentIndex - 1];
        } else {
            imgElement.src = images[images.length - 1]; 
        }
    }

    function nextImage(eventId) {
        const imgElement = document.getElementById('eventImage' + eventId);
        const images = JSON.parse(imgElement.getAttribute('data-images'));
        let currentIndex = images.indexOf(imgElement.src);

        if (currentIndex < images.length - 1) {
            imgElement.src = images[currentIndex + 1];
        } else {
            imgElement.src = images[0]; 
        }
    }
</script>