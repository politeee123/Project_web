<?php
    $user_name = $_POST['username']?? '';
    $password = $_POST['password']?? '';
    $email = $_POST['email']?? '';
    $role = $_POST['role']?? '';

    if (empty($user_name) || empty($password) || empty($email) || empty($role)) {
        badRequest("All fields are required");
    }
    $res = addUser(
        $user_name,
        $password,
        $email,
        $role
    );

    if ($res) {    
        $_SESSION['message'] = 'Course added successfully!';
        login('login_get');
    } else {
        badRequest(message: 'มีคนใช้ชื่อนี้แล้ว');
    }