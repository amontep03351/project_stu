<div class="container-fluid mt-5">
    <h2 class="mb-4">จัดการข้อมูล คอร์สเรียน</h2>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCourseModal">เพิ่มข้อมูล</button>
    <div class="table-responsive">
      <table id="courseTable" class="table">
          <thead>
              <tr>
                  <th>ไอดี</th>
                  <th>ชื่อคอร์ส</th>
                  <th>ปี</th>
                  <th>จัดการ</th>
                  <th>รายละเอียด</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
    </div>

</div>
<!-- Add/Edit Course Modal -->
<!-- Add/Edit Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">ข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form fields for adding/editing course -->
                <form id="courseForm">
                    <input type="hidden" id="courseId" name="courseId">
                    <div class="form-group">
                        <label for="courseName">ชื่อคอร์ส</label>
                        <input type="text" class="form-control" id="courseName" name="courseName" required>
                    </div>
                    <div class="form-group">
                        <label for="courseYear">ปี</label>
                        <input type="text" class="form-control"  id="courseYear" name="courseYear" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" id="saveCourseBtn">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<!-- Create Course Modal -->
<div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCourseModalLabel">ข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createCourseForm" method="POST">
                    <div class="form-group">
                        <label for="course_name">ชื่อคอร์ส:</label>
                        <input type="text" class="form-control" id="course_name" name="course_name" readonly>
                        <input type="hidden" class="form-control" id="course_id" name="course_id"  >
                    </div>
                    <div class="form-group">
                      <label for="course_year">ปี</label>
                      <input type="text" class="form-control"  id="course_year" name="course_year" readonly>
                    </div>
                    <div class="form-group">
                        <label>รายวิชาในคอร์ส:</label><br>
                        <div id="SelectSubjects">

                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

  $(document).ready(function() {
    $('#courseYear').datepicker({
         changeMonth: false,
         changeYear: true,
         showButtonPanel: true,
         dateFormat: 'yy',
         onClose: function(selectedDate) {
             // Optionally, you can do something when the datepicker closes
         }
     }).focus(function() {
         $(this).blur(); // Prevent the datepicker from appearing on focus
     }).next('.ui-datepicker-trigger').button({
         icon: 'ui-icon-calendar',
         showOn: 'button', // Show the datepicker only when the button is clicked
         buttonText: 'Select Year'
     });
    // Load courses into DataTable
    var table = $('#courseTable').DataTable({
        ajax: 'actions/get_courses.php',
        columns: [
            { data: 'course_id' },
            { data: 'course_name' },
            { data: 'course_year' },
            {
                data: null,
                render: function(data, type, row) {
                    return '<button type="button" class="btn btn-info btn-sm" onclick="function_editCourse(' + row.course_id + ')"    >แก้ไข</button>';
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return  '<button type="button" class="btn btn-success btn-sm" onclick="function_CourseDetail(' + row.course_id + ')"    >รายละเอียด</button>';
                }
            }
        ]
    });


    // Add/Edit Course Modal Load
    $('#addCourseBtn').click(function() {
         // Trigger the modal to open
         $('#addCourseModalLabel').text('Add course');
         $('#studentId').val("");
         $('#addCourseModal').modal('show');
    });

    // Save Course Button Click Event
     $('#saveCourseBtn').click(function() {
         var courseId = $('#courseId').val();
         var courseName = $('#courseName').val();
         var courseYear = $('#courseYear').val();

         // Create FormData object
         var formData = new FormData();
         formData.append('courseId', courseId);
         formData.append('courseName', courseName);
         formData.append('courseYear', courseYear);

         // Determine the action based on whether courseId is present
         var action = (courseId !== '') ? 'edit_course' : 'add_course';

         formData.append('action', action);

         // Send AJAX request to save course changes
         $.ajax({
             url: 'actions/backend_courses.php',
             type: 'POST',
             data: formData,
             processData: false,
             contentType: false,
             success: function(response) {
                 if (response === 'success') {
                     // Close the modal
                     $('#addCourseModal').modal('hide');
                     // Reload DataTable
                     $('#courseTable').DataTable().ajax.reload();
                 } else {
                     alert('Failed to save changes.');
                 }
             }
         });
     });

    // Delete Course
    $(document).on('click', '.deleteBtn', function() {
        var courseId = $(this).data('id');
        if (confirm('Are you sure you want to delete this course?')) {
            $.ajax({
                url: 'delete_course.php',
                type: 'POST',
                data: { course_id: courseId },
                success: function(response) {
                    if (response === 'success') {
                        table.ajax.reload();
                    } else {
                        alert('Failed to delete course.');
                    }
                }
            });
        }
    });
    $('#createCourseForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Send AJAX request to create_course.php
        $.ajax({
            url: 'actions/create_course.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Handle success response
                alert('Course created successfully!');
                // Optionally, you can redirect user to a success page or display a success message
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert('Error creating course:', error);
                // Optionally, display an error message to the user
            }
        });
    });
  });
  function function_editCourse(id) {
    $('#addCourseModalLabel').text('Edit course');
    $('#courseId').val(id);
    $.ajax({
        url: 'actions/edit_course.php',
        type: 'POST',
        data: { id: id },
        success: function(data) {
            var course_data = JSON.parse(data);
            $('#courseName').val(course_data.course_name);
            $('#courseYear').val(course_data.course_year);
            $('#addCourseModal').modal('show');
        }
    });

  }
  function function_CourseDetail(id) {
    $("#course_id").val(id);
    $.ajax({
        url: 'actions/edit_course.php',
        type: 'POST',
        data: { id: id },
        success: function(data) {
            var course_data = JSON.parse(data);
            $('#course_name').val(course_data.course_name);
            $('#course_year').val(course_data.course_year);
            get_subjects(id);


        }
    });

  }
  function get_subjects(id) {
    $.ajax({
        url: 'actions/get_subjects.php',
        type: 'POST',
        data: { createCourse: id },
        success: function(data) {
          $("#SelectSubjects").html(data);
          $("#createCourseModal").modal("show");
        }
    });
  }
</script>
