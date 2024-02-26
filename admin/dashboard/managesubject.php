
<div class="container-fluid mt-5">
    <h2>จัดการข้อมูล รายวิชา</h2>
    <hr>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSubjectModal">เพิ่มข้อมูล</button>
    <div class="table-responsive">
      <table id="subjectTable" class="table table-striped">
          <thead>
              <tr>
                  <th>ไอดี</th>
                  <th>ชื่อวิชา</th>
                  <th>รหัสวิชา</th>
                  <th>หน่วยกิต</th>
                  <th>คำอธิบาย</th>
                  <th>จัดการ</th>
              </tr>
          </thead>
          <tbody>
              <!-- Subjects will be populated here -->
          </tbody>
      </table>
    </div>

</div>
<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubjectModalLabel">ข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSubjectForm">
                    <div class="form-group">
                        <label for="subjectName">ชื่อวิชา</label>
                        <input type="text" class="form-control" id="subjectName" name="subjectName" required>
                    </div>
                    <div class="form-group">
                        <label for="subjectCode">รหัสวิชา</label>
                        <input type="text" class="form-control" id="subjectCode" name="subjectCode" required>
                    </div>
                    <div class="form-group">
                        <label for="subjectCredit">หน่วยกิต</label>
                        <input type="number" class="form-control" id="subjectCredit" name="subjectCredit" required>
                    </div>
                    <div class="form-group">
                        <label for="subjectDescription">คำอธิบาย</label>
                        <textarea class="form-control" id="subjectDescription" name="subjectDescription" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubjectModalLabel">ข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editSubjectForm">
                    <input type="hidden" id="editSubjectId" name="editSubjectId">
                    <div class="form-group">
                        <label for="editSubjectName">ชื่อวิชา</label>
                        <input type="text" class="form-control" id="editSubjectName" name="editSubjectName" required>
                    </div>
                    <div class="form-group">
                        <label for="editSubjectCode">รหัสวิชา</label>
                        <input type="text" class="form-control" id="editSubjectCode" name="editSubjectCode" required>
                    </div>
                    <div class="form-group">
                        <label for="editSubjectCredit">หน่วยกิต</label>
                        <input type="number" class="form-control" id="editSubjectCredit" name="editSubjectCredit" required>
                    </div>
                    <div class="form-group">
                        <label for="editSubjectDescription">คำอธิบาย</label>
                        <textarea class="form-control" id="editSubjectDescription" name="editSubjectDescription" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    // Initialize DataTable
    var table = $('#subjectTable').DataTable({
        ajax: {
            url: 'actions/get_subjects.php', // URL to your PHP script that retrieves data
            dataSrc: '' // By default, DataTables expects data in 'data' property. Since our PHP script returns an array directly, we set this to an empty string.
        },
        columns: [
            { data: 'subject_id' },
            { data: 'subject_name' },
            { data: 'subject_code' },
            { data: 'subject_credit' },
            { data: 'subject_description' },
            {
                data: null,
                render: function(data, type, row) {
                    return '<button type="button" class="btn btn-primary btn-sm editBtn" data-toggle="modal" data-target="#editSubjectModal" data-id="' + row.subject_id + '">แก้ไข</button>';
                }
            }
        ]
    });

    // Add Subject
    $('#addSubjectModal').on('shown.bs.modal', function() {
        $(this).find('form')[0].reset();
    });

    $('#addSubjectForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'actions/add_subject.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response === 'success') {
                    $('#addSubjectModal').modal('hide');
                    table.ajax.reload();
                } else {
                    alert('Failed to add subject.');
                }
            }
        });
    });

    // Edit Subject
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'actions/get_subjects.php',
            type: 'GET',
            data: { id: id },
            success: function(response) {
                var subject = JSON.parse(response);
                $('#editSubjectForm input[name="editSubjectId"]').val(subject[0]['subject_id']);
                $('#editSubjectForm input[name="editSubjectName"]').val(subject[0]['subject_name']);
                $('#editSubjectForm input[name="editSubjectCode"]').val(subject[0]['subject_code']);
                $('#editSubjectForm input[name="editSubjectCredit"]').val(subject[0]['subject_credit']);
                $('#editSubjectForm textarea[name="editSubjectDescription"]').val(subject[0]['subject_description']);
            }
        });
    });

    $('#editSubjectForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'actions/edit_subject.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response === 'success') {
                    $('#editSubjectModal').modal('hide');
                    table.ajax.reload();
                } else {
                    alert('Failed to edit subject.');
                }
            }
        });
    });

    // Delete Subject
    $(document).on('click', '.deleteBtn', function() {
        if (confirm('Are you sure you want to delete this subject?')) {
            var id = $(this).data('id');
            $.ajax({
                url: 'actions/delete_subject.php',
                type: 'POST',
                data: { subject_id: id },
                success: function(response) {
                    if (response === 'success') {
                        table.ajax.reload();
                    } else {
                        alert('Failed to delete subject.');
                    }
                }
            });
        }
    });
  });

</script>
