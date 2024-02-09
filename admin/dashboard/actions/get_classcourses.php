<?php
include '../../../actions/connect.php';
if (isset($_POST["id"])) {
  $id = $_POST["id"];
  $term = $_POST["term"];
  $sql = "SELECT
               A.class_id
              ,A.term
              ,B.course_id
              ,B.course_name
              ,B.course_year
              ,C.student_id
              ,C.first_name
              ,C.last_name
          FROM stuclass A
          INNER JOIN course  B ON  A.course_id  = B.course_id
          LEFT JOIN student  C ON  A.student_id  = C.student_id  WHERE A.course_id ='$id' AND A.term='$term' ";
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
}else {
  $sql = "SELECT  A.term,A.course_id,B.course_name,B.course_year,C.count_stuclass FROM stuclass A
          INNER JOIN course  B ON  A.course_id  = B.course_id
          INNER JOIN (SELECT course_id, COUNT(student_id) AS count_stuclass
                  FROM stuclass
                  GROUP BY course_id,term) C
                  ON A.course_id  = B.course_id
          GROUP BY  A.term,A.course_id,B.course_name,B.course_year,C.count_stuclass";
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
}

 ?>
