@extends('home')
@section('css')
<link rel="stylesheet" href={{asset('assets/vendors/choices.js/choices.min.css')}}>
@endsection
@section('content')
<!-- Modal -->
{{-- addteacher --}}
<div class="modal fade" id="AddteacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="exampleModalLabel">Add Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul id="saveform_errlist"></ul>
          <div class="form-group mb-3">
            <label for="name">Tên giáo viên:</label>
            <input type="text" class="name form-control" id="name">
          </div>
          <div class="form-group mb-3">
            <label for="gender">Giới tính:</label>
            <select class="gender form-select" id="gender" >
                  <option value="Nam">Nam</option>
                  <option value="Nữ">Nữ</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="basicSelect">Bộ môn:</label>
            <select class="subject form-select" id="basicSelect" >
                
            </select>
            {{-- <fieldset class="form-group">
            </fieldset> --}}
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_teacher">Save</button>
        </div>
      </div>
    </div>
  </div>
  {{-- end addsteacher --}}
{{-- edit teacher modal --}}
<div class="modal fade" id="EditteacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="exampleModalLabel">Edit & Update Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
          <ul id="updateform_errlist">
  
          </ul>
  
          <input type="text" id="edit_teacher_id">
          <div class="form-group mb-3">
            <label for="update_name">Tên giáo viên:</label>
            <input type="text" id="update_name" class="name form-control">
          </div>
          <div class="form-group mb-3">
            <label for="update_gender">Giới tính:</label>
            <select class="gender form-select" id="update_gender">
              
            </select>

          </div>
          <div class="form-group mb-3">
            <label for="subject">Bộ môn:</label>
            <select name="subject" class="subject form-select" id="subject">
                
            </select>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_teacher">Save</button>
        </div>
      </div>
    </div>
  </div>
  {{-- end edit teacher modal --}}
{{-- delete student modal --}}
<div class="modal fade" id="DeleteTeacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Xóa giáo viên</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <input type="text" id="delete_teacher_id">
        <p>Bạn có muốn xóa giáo viên này không?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_button">Delete</button>
      </div>
    </div>
  </div>
</div>
{{-- end delete student modal --}}
<header class="mb-3">
  <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
  </a>
</header>
<div class="page-heading">
   <!-- Table head options start -->
   <section class="section">
    <div class="row" id="table-head">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Table head options</h4>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddteacherModal">Thêm</a>
                   
                </div>
                <div class="card-content">
                    
                    <div id="success_message"></div>
                    <!-- table head dark -->
                    <h5>Tìm kiếm giáo viên:</h5>
                    <div class="form-group">
                      <input type="text" name="search" id="search" class="form-control" placeholder="Tra cứu giáo viên">
                   </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>id</th>
                                    <th>Tên</th>
                                    <th>Giới tính</th>
                                    <th>Bộ môn</th>
                                    <th>ACTION</th>
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
</section>
<!-- Table head options end -->
</div>


