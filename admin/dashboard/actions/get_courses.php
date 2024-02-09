<?php
include '../../../actions/connect.php';
$sql = "SELECT * FROM course";
$result = $conn->query($sql);

$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
    // Output courses as JSON
    echo json_encode(['data' => $courses]);
} else {
    // No courses found
    echo json_encode(['data' => []]);
}
 ?>
