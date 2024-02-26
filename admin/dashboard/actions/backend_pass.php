<?php
// Database connection
include '../../../actions/connect.php';
$student_id= $_POST["studentId"];
$student_password= $_POST["student_password"];
$stmt = $conn->prepare("UPDATE Student SET student_password=? WHERE student_id=?");
$stmt->bind_param("si", $student_password,$student_id);
if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}
?>
