<?php
// ตรวจสอบการส่งข้อมูลจากฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบการ login (ตัวอย่าง)
    if ($username == "admin" && $password == "password123") {
        echo "Assume that login success!";
    } else {
        echo "Invalid username or password.";
    }
}
?>

<section>
    <h1>Sign In</h1>
    <form action="sign_in.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Log In">
    </form>
</section>
