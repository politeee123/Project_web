<main class="container my-5">
    <h1 class="text-center mb-4 fw-bold">📅 กิจกรรม</h1>

    <div class="d-flex justify-content-center">
        <form action="home" method="post" class="p-4 bg-white rounded shadow-lg w-50">
            <label class="form-label fw-bold">เลือกสถานะ:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="approved" value="approved" checked>
                <label class="form-check-label" for="approved">✅ ที่ได้รับการอนุมัติ</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="pending" value="pending">
                <label class="form-check-label" for="pending">⏳ รอดำเนินการ</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="rejected" value="rejected">
                <label class="form-check-label" for="rejected">❌ ถูกปฏิเสธ</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3 w-100">
                ✔️ ยืนยัน
            </button>
        </form>
    </div>


    <?php
    if (isset($data['result'])) {
        if ($data['result']->num_rows > 0) {
            echo '<div class="row mt-4">';
            while ($row = $data['result']->fetch_assoc()) {
                $event_id = $row['event_id'];
                $unique_id_count = getUniqueParticipantsCount($event_id);
                $max_participants = $row['max_participants'];
                $available_slots = $max_participants - $unique_id_count;

                $images = json_decode($row['images'], true);
                if (!empty($images)) {
                    $first_image = $images[0];
                    $image_url = 'http://www.demoweb.lnw.mn/public/' . htmlspecialchars($first_image);
                } else {
                    $image_url = 'http://www.demoweb.lnw.mn/public/default_image.jpg';
                }
                echo '<div class="col-md-4 col-sm-6 mb-4">';
                echo '  <div class="card shadow-lg border-0 rounded-4">';
                echo '<img src="' . $image_url . '" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">';
                echo '<div class="card-body">';
                echo '<h2 class="card-title fw-bold">' . htmlspecialchars($row['event_name']) . '</h2>';
                echo '<p class="card-text"><i class="bi bi-calendar3"></i> <strong>วันที่:</strong> ' . htmlspecialchars($row['date']) . '</p>';
                echo '<p class="card-text"><i class="bi bi-geo-alt"></i> <strong>ที่ตั้ง:</strong> ' . htmlspecialchars($row['location']) . '</p>';
                echo '<p class="card-text"><i class="bi bi-people"></i> <strong>จำนวนผู้เข้าร่วมสูงสุด:</strong> ' . htmlspecialchars($row['max_participants']) . '</p>';
                if ($available_slots > 0) {
                    echo '<p class="card-text"><strong>ตำแหน่งที่เหลือ:</strong> ' . $unique_id_count . '/' . $available_slots . '</p>';
                    echo '<p class="card-text"><strong>เพอร์เซท:</strong> ' . floor(($unique_id_count / $available_slots) * 100) . '%</p>';
                    echo '<p class="card-text"><strong>คำอธิบาย:</strong> ' . $row['description'] . '</p>';
                } else {
                    echo '<p class="card-text"><strong>ตำแหน่งที่เหลือ:</strong> Full</p>';
                    echo '<p class="card-text"><strong>คำอธิบาย:</strong> ' . $row['description'] . '</p>';
                }
                if ($row['status'] == 'approved') {
                    if ($row['check_in_status'] == 'checked-in') {
                        echo '<div class="alert alert-success w-100 text-center" role="alert">
                                ✅ You have already checked in.
                              </div>';
                    } elseif ($row['check_in_status'] == 'not checked-in') {
                        echo '<div class="alert alert-warning w-100 text-center" role="alert">
                                ⏳ You have not checked in yet.
                              </div>';
                        echo '<a href="check?event_id=' . (int)$row['event_id'] . '" class="btn btn-primary w-100">🔍 Check</a>';
                    } else {
                        echo '<a href="check?event_id=' . (int)$row['event_id'] . '" class="btn btn-primary w-100">🔍 Check</a>';
                    }
                } elseif ($row['status'] == 'pending') {
                    echo '<div class="alert alert-warning w-100 text-center" role="alert">
                            ⏳ Your registration is pending. Please wait for approval.
                          </div>';
                } else {
                    echo '<div class="alert alert-danger w-100 text-center" role="alert">
                            ❌ Your registration has been rejected.
                          </div>';
                }
                //echo '          <a href="check?event_id=' . (int)$row['event_id'] . '" class="btn btn-primary w-100">🔍 Check</a>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p class="text-center text-muted mt-4">⚠️ No events found.</p>';
        }
    }
    ?>
</main>

<style>
    button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        font-size: 1rem;
        border-radius: 5px;
        border: 1px solid #ddd;
        box-sizing: border-box;
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
</style>