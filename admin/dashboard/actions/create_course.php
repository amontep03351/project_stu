<?php
include '../../../actions/connect.php';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST["course_id"];
    $sql_del = "DELETE FROM course_detail WHERE course_id=$course_id";
    if ($conn->query($sql_del) === TRUE) {

    } else {
        echo "error";
    }
    if ($course_id) {
        // Course inserted successfully, now insert subjects into Course_detail table

        if (!empty($_POST["subjects"])) {
            // Subjects were selected, insert them into Course_detail table
            foreach ($_POST["subjects"] as $subject_id) {
                $sql = "INSERT INTO course_detail (course_id, subject_id) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $course_id, $subject_id);
                $stmt->execute();
            }
        }
        echo "success";
    } else {
        // Failed to insert course, handle error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

// Close database connection
$conn->close();
?>
