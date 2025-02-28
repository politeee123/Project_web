<section>
    <h1>Students</h1>

    <form action="students" method="get">
        <input type="text" name="keyword" />
        <button type="submit">Search</button>
    </form>
    <?php
    if (isset($data['result'])) {
        while ($row = $data['result']->fetch_object()) {
    ?>
            <?= $row->student_id ?>
            <?= $row->first_name ?>
            <?= $row->last_name ?>
            <?= $row->phone_number ?>
            <?= $row->email ?>
            <a href="/students_delete?id=<?= $row->student_id ?>" onclick="return confirmSubmission()">ลบข้อมูล</a>
            <a href="/students_chgpwd?id=<?= $row->student_id ?>">เปลี่ยนรหัสผ่าน</a>
            <br>
    <?php
        }
    }
    ?>
</section>
<script>
    function confirmSubmission() {
        return confirm("Are you sure you want to delete?");
    }
</script>