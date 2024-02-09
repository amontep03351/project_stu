<?php
include '../../../actions/connect.php';

$subject_id = $_POST['editSubjectId'];
$subject_name = $_POST['editSubjectName'];
$subject_code = $_POST['editSubjectCode'];
$subject_credit = $_POST['editSubjectCredit'];
$subject_description = $_POST['editSubjectDescription'];

$sql = "UPDATE subjects SET subject_name='$subject_name', subject_code='$subject_code', subject_credit=$subject_credit, subject_description='$subject_description' WHERE subject_id=$subject_id";
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}
?>
