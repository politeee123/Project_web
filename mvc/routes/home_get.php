<?php
$result = getAttendance('approved');
renderView('home_get', array('result' => $result));
