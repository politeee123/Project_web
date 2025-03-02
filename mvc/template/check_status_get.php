<main>
    <h1 class="text-center">สถานะการลงทะเบียน</h1>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>ชื่อผู้ใช้</th>
                <th>สถานะ</th>
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
                if ($row['status'] === 'pending') {
                    echo "<span class='badge bg-warning'>รอดำเนินการ</span>";
                } elseif ($row['status'] === 'approved') {
                    echo "<span class='badge bg-success'>✅ ต้องการเข้าร่วม</span>";
                } elseif ($row['status'] === 'rejected') {
                    echo "<span class='badge bg-danger'>❌ ไม่อนุมัติ</span>";
                }
                echo "</td>";
                echo "<td>";
                ?>
                <form action="check_status" method="post">
                    <label for="status">Select Status:</label>
                    <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                    <select name="status" id="status" class="form-select">
                        <option value="approved" <?php echo ($row['status'] == 'approved') ? 'selected' : ''; ?>>✅ Accept</option>
                        <option value="rejected" <?php echo ($row['status'] == 'rejected') ? 'selected' : ''; ?>>❌ Reject</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
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