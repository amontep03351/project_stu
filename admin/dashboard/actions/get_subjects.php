<?php
// Database connection
include '../../../actions/connect.php';
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $sql = "SELECT * FROM subjects WHERE subject_id='$id'";
  $result = $conn->query($sql);

  $subjects = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $subjects[] = $row;
      }
  }
  echo json_encode($subjects);
}elseif (isset($_POST['createCourse'])) {
  $id = $_POST["createCourse"];
  $sql = "SELECT subject_id FROM course_detail WHERE course_id='$id'";
  $result = $conn->query($sql);

  $course_detail = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $course_detail[$row['subject_id']] = $row['subject_id'];
      }
  }
  $sql = "SELECT * FROM subjects";
  $result = $conn->query($sql);

  $subjects = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        $subjects[] = $row;
      }
  }
  foreach ($subjects as $key => $value) {
    if (isset($course_detail[$value['subject_id']])) {
      echo '<div class="form-check">';
      echo '<input class="form-check-input" checked type="checkbox" id="subject_' . $value["subject_id"] . '" name="subjects[]" value="' . $value["subject_id"] . '">';
      echo '<label class="form-check-label" for="subject_' . $value["subject_id"] . '">[' . $value["subject_code"] . ']' . $value["subject_name"] . '</label>';
      echo '</div>';
    }else {
      echo '<div class="form-check">';
      echo '<input class="form-check-input" type="checkbox" id="subject_' . $value["subject_id"] . '" name="subjects[]" value="' . $value["subject_id"] . '">';
      echo '<label class="form-check-label" for="subject_' . $value["subject_id"] . '">[' . $value["subject_code"] . '] ' . $value["subject_name"] . '</label>';
      echo '</div>';
    }

  }

}else {
  $sql = "SELECT * FROM subjects";
  $result = $conn->query($sql);

  $subjects = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $subjects[] = $row;
      }
  }
  echo json_encode($subjects);
}



?>
