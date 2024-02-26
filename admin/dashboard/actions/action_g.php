<?php
include '../../../actions/connect.php';
$student_id = $_POST["student_id"];
$course_id = $_POST["course_id"];
$term = $_POST["term"];
$subjects = $_POST["subjects"];
$subjects_id = $_POST["subjects_id"];

function calculateGrade($score) {
    if ($score >= 80 && $score <= 100) {
        return "4";
    } elseif ($score >= 75 && $score <= 79) {
        return "3.5";
    } elseif ($score >= 70 && $score <= 74) {
        return "3";
    } elseif ($score >= 65 && $score <= 69) {
        return "2.5";
    } elseif ($score >= 60 && $score <= 64) {
        return "2";
    } elseif ($score >= 55 && $score <= 59) {
        return "1.5";
    } elseif ($score >= 50 && $score <= 54) {
        return "1";
    } elseif ($score >= 0 && $score <= 49) {
        return "0";
    } else {
        return "";
    }
}
// Prepare the SQL statement
$sql = "INSERT INTO academicresults (student_id, subject_id ,course_id, subject, score, grade, year, term) VALUES (?,?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters
for ($i=0; $i < count($subjects_id); $i++) {
  $id = explode("_",$subjects_id[$i]);
  $subject_id = $id[1];
  $score = $subjects[$i];
  $year = date("y");
  $sql = "SELECT subject_id ,subject_name FROM subjects WHERE subject_id ='$subject_id'";

  $result = $conn->query($sql);

  $course_detail = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $subject = $row['subject_name'];
      }
  }else {
    $subject = '';
  }
  $grade = calculateGrade($score);
  $stmt->bind_param("iiisdsis", $student_id, $subject_id , $course_id, $subject, $score, $grade, $year, $term);

  // Execute the statement
  if ($stmt->execute()) {
      echo "Data inserted successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
// Close statement and database connection
$stmt->close();
$conn->close();
?>
