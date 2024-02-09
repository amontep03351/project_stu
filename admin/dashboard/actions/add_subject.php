<?php
include '../../../actions/connect.php';
$subject_name = $_POST['subjectName'];
$subject_code = $_POST['subjectCode'];
$subject_credit = $_POST['subjectCredit'];
$subject_description = $_POST['subjectDescription'];

$sql = "INSERT INTO subjects (subject_name, subject_code, subject_credit, subject_description) VALUES ('$subject_name', '$subject_code', '$subject_credit', '$subject_description')";
 
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}
?>
