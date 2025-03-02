<?php
    $username = $_POST['username'];
    $event_id = $_POST['event_id'];
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];
    
    if (empty($status) || empty($user_id)|| empty($event_id) ) {
        badRequest("All fields are required");
    }

    if ($status == 'approved') {
        # code...
    }else{
        $update = UpdateStatus($user_id, $event_id, $status);
        $res = deleteRegistration($user_id,$event_id);
        $result = getUser_status($event_id,'pending');
        if ($res) {    
            renderView('check_status_get',array('result' => $result));
        } else {
            badRequest(message: 'Error');
        }

    }