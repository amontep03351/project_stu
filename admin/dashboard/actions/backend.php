<?php
// Database connection
include '../../../actions/connect.php';

// Fetch students data
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'fetch_students') {
    $query = "SELECT * FROM student";
    $result = $conn->query($query);

    $students = array();
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($students);
}

// Add student
if ($_POST['action'] == 'add_student' || $_POST['action'] == 'edit_student') {
  if ($_POST['action'] == 'add_student' || $_POST['action'] == 'edit_student') {
       $first_name = $_POST['first_name'];
       $last_name = $_POST['last_name'];
       $date_of_birth = $_POST['date_of_birth'];
       $gender = $_POST['gender'];
       $email = $_POST['email'];
       $phone_number = $_POST['phone_number'];
       $address = $_POST['address'];
       $student_id = $_POST['studentId']; // Only for edit action

       // Check for duplicate email (for add_student action only)
       if ($_POST['action'] == 'add_student') {
           $duplicate_check_query = "SELECT * FROM Student WHERE email = '$email'";
           $duplicate_check_result = $conn->query($duplicate_check_query);

           if ($duplicate_check_result->num_rows > 0) {
               echo "duplicate";
               exit(); // Exit if duplicate email found
           }
       }

       if ($_POST['action'] == 'add_student') {
             $stmt = $conn->prepare("INSERT INTO Student (first_name, last_name, date_of_birth, gender, email, phone_number, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
             $stmt->bind_param("sssssss", $first_name, $last_name, $date_of_birth, $gender, $email, $phone_number, $address);

       } elseif ($_POST['action'] == 'edit_student') {
           $stmt = $conn->prepare("UPDATE Student SET first_name=?, last_name=?, date_of_birth=?, gender=?, email=?, phone_number=?, address=? WHERE student_id=?");
           $stmt->bind_param("sssssssi", $first_name, $last_name, $date_of_birth, $gender, $email, $phone_number, $address, $student_id);
       }

       if ($stmt->execute()) {
           echo "success";
       } else {
           echo "Error: " . $stmt->error;
       }

       $stmt->close();
   }

} elseif ($_POST['action'] == 'delete_student') {
    if (isset($_POST['studentId'])) {
        $student_id = $_POST['studentId'];
        // Prepare and execute SQL query to delete student by studentId
        $stmt = $conn->prepare("DELETE FROM Student WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
        $stmt->close();
    } else {
        echo "error";
    }
}
?>
