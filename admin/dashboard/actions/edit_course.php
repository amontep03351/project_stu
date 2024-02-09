<?php
include '../../../actions/connect.php';

// Check if studentId is provided
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute SQL query to fetch student data by studentId
    $stmt = $conn->prepare("SELECT * FROM course WHERE course_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch student data as an associative array
        $course_data = $result->fetch_assoc();

        // Output student data as JSON
        echo json_encode($course_data);
    } else {
        echo "No course found with the course ID.";
    }

    $stmt->close();
} else {
    echo "No student ID provided.";
}

// Close connection
$conn->close();
?>
