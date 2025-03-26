<?php
    $user_name = $_POST['username']?? '';
    $password = $_POST['password']?? '';
    $confirm_password = $_POST['confirm_password']?? '';
    $email = $_POST['email']?? '';
    $role = 'participant';
    
    if ($password == $confirm_password) {
        $res = addUser(
            $user_name,
            $password,
            $email,
            $role
        );
    
        if ($res) {    
            login('login_get');
        } else {
            $_SESSION['error'] = "ใส่ข้อมูลผิดพลาด";
            login('sign_in_get');
        }
    }else {
        $_SESSION['error'] = "รหัสผ่านไม่ตรงกัน";
        login('sign_in_get');
    }