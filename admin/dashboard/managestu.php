<div class="container-fluid mt-5">
    <h2>จัดการข้อมูล นักเรียน</h2>
    <button class="btn btn-primary mb-3" id="addStudentBtn">เพิ่มข้อมูล</button>
    <div class="table-responsive">
      <table id="studentTable" class="table table-striped">
          <thead>
              <tr>
                  <th>ไอดี</th>
                  <th>ชื่อ</th>
                  <th>นามสกุล</th>
                  <th>วันเดือนปีเกิด</th>
                  <th>เพศ</th>
                  <th>อีเมล์</th>
                  <th>เบอร์โทร</th>
                  <th>ที่อยู่</th>
                  <th>จัดการ</th>
                  <th>จัดการรหัสเข้าใช้</th>
              </tr>
          </thead>
          <tbody></tbody>
      </table>
    </dvi>

</div>
  <!-- Add Student Modal -->
 <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="addStudentModalLabel">ข้อมูล</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form id="addStudentForm">
             <div class="modal-body">
                 <!-- Form for adding student -->
                     <input type="hidden" id="studentId" name="studentId">
                     <div class="form-group">
                         <label for="first_name">ชื่อ</label>
                         <input type="text" class="form-control" id="first_name" name="first_name" required>
                     </div>
                     <div class="form-group">
                         <label for="last_name">นามสกุล</label>
                         <input type="text" class="form-control" id="last_name" name="last_name" required>
                     </div>
                     <div class="form-group">
                         <label for="date_of_birth">วันเดือนปีเกิด</label>
                         <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                     </div>
                     <div class="form-group">
                         <label for="gender">เพศ</label>
                         <select class="form-control" id="gender" name="gender" required>
                             <option value="Male">ชาย</option>
                             <option value="Female">หญิง</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label for="email">อีเมล์</label>
                         <input type="email" class="form-control" id="email" name="email" required>
                     </div>
                     <div class="form-group">
                         <label for="phone_number">เบอร์โทร</label>
                         <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                     </div>
                     <div class="form-group">
                         <label for="address">ที่อยู่</label>
                         <input type="text" class="form-control" id="address" name="address" required>
                     </div>


             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                 <button type="submit" class="btn btn-primary"  >บันทึก</button>
             </div>
             </form>
         </div>
     </div>
 </div>
 <!-- Add Student Modal -->
  <div class="modal fade" id="PassStudentModal" tabindex="-1" aria-labelledby="PassStudentModal" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="PassStudentModalLabel">ข้อมูลรหัสผ่าน</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form id="PassStudentForm">
              <div class="modal-body">
                  <!-- Form for adding student -->
                      <input type="hidden" id="PassstudentId" name="studentId">
                      <div class="form-group">
                          <label for="student_password">รหัสผ่าน</label>
                          <input type="text" class="form-control" id="student_password" name="student_password" required>
                      </div>


              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                  <button type="submit" class="btn btn-primary"  >บันทึก</button>
              </div>
              </form>
          </div>
      </div>
  </div>
<script type="text/javascript">
  $(document).ready(function() {
    // Initialize DataTable
    var table = $('#studentTable').DataTable({

        ajax: {
            url: 'actions/backend.php', // Replace with the actual PHP file fetching product data
            type: 'POST',
            data: {
            'action': 'fetch_students'
            },
            dataSrc: ''
        },
        columns: [
            { data: 'student_id' },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'date_of_birth' },
            { data: 'gender' },
            { data: 'email' },
            { data: 'phone_number' },
            { data: 'address' },
            {
                data: null,
                render: function(data, type, row) {
                        return '<button type="button" class="btn btn-info btn-sm editBtn" onclick="editStudent(' + row.student_id + ')">แก้ไข</button>';
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                        return '<button type="button" class="btn btn-info btn-sm editBtn" onclick="editStudentPas(' + row.student_id + ')">แก้ไข</button>';
                }
            }
        ]
    });

    // Delete Student
    window.deleteStudent = function(studentId) {
        if (confirm("Are you sure you want to delete this student?")) {
            $.ajax({
                url: 'actions/backend.php',
                type: 'POST',
                data: { studentId: studentId, action: 'delete_student' },
                success: function(response) {
                    if (response === "success") {
                        //table.ajax.reload();
                    } else {
                        alert("Failed to delete student.");
                    }
                }
            });
        }
    };
    // Add Student Button Click Event
     $('#addStudentBtn').click(function() {
         $('#addStudentModalLabel').text('Add Student');
         $('#studentId').val(''); // Clear student ID field
         $('#first_name').val('');
         $('#last_name').val('');
         $('#date_of_birth').val('');
         $('#gender').val('');
         $('#email').val('');
         $('#phone_number').val('');
         $('#address').val('');
         $('#addStudentModal').modal('show');
     });
    // Add/Edit Student
    $('#addStudentForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var action = ($('#studentId').val() != '') ? 'edit_student' : 'add_student';
        $.ajax({
            url: 'actions/backend.php',
            type: 'POST',
            data: formData + '&action=' + action,
            success: function(response) {
                if (response.includes("duplicate")) {
                    alert("พบข้อมูลซ้ำ!");
                } else {
                    $('#addStudentModal').modal('hide');
                    table.ajax.reload();
                }
            }
        });
    });
    $('#PassStudentForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'actions/backend_pass.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.includes("duplicate")) {
                    alert("พบข้อมูลซ้ำ!");
                } else {
                    $('#addStudentModal').modal('hide');
                    table.ajax.reload();
                }
            }
        });
    });


    // Delete Student (dummy)
    $(document).on('click', '.deleteBtn', function() {
        alert('Delete functionality will be implemented later');
    });
  });
  function editStudent(studentId) {
    $('#addStudentModalLabel').text('Edit Student');
    $('#studentId').val(studentId);
    $.ajax({
        url: 'actions/fetch_student.php',
        type: 'POST',
        data: { studentId: studentId },
        success: function(data) {
            var studentData = JSON.parse(data);
            $('#first_name').val(studentData.first_name);
            $('#last_name').val(studentData.last_name);
            $('#date_of_birth').val(studentData.date_of_birth);
            $('#gender').val(studentData.gender);
            $('#email').val(studentData.email);
            $('#phone_number').val(studentData.phone_number);
            $('#address').val(studentData.address);
            $('#addStudentModal').modal('show');
        }
    });
  }
  function editStudentPas(studentId) {
    $('#PassstudentId').val(studentId);
    $.ajax({
        url: 'actions/fetch_student.php',
        type: 'POST',
        data: { studentId: studentId },
        success: function(data) {
            var studentData = JSON.parse(data);
            $('#student_password').val(studentData.student_password);

            $('#PassStudentModal').modal('show');
        }
    });
  }

</script>
