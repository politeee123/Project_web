<?php

function getStudents(): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'select * from students';
    $result = $conn->query($sql);
    return $result;
}
function getStudentsByKeyword(string $keyword): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'select * from students where first_name like ? or last_name like ?';
    $stmt = $conn->prepare($sql);
    $keyword = '%'. $keyword .'%';
    $stmt->bind_param('ss',$keyword, $keyword);
    $res = $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function deleteStudentsById(int $id): bool
{
    $conn = getConnection();
    $sql = 'delete from students where student_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}
function getStudentById(int $id): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'select * from students where student_id = ?';
    $stmt = $conn->prepare($sql);    
    $stmt->bind_param('i', $id);
    $stmt->execute();    
    $result = $stmt->get_result();
    return $result;
}
function changePassword(int $id, string $password): bool
{
    $conn = getConnection();
    $sql = 'update students set password = ? where student_id = ?';
    $stmt = $conn->prepare($sql);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param('si', $hash, $id);
    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
    return $result;
}