<?php
include '../../../actions/connect.php';
$student_id = $_POST["student_id"];
$term = $_POST["term"];
$course_id = $_POST["course_id"];
$point = array();
$gg= array();
$sql = "SELECT * FROM academicresults WHERE student_id ='$student_id' AND course_id = '$course_id' AND term='$term'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $point[$row["subject_id"]] = $row['score'];
        $gg[$row["subject_id"]] = $row['grade'];
    }
}

$sql = "SELECT B.* FROM course_detail A
LEFT JOIN subjects B ON A.subject_id  = B.subject_id
WHERE A.course_id='$course_id'";
$result = $conn->query($sql);

$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    } ?>
    <table class="table table-bordered">
      <thead>
        <tr class="text-center">
          <th scope="col">รหัสวิชา</th>
          <th scope="col">ชื่อวิชา</th>
          <th scope="col">หน่วยกิต</th>
          <th scope="col">คะแนน</th>
          <th scope="col">เกรด</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($courses as $key => $value): ?>
        <tr>
          <td><?php echo $value['subject_code']; ?></td>
          <td><?php echo $value['subject_name']; ?></td>
          <td class="text-center"><?php echo $value['subject_credit']; ?></td>
          <td>
            <?php
            $sc= 0;
            if (isset($point[$value["subject_id"]])) {
              $sc =$point[$value["subject_id"]];
            }else {
              $sc = 0;
            }
            if (isset($gg[$value["subject_id"]])) {
              $Tgg =$gg[$value["subject_id"]];
            }else {
              $Tgg = 'ยังไม่ใส่คะแนน';
            }
              echo '<div class="form-check">';
              echo '<input class="form-control" min="0" max="100" type="number" id="subject_' . $value["subject_id"] . '" name="subjects[]" value="'.$sc.'" request>';
              echo '</div>';
             ?>
             <td class="text-center"><?php echo $Tgg; ?></td>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php
    echo "<button type='submit' onclick='function_saveg(".$student_id.",".$course_id.",".$term.");' class='btn btn-primary'>บันทึก</button>";
} else {
    // No courses found
    echo '';
}
 ?>
