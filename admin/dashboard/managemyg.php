
<div class="container-fluid mt-5">
    <h2 class="mb-4"> ผลการเรียน</h2>
    <div class="table-responsive">
      <table id="courseTable" class="table">
          <thead>
              <tr>
                  <th>ชั้นเรียน</th>
                  <th>ปี</th>
                  <th>เทอม</th>
                  <th>ดูผลการเรียน</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
    </div>

</div>


<!-- Create Class Modal -->
<div class="modal fade" id="createClassModal" tabindex="-1" aria-labelledby="createClassModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="createClassModalLabel">Create Class</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
              <form  id="createCourseClassForm" method="POST">
                   <div class="form-group">
                       <label for="course_id">Course Name:</label>
                       <input type="hidden" id="Class_id" name="Class_id">
                       <select id="course_id" name="course_id" class="form-control">
                           <!-- Options will be populated dynamically -->
                       </select>
                   </div>
                   <div class="form-group" >
                       <label for="course_id">Course Term:</label>
                       <select id="Term" name="Term" class="form-control">
                           <option value="1">1</option>
                           <option value="2">2</option>
                       </select>
                   </div>
                   <div class="form-group">
                       <label>Students:</label><br>
                       <div id="SelectStudents" style="height:540px;overflow-y: scroll;">

                       </div>
                   </div>
                   <button type="submit" class="btn btn-primary">Save Class</button>
               </form>
           </div>
       </div>
   </div>
</div>
<!-- Create Class Modal -->
<div class="modal fade" id="DetailClassModal" tabindex="-1" aria-labelledby="DetailClassModalLabel" aria-hidden="true">
   <div class="modal-dialog  modal-xl">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="DetailClassModalLabel">ข้อมูล</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
             <table class="table table-bordered">
               <tbody>
                 <tr>
                   <td width="30%">ชั้นเรียน</td>
                   <td id="Class_Name"></td>
                 </tr>
                 <tr>
                   <td width="30%">ปี</td>
                   <td id="Class_Year"> </td>
                 </tr>
                 <tr>
                   <td width="30%">เทอม</td>
                   <td id="Class_Term"> </td>
                 </tr>
                 <tr>
                   <td colspan="2" >
                     <div class="container-fluid">
                      <div class="row">
                        <div class="col-4" id="stu_list">

                        </div>
                        <div class="col-8" id="sub_list">

                        </div>
                      </div>
                    </div>
                   </td>
                 </tr>
               </tbody>
             </table>
           </div>
       </div>
   </div>
</div>
<script type="text/javascript">

  $(document).ready(function() {

    // Load courses into DataTable
    var table = $('#courseTable').DataTable({
        ajax: 'actions/get_classcourses.php',
        columns: [
            { data: 'course_name' },
            { data: 'course_year' },
            { data: 'term' },
            {
                data: null,
                render: function(data, type, row) {
                    return  '<button type="button" class="btn btn-warning btn-sm" onclick="function_CourseDetail(' + row.course_id + ','+ row.term +')"    >ดู</button>';
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
    $('#createCourseClassForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Send AJAX request to create_course.php
        $.ajax({
            url: 'actions/action_class.php',
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
  function function_CourseDetail(course_id,term) {
    $('#DetailClassModal').modal("show");
    $.ajax({
        url: 'actions/get_My_classcourses.php',
        type: 'POST',
        data: { id: course_id,term:term },
        success: function(data) {
            var course_data = JSON.parse(data);
            $("#Class_Name").html(course_data['data'][0]['course_name']);
            $("#Class_Year").html(course_data['data'][0]['course_year']);
            $("#Class_Term").html(course_data['data'][0]['term']);
            var text = 'รายชื่อนักเรียน <hr><ul>';
            for (var i = 0; i < course_data['data'].length; i++) {
                text += '<li><a href="#" onclick="function_update_g('+course_data['data'][i]['student_id']+','+course_data['data'][0]['term']+','+course_data['data'][0]['course_id']+');">  '+course_data['data'][i]['first_name']+' '+course_data['data'][i]['last_name']+'</a></li>';
            }
            text += '</ul>';
            $("#stu_list").html(text);
            $('#DetailClassModal').modal("show");
        }
    });
  }

  $('#addClassStudentBtn').click(function () {
     $("#Class_id").val("");
     get_courses();
     get_stu();
    $("#createClassModal").modal("show");
  })
  function get_courses() {
    $.ajax({
        url: 'actions/action_class.php',
        type: 'POST',
        data: { createCourse: 'createCourse' },
        success: function(data) {
          $("#course_id").html(data);
        }
    });
  }
  function get_stu() {
    $.ajax({
        url: 'actions/action_class.php',
        type: 'POST',
        success: function(data) {
          $("#SelectStudents").html(data);
        }
    });
  }
  function get_courses_id(id) {
    $.ajax({
        url: 'actions/action_class.php',
        type: 'POST',
        data: { createCourse: 'createCourse',id:id },
        success: function(data) {
          $("#course_id").html(data);
        }
    });
  }
  function get_stu_id(id,term) {
    $.ajax({
        url: 'actions/action_class.php',
        type: 'POST',
        data: {id:id,term:term },
        success: function(data) {
          $("#SelectStudents").html(data);
        }
    });
  }
  function function_editCourseDetail(course_id,term) {
    get_courses_id(course_id);
    get_stu_id(course_id,term);
    $("#Class_id").val('update');
    $("#createClassModal").modal("show");
  }

  function function_update_g(student_id,term,course_id) {
    //$("#sub_list").html(stu_id);
    $.ajax({
        url: 'actions/get_Mylist_courses.php',
        type: 'POST',
        data: { student_id:student_id,term:term,course_id: course_id},
        success: function(data) {
            $("#sub_list").html(data);
        }
    });
  }
  function function_saveg(student_id,course_id,term) {
    var nulls = 0;
    var subjects = [];
    var subjects_id = [];
    var len = $('input[name="subjects[]"]').valueOf().length
    for (var i = 0; i < len; i++) {
      var value = $('input[name="subjects[]"]').valueOf()[i]['value'];
      var id = $('input[name="subjects[]"]').valueOf()[i]['id'];
      if (value=='') {
        nulls++;
      }else {
        subjects.push(value);
        subjects_id.push(id);
      }
    }
    if (nulls>0) {
      alert('Error กรอกคะแนนให้ครบทุกวิชา');
    }else {
      $.ajax({
          url: 'actions/action_g.php',
          type: 'POST',
          data: { student_id:student_id,course_id:course_id,term:term,subjects:subjects,subjects_id:subjects_id},
          success: function(response) {
              // Handle success response
              alert(' successfully!');
              // Optionally, you can redirect user to a success page or display a success message
          },
          error: function(xhr, status, error) {
              // Handle error response
              alert('Error  course:', error);
              // Optionally, display an error message to the user
          }
      });
    }
  }
</script>
