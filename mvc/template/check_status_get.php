<main>
    <h1 class="text-center">สถานะการลงทะเบียน</h1>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>ชื่อผู้ใช้</th>
                <th>สถานะ</th>
                <th>เลือก</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($data['result']) && $data['result']->num_rows > 0) {
            $index = 1;
            while ($row = $data['result']->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$index}</td>";
                echo "<td>{$row['username']}</td>";
                echo "<td>";
                if ($row['status'] == 'pending') {
                    echo "<span class='badge bg-warning'>รอดำเนินการ</span>";
                } elseif ($row['status'] == 'approved') {
                    echo "<span class='badge bg-success'>✅ ต้องการเข้าร่วม</span>";
                } elseif ($row['status'] == 'rejected') {
                    echo "<span class='badge bg-danger'>❌ ไม่อนุมัติ</span>";
                }
                echo "</td>";
                echo "<td>";
                ?>
                <form action="check_status" method="post">
                    <label for="status">เลือกสถานะ:</label>
                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($row['event_id']); ?>">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($row['username']); ?>">

                    <select name="status" id="status" class="form-select">
                        <option value="approved" <?php echo ($row['status'] == 'approved') ? 'selected' : ''; ?>>✅ ยอมรับ</option>
                        <option value="rejected" <?php echo ($row['status'] == 'rejected') ? 'selected' : ''; ?>>❌ ปฏิเสธ</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">ยืนยัน</button>
                </form>
                <?php
                echo "</td>";
                echo "</tr>";
                $index++;
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>ไม่มีข้อมูลผู้ลงทะเบียน</td></tr>";
        }
        ?>

        </tbody>
    </table>
</main>

<style>
   
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: center;
        vertical-align: middle;
    }

    .table thead th {
        background-color: #2c3e50; 
        color: white;
        font-weight: bold;
        border-bottom: 2px solid #34495e;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa; 
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2; 
    }

    .table tbody tr:nth-child(odd) {
        background-color: white; 
    }

   
    .badge {
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #000;
    }

    .badge.bg-success {
        background-color: #28a745 !important;
        color: #fff;
    }

    .badge.bg-danger {
        background-color: #dc3545 !important;
        color: #fff;
    }

 
    .form-select {
        padding: 8px 12px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    
    .text-center {
        font-size: 18px;
        color: #6c757d;
        padding: 20px;
    }
</style>