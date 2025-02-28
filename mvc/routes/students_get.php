<?php
declare(strict_types=1);

if (!isset($_GET['keyword'])) {
    renderView('students_get');
} elseif ($_GET['keyword'] == '') {
    $result = getStudents();
    renderView('students_get', array('result' => $result));
} else {
    $result = getStudentsByKeyword($_GET['keyword']);
    renderView('students_get', array('result' => $result));
}