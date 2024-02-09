<?php
// Include database connection code
include '../../../actions/connect.php';
// Add/Edit/Delete course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_course') {
        addCourse();
    } elseif ($_POST['action'] == 'edit_course') {
        editCourse();
    } elseif ($_POST['action'] == 'delete_course') {
        deleteCourse();
    }
}

// Function to add a new course
function addCourse() {
    global $conn;

    if (isset($_POST['courseName']) && isset($_POST['courseYear'])) {
        $courseName = $_POST['courseName'];
        $courseYear = $_POST['courseYear'];

        // Insert new course into the database
        $sql = "INSERT INTO course (course_name, course_year) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $courseName, $courseYear);

        if ($stmt->execute()) {
            // Course added successfully
            echo "success";
        } else {
            // Failed to add course
            echo "error";
        }
        $stmt->close();
    } else {
        echo "Invalid request";
    }
}

// Function to edit an existing course
function editCourse() {
    global $conn;

    if (isset($_POST['courseId']) && isset($_POST['courseName']) && isset($_POST['courseYear'])) {
        $courseId = $_POST['courseId'];
        $courseName = $_POST['courseName'];
        $courseYear = $_POST['courseYear'];

        // Update course in the database
        $sql = "UPDATE course SET course_name = ?, course_year = ? WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $courseName, $courseYear, $courseId);

        if ($stmt->execute()) {
            // Course updated successfully
            echo "success";
        } else {
            // Failed to update course
            echo "error";
        }
        $stmt->close();
    } else {
        echo "Invalid request";
    }
}

// Function to delete a course
function deleteCourse() {
    global $conn;

    if (isset($_POST['courseId'])) {
        $courseId = $_POST['courseId'];

        // Delete course from the database
        $sql = "DELETE FROM course WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $courseId);

        if ($stmt->execute()) {
            // Course deleted successfully
            echo "success";
        } else {
            // Failed to delete course
            echo "error";
        }
        $stmt->close();
    } else {
        echo "Invalid request";
    }
}

// Close database connection
$conn->close();
?>
