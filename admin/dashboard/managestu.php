<div class="container-fluid mt-5">
    <h2>Student Management System</h2>
    <button class="btn btn-primary mb-3" id="addStudentBtn">Add Student</button>
    <div class="table-responsive">
      <table id="studentTable" class="table table-striped">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Date of Birth</th>
                  <th>Gender</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th>Address</th>
                  <th>Action</th>
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
                 <h5 class="modal-title" id="addStudentModalLabel">Student</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form id="addStudentForm">
             <div class="modal-body">
                 <!-- Form for adding student -->
                     <input type="hidden" id="studentId" name="studentId">
                     <div class="form-group">
                         <label for="first_name">First Name</label>
                         <input type="text" class="form-control" id="first_name" name="first_name" required>
                     </div>
                     <div class="form-group">
                         <label for="last_name">Last Name</label>
                         <input type="text" class="form-control" id="last_name" name="last_name" required>
                     </div>
                     <div class="form-group">
                         <label for="date_of_birth">Date of Birth</label>
                         <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                     </div>
                     <div class="form-group">
                         <label for="gender">Gender</label>
                         <select class="form-control" id="gender" name="gender" required>
                             <option value="Male">Male</option>
                             <option value="Female">Female</option>
                             <option value="Other">Other</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label for="email">Email</label>
                         <input type="email" class="form-control" id="email" name="email" required>
                     </div>
                     <div class="form-group">
                         <label for="phone_number">Phone Number</label>
                         <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                     </div>
                     <div class="form-group">
                         <label for="address">Address</label>
                         <input type="text" class="form-control" id="address" name="address" required>
                     </div>


             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary"  >Save changes</button>
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
                        return '<button type="button" class="btn btn-info btn-sm editBtn" onclick="editStudent(' + row.student_id + ')">Edit</button>';
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
                    alert("Email already exists!");
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

</script>
