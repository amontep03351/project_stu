<?php
include '../../../actions/connect.php';

// Check if studentId is provided
if (isset($_POST['studentId'])) {
    $student_id = $_POST['studentId'];

    // Prepare and execute SQL query to fetch student data by studentId
    $stmt = $conn->prepare("SELECT * FROM Student WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch student data as an associative array
        $student_data = $result->fetch_assoc();

        // Output student data as JSON
        echo json_encode($student_data);
    } else {
        echo "No student found with the provided ID.";
    }

    $stmt->close();
} else {
    echo "No student ID provided.";
}

// Close connection
$conn->close();
?>
