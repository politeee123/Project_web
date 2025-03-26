<?php
$event = $data['result']->fetch_assoc();
$images = json_decode($event['image'], true) ?? []; 
?>

<main>
    <div class="container mt-4">
        <h1>แก้ไขกิจกรรม</h1>
        <form action="edit_event" method="post" enctype="multipart/form-data">
            <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['event_id']); ?>">
            <?php
            if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="event_name" class="form-label">ชื่อกิจกรรม</label>
                <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="datetime" class="form-label">วันที่และเวลา</label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" value="<?php echo htmlspecialchars($event['date']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">ที่ตั้ง</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="max_participants" class="form-label">จำนวนผู้เข้าร่วมสูงสุด</label>
                <input type="number" class="form-control" id="max_participants" name="max_participants" value="<?php echo htmlspecialchars($event['max_participants']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">คำอธิบาย</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($event['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">รูปภาพ (อัพโหลดได้หลายภาพ)</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>

                <?php if (!empty($images)): ?>
                    <p>Current Images:</p>
                    <div class="row">
                        <?php foreach ($images as $image): ?>
                            <div class="col-3 mb-2">
                                <img src="<?php echo htmlspecialchars($image); ?>" 
                                     alt="Event Image" 
                                     class="img-thumbnail img-fluid" 
                                     style="cursor: pointer; max-height: 150px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success">อัปเดตกิจกรรม</button>
            <a href="event_view?event_id=<?php echo htmlspecialchars($event['event_id']); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</main>

<style>
   
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 28px;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 20px;
        text-align: center;
    }

    
    .form-label {
        font-weight: 500;
        color: #34495e;
        margin-bottom: 8px;
    }

    .form-control {
        padding: 10px 15px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }


    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-1px);
    }

    .img-thumbnail {
        border-radius: 5px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

 
    p {
        font-size: 16px;
        color: #495057;
        margin-top: 10px;
        margin-bottom: 10px;
    }

  
    .row {
        margin-top: 10px;
    }

    .col-3 {
        padding: 5px;
    }
</style>
