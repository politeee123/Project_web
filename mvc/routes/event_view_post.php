<?php


if (isset($_GET['registration_id'])) {
    $registration_id = $_GET['registration_id'];
    $conn = getConnection();

    $sql = "UPDATE Registration SET status = 'rejected' WHERE registration_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $registration_id);
    $stmt->execute();
    
    header("Location: event_view.php?event_id=" . $_GET['event_id']);
    exit();
}
?>
