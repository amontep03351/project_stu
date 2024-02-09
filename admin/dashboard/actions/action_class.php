<?php
// Database connection
include '../../../actions/connect.php';
if (isset($_POST['createCourse'])) {
  if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $sql = "SELECT * FROM course WHERE course_id  ='$id'";
  }else {
    $sql = "SELECT * FROM course";
  }

  $result = $conn->query($sql);

  $course_detail = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row["course_id"].'">';
        echo $row["course_name"];
        echo " ปี ";
        echo $row["course_year"];
        echo '</option>';
      }
  }
}elseif (isset($_POST['course_id'])) {
  $course_id = $_POST["course_id"];
  $Term = $_POST["Term"];
  if ($_POST["Class_id"] !='') {
     $action = 'update';
  }else {
     $action = 'add';
  }

  if ($action=='update') {
      $stmt = $conn->prepare("DELETE FROM stuclass WHERE course_id = ? AND term =?");
      $stmt->bind_param("ii", $course_id, $Term);
      if ($stmt->execute()) {   }
  }

  $sql = "INSERT INTO stuclass (course_id, student_id, term) VALUES (?, ?, ?)";
  foreach ($_POST["student"] as $student_id) {
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("iis", $course_id, $student_id, $Term); // Check the parameter types
      $stmt->execute();
  }
  $stmt->close();
  echo "success";
}else {
  if (isset($_POST["id"])) {
    $class_id = $_POST["id"];
    $term = $_POST["term"];
    $student_id = array();
    $sql = "SELECT student_id FROM stuclass WHERE  course_id ='$class_id' AND term ='$term'";
    $result = $conn->query($sql);

    $course_detail = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $student_id[$row['student_id']] = $row["student_id"];
        }
    }
    $sql = "SELECT student_id,first_name ,last_name FROM student ";
    $result = $conn->query($sql);

    $course_detail = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          if (isset($student_id[$row["student_id"]])) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" checked type="checkbox" id="student_' . $row["student_id"] . '" name="student[]" value="' . $row["student_id"] . '">';
            echo '<label class="form-check-label" for="student_' . $row["student_id"] . '"> ' . $row["first_name"] . ' ' . $row["last_name"] . '</label>';
            echo '</div>';
          }else {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" id="student_' . $row["student_id"] . '" name="student[]" value="' . $row["student_id"] . '">';
            echo '<label class="form-check-label" for="student_' . $row["student_id"] . '"> ' . $row["first_name"] . ' ' . $row["last_name"] . '</label>';
            echo '</div>';
          }
        }
    }
  }else {
    $sql = "SELECT student_id,first_name ,last_name FROM student ";
    $result = $conn->query($sql);

    $course_detail = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="form-check">';
          echo '<input class="form-check-input" type="checkbox" id="student_' . $row["student_id"] . '" name="student[]" value="' . $row["student_id"] . '">';
          echo '<label class="form-check-label" for="student_' . $row["student_id"] . '"> ' . $row["first_name"] . ' ' . $row["last_name"] . '</label>';
          echo '</div>';
        }
    }
  }
}



?>
