@extends('layout.app')

@section('content')

<!-- Modal for add student-->
<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul id="saveform_errList" style="list-style: none;"></ul>

                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Emial</label>
                    <input type="text" class="email form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="Course">Course</label>
                    <input type="text" class="course form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_student">Add Student</button>
            </div>
        </div>
    </div>
</div>
<!-- End of student add -->

<!-- Student edit start -->
<div class="modal fade" id="UpdateStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul id="updateform_errList" style="list-style: none;"></ul>
                <input type="hidden" name="" id="edit_stud_id">
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" id="edit_name" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Emial</label>
                    <input type="text" id="edit_email" class="email form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" id="edit_phone" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="Course">Course</label>
                    <input type="text" id="edit_course" class="course form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary update_student">Update Student</button>
            </div>
        </div>
    </div>
</div>
<!-- Student edit end -->



<!-- Student delete start -->
<div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="" id="delete_stud_id">
                <h4>Are you sure ? want to delete the record ?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary delete_student">Yes Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- Student delete end -->


<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div id="success_message"></div>
            <div class="card">
                <div class="card-header">
                    <h4>Students Data</h4>
                    <a href="" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal" data-bs-target="#AddStudentModal">Add Student</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    $(document).on('click', '.deletestudent', function() {
        
        var stud_id = $(this).val();
        // alert();
        $('#delete_stud_id').val(stud_id);
        $('#DeleteStudentModal').modal('show');


    });

    $(document).on('click', '.delete_student', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $('#delete_stud_id').val();
        $.ajax({
            type: 'DELETE',
            url: '/deletestudent/'+id,
            success: function(response) {
                if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                         $('#success_message').text(response.message);
                        // $('.delete_student').text('Yes Delete');
                        $('#DeleteStudentModal').modal('hide');
                        fetchstudent();
                    }
                }
        });
    });


    fetchstudent();

    function fetchstudent() {
        $.ajax({
            type: 'GET',
            url: '/fetchstudent',
            dataType: 'json',
            success: function(response) {
                // console.log(response.students);
                 $('tbody').html("");
                $.each(response.students, function(key, item) {
                    $('tbody').append(
                        '<tr>\
                             <td>' + item.name + '</td>\
                             <td>' + item.email + '</td>\
                             <td>' + item.phone + '</td>\
                             <td>' + item.course + '</td>\
                             <td>\
                             <button type="button" class="edit_student btn btn-primary" value="' + item.id + '">Edit</button>\
                             <button type="button" class="deletestudent btn btn-warning" value="' + item.id + '">Delete</button>\
                             </td>\
                         </tr>');
                });
            }
        });
    }
    $(document).on('click', '.edit_student', function(e) {
        e.preventDefault();
        var stud_id = $(this).val();
        // console.log(stud_id);
        $('#UpdateStudentModal').modal('show');

        $.ajax({
            type: 'GET',
            url: '/editstudent/' + stud_id,
            success: function(response) {
                // console.log(response);
                if (response.status == 404) {
                    $('#success_message').html("");
                    $('#success_message').addClass('alert alert-success')
                    $('#success_message').text(response.message);
                } else {
                    $('#edit_stud_id').val(response.student.id);
                    $('#edit_name').val(response.student.name);
                    $('#edit_email').val(response.student.email);
                    $('#edit_phone').val(response.student.phone);
                    $('#edit_course').val(response.student.course);
                }
            }
        });
    });

    $(document).on('click', '.update_student', function(e) {
        e.preventDefault();
        var stud_id = $('#edit_stud_id').val();
        var data = {
            'name': $('#edit_name').val(),
            'email': $('#edit_name').val(),
            'phone': $('#edit_phone').val(),
            'course': $('#edit_course').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'PUT',
            url: '/updatestudent/' + stud_id,
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 400) {
                    $('#updateform_errList').html("");
                    $('#updateform_errList').addClass('alert alert-danger');
                    $.each(response.errors, function(key, err_values) {
                        $('#updateform_errList').append('<li>' + err_values + '</li>');
                    });
                } else if (response.status == 400) {
                    $('#updateform_errList').html("");
                    $('#success_message').addClass('alert alert-success')
                    $('#success_message').text(response.message)

                } else {
                    $('#updateform_errList').html("");
                    $('#success_message').addClass('alert alert-success')
                    $('#success_message').text(response.message)
                    $('#UpdateStudentModal').modal('hide');
                    $('#UpdateStudentModal').find('input').val("");
                    fetchstudent();
                }
            }
        });
    });


    $(document).ready(function() {
        $(document).on("click", '.add_student', function(e) {
            e.preventDefault();
            var data = {
                'name': $('.name').val(),
                'email': $('.email').val(),
                'phone': $('.phone').val(),
                'course': $('.course').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/storestudent",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#saveform_errList').html("");
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err_values) {
                            $('#saveform_errList').append('<li>' + err_values + '</li>');
                        });
                    } else {
                        $('#saveform_errList').html("");
                        $('#success_message').addClass('alert alert-success')
                        $('#success_message').text(response.message)
                        $('#AddStudentModal').modal('hide');
                        $('#AddStudentModal').find('input').val("");
                        fetchstudent();
                    }
                    // console.log(response);
                    // alert(response);
                }
            });
        });
    });
</script>
@endsection