@endsection
@section('scripts')
<script src={{asset('assets/js/main.js')}} ></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){    
        fetchteacher();
        function fetchteacher(){
          $.ajax({
             type: "GET",
             url:"/fetch-teachers",
             dataType: "json",
             success: function(response){
              $('tbody').html("");
                  $.each(response.teachers, function(key, item){
                    $('tbody').append(
                      ' <tr>\
                        <td>'+item.id+'</td>\
                        <td>'+item.name+'</td>\
                        <td>'+item.gioitinh+'</td>\
                        <td>'+item.tenbomon+'</td>\
                        <td><button type="button" value="'+item.id+'" class="edit_teacher btn btn-primary btn-sm">Edit</button><button type="button" value="'+item.id+'" class="delete_teacher btn btn-danger btn-sm">Delete</button></td>\
                      </tr>');
                  });
                  $('.subject').html("");
                  $.each(response.subjects, function(key, item){
                     $('.subject').append(
                         '<option value='+item.id+'>'+item.name+'</option>'
                     );
                  });
             }
          });
        }
        function fetch_teacher_data(query = '')
        {
           $.ajax({
            url:"/search_teacher",
            method:'GET',
            data:{query:query},
            dataType:'json',
            success:function(data)
            {
                $('tbody').html("");
                $('tbody').append(data.table_data);
                
            }
           })
        }

         $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_teacher_data(query);
        });

        $(document).on('click', '.delete_teacher', function(e){
          e.preventDefault();
          var teacher_id = $(this).val();
          $('#DeleteTeacherModal').modal('show');
          $('#delete_teacher_id').val(teacher_id);
        });

        $(document).on('click', '.delete_button', function(e){
          e.preventDefault();
          var teacher_id = $('#delete_teacher_id').val(); 
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          
          $.ajax({
            type: "DELETE",
            url:"/delete-teacher/"+ teacher_id,
            success: function(response){
               $('#success_message').addClass('alert alert-success');
               $('#success_message').text(response.message);
               $('#DeleteTeacherModal').modal('hide');
               fetchteacher();
            }
          })
        });
        
        $(document).on('click', '.edit_teacher', function(e){
          e.preventDefault();
          // console.log(student_id);
          $('#EditteacherModal').modal('show');
          var teacher_id = $(this).val();
          $.ajax({
             type: "GET",
             url:"edit-teacher/"+ teacher_id,
             success: function(response){
              //  console.log(response);
              if(response.status == 404){ 
                $('#success_message').html("");
                $('#success_message').addClass('alert alert-danger');
                $('#success_message').text(response.message);
              }else{
                $('#update_name').val(response.message.name);
                $('#update_gender').html("");
                $('#subject').html("");
                $('#update_gender').append(
                      '<option value='+response.gt_selected+' selected>'+response.gt_selected+'</option>\
                       <option value='+response.gt+'>'+response.gt+'</option>'
                   );
                    $('#subject').append(
                      '<option value='+response.message.bomon+' selected>'+response.subject_name+'</option>'
                    );
                    $.each(response.subject, function(key, item){
                    $('#subject').append(
                      '<option value='+item.id+'>'+item.name+'</option>'
                    );
                  });   
                $('#edit_teacher_id').val(teacher_id);
                
              }
             }
          });
        }); 
        $(document).on('click', '.update_teacher', function(e){
          e.preventDefault();
          var teacher_id = $('#edit_teacher_id').val();
          var elem = document.getElementById("subject");
          var data = {
            'name' : $('#update_name').val(),
            'gender' : $('#update_gender').val(),
            'subject' : elem.value,
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            type: "PUT",
            url: "update-teacher/" + teacher_id,
            data: data,
            dataType: "json",
            success: function(response){
              if(response.status == 400){
                  $('#updateform_errlist').html("");
                  $('#updateform_errlist').addClass('alert alert-danger');
                  $.each(response.errors, function(key, err_values){
                     $('#updateform_errlist').append('<li>' + err_values+'</li>');
                  });
                }else if(response.status == 404){
                  $('#updateform_errlist').html("");
                  $('#updateform_errlist').addClass('alert alert-danger');
                  $('#updateform_errlist').text(response.message);

                }else{
                  $('#updateform_errlist').html("");
                  $('#success_message').html("");
                  $('#success_message').addClass('alert alert-success');
                  $('#success_message').text(response.message);
                  $('#EditteacherModal').modal('hide');
                  fetchteacher();
                }
            }
          });
        });

        $(document).on('click', '.add_teacher', function(e){
           e.preventDefault();
          var data = {
            'name' : $('.name').val(),
            'gender': $('.gender').val(),
            'subject': $('.subject').val(),
           
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
            type : "POST",
            url : "/add-teacher",
            data : data,
            dataType: "json",
            success: function(response){
             
                if(response.status == 400){
                  $('#saveform_errlist').html("");
                  $('#saveform_errlist').addClass('alert alert-danger');
                  $.each(response.errors, function(key, err_values){
                     $('#saveform_errlist').append('<li>' + err_values+'</li>');
                  });
                }
                else{
                  $('#saveform_errlist').html('');
                  $('#success_message').addClass('alert alert-success');
                  $('#success_message').text(response.message);
                  $('#AddteacherModal').modal('hide');
                  $('#AddteacherModal').find('input').val("");
                  fetchteacher();
                }
            }
          });

        });   
    });
</script>
@endsection