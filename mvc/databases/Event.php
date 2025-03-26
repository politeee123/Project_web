<?php

// function getEvent(): mysqli_result|bool {
//     $conn = getConnection();
//     $sql = 'SELECT * FROM event';
//     return $conn->query($sql);
// }
function getEvent() {
    $conn = getConnection();
    $sql = 'SELECT * FROM event';
    return $conn->query($sql);
}

// function getEventByKeyword(string $keyword): mysqli_result|bool {
//     $conn = getConnection();
//     $sql = 'SELECT * FROM event WHERE event_name LIKE ?';
//     $stmt = $conn->prepare($sql);
//     $keyword = '%' . $keyword . '%';
//     $stmt->bind_param('s', $keyword);
//     $stmt->execute();
//     return $stmt->get_result();
// }
function getEventByKeyword(string $keyword) {
    $conn = getConnection();
    $sql = 'SELECT * FROM event WHERE event_name LIKE ?';

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false; // ป้องกันข้อผิดพลาดหาก prepare() ล้มเหลว
    }

    // ปรับแต่งคีย์เวิร์ดเพื่อใช้กับ LIKE
    $keyword = '%' . $keyword . '%';

    // ผูกค่าพารามิเตอร์
    $stmt->bind_param('s', $keyword);

    // ประมวลผลคำสั่ง SQL
    $stmt->execute();

    // คืนค่าผลลัพธ์
    return $stmt->get_result();
}
// function getEventById(int $event_id):mysqli_result|bool{
//     $conn = getConnection();
//     $sql = 'SELECT * FROM event WHERE event_id = ?';
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param('i', $event_id);
//     $stmt->execute();
//     return $stmt->get_result();
// }
function getEventById(int $event_id) {
    $conn = getConnection();
    $sql = 'SELECT * FROM event WHERE event_id = ?';

    // ตรวจสอบว่า prepare สำเร็จหรือไม่
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false; // คืนค่า false หาก prepare() ล้มเหลว
    }

    // ผูกค่าพารามิเตอร์
    $stmt->bind_param('i', $event_id);

    // ประมวลผลคำสั่ง SQL
    $stmt->execute();

    // คืนค่าผลลัพธ์
    return $stmt->get_result();
}

// function getEventsByUser(int $user_id): mysqli_result|bool {
//     $conn = getConnection();
//     $sql = 'SELECT * FROM event WHERE creator_id = ?';
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param('i', $user_id);
//     $stmt->execute();
//     return $stmt->get_result();
// }

function getEventsByUser(int $user_id) {
    $conn = getConnection();
    $sql = 'SELECT * FROM event WHERE creator_id = ?';

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false; 
    }

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getEventbyDate(string $start_date, string $end_date){
    $conn = getConnection();
    $sql = 'SELECT * FROM event WHERE date BETWEEN ? AND ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $start_date, $end_date);
    $stmt->execute();
    return $stmt->get_result();
}

// function addEvent(string $event_name, string $description, string $date, string $location, int $max_participants, string $image) {
//     $conn = getConnection();
//     $sql = 'INSERT INTO Event (creator_id, event_name, description, date, location, max_participants, image) VALUES (?, ?, ?, ?, ?, ?, ?)';
//     $stmt = $conn->prepare($sql);
//     if (!$stmt) {
//         die("Prepare failed: " . $conn->error);
//     }
//     $stmt->bind_param(
//         'issssis', 
//         $_SESSION['user_id'],
//         $event_name, 
//         $description, 
//         $date, 
//         $location, 
//         $max_participants, 
//         $image
//     );
//     $result = $stmt->execute();
//     $stmt->close();
//     $conn->close();
//     return $result;
// }
function addEvent(
    string $event_name, 
    string $description, 
    string $date, 
    string $location, 
    int $max_participants, 
    array $image
) {
    $conn = getConnection();
    
    $image_json = json_encode($image, JSON_UNESCAPED_SLASHES); 

    $sql = 'INSERT INTO event (creator_id, event_name, description, date, location, max_participants, image) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        'issssis', 
        $_SESSION['user_id'], 
        $event_name, 
        $description, 
        $date, 
        $location, 
        $max_participants, 
        $image_json // ส่ง JSON ของภาพไปฐานข้อมูล
    );
    
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return $result;
}

function updateEvent(int $event_id, string $event_name, string $description, string $date, string $location, int $max_participants, array $image) {
    $conn = getConnection(); 
    $image_json = json_encode($image, JSON_UNESCAPED_SLASHES); 
    $stmt = $conn->prepare("UPDATE event SET event_name=?, description=?, date=?, location=?, max_participants=?, image=? WHERE event_id=?");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssisi", $event_name, $description, $date, $location, $max_participants, $image_json, $event_id);
    $result = $stmt->execute();
    
    $stmt->close();
    $conn->close();
    return $result;
}

function getUniqueParticipantsCount($event_id) {
    $conn = getConnection();

    // SQL query เพื่อดึงจำนวน user_id ที่เข้าร่วมกิจกรรม event_id โดยไม่ซ้ำ
    $sql = "SELECT COUNT(DISTINCT user_id) AS total FROM attendance WHERE event_id = ? AND check_in_status = 'checked-in'";
    $total = 0; // Initialize the variable $total

    // เตรียมคำสั่ง SQL
    if ($stmt = $conn->prepare($sql)) {
        // ผูกค่าตัวแปร $event_id
        $stmt->bind_param("i", $event_id); // i หมายถึง integer
        
        // รันคำสั่ง SQL
        $stmt->execute();
        
        // รับผลลัพธ์และผูกค่าผลลัพธ์ไปที่ตัวแปร $total
        $stmt->bind_result($total);  // เก็บผลลัพธ์ในตัวแปร $total
        
        // ดึงผลลัพธ์จากการ query
        if ($stmt->fetch()) {
            // ค่าของ $total จะได้รับจากผลลัพธ์ของคำสั่ง SQL
        } else {
            // หากไม่มีผลลัพธ์จากคำสั่ง SQL
            $total = 0;
        }

        // ปิดการเตรียมคำสั่ง
        $stmt->close();

        // ส่งค่าผลลัพธ์กลับ
        return $total;
    } else {
        // กรณีไม่สามารถเตรียมคำสั่ง SQL ได้
        return "Error in query preparation";
    }
}