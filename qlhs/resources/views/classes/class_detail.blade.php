@extends('home')
@section('css')
<link rel="stylesheet" href={{asset('assets/vendors/choices.js/choices.min.css')}}>
@endsection
@section('content')
{{-- add student --}}
<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="exampleModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul id="saveform_errlist"></ul>
          <div class="form-group mb-3">
            <label>Tên học sinh:</label>
            <input type="text" class="name form-control">
          </div> 
          <div class="form-group mb-3">
            <label >Giới tính:</label>
            {{-- <input type="text" class="gender form-control"> --}}
            <select class="gender form-select" >
              <option value="Nam">Nam</option>
              <option value="Nữ">Nữ</option>
            </select>
          </div> 
          <div class="form-group mb-3">
            <label>Địa chỉ:</label>
            <input type="text" class="address form-control">
          </div> 
          <div class="form-group mb-3">
            <label>Dân tộc:</label>
            <input type="text" class="dt form-control">
          </div> 
          <div class="form-group mb-3">
            <label>Niên khóa:</label>
            <input type="text" class="nk form-control">
          </div> 
          <div class="form-group mb-3">
            <label>Điểm rèn luyện:</label>
            <input type="text" class="rl form-control">
          </div> 
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_student">Save</button>
        </div>
      </div>
    </div>
  </div>
  {{-- end add student --}}

{{-- edit student modal --}}
<div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Edit & Update Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <ul id="updateform_errlist">

        </ul>

        <input type="text" id="student_id">
        <div class="form-group mb-3">
          <label for="update_name">Tên học sinh:</label>
          <input type="text" id="update_name" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label for="update_gender">Giới tính:</label>
          <select class="gender form-select" id="update_gender" >
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
          </select>
        </div>
        <div class="form-group mb-3">
          <label for="update_address">Địa chỉ:</label>
          <input type="text" id="update_address" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label for="update_dt">Dân tộc:</label>
          <input type="text" id="update_dt" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label for="update_nk">Niên khóa:</label>
          <input type="text" id="update_nk" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label for="update_rl">Điểm rèn luyện:</label>
          <input type="text" id="update_rl" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_student">Save</button>
      </div>
    </div>
  </div>
</div>
{{-- end edit student modal --}}
{{-- delete student modal --}}
<div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Xóa giáo viên</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <input type="text" id="delete_student_id">
        <p>Bạn có muốn xóa học sinh này không?</p>
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
                   <div style="display: flex">
                    <h4>Tên lớp: {{ $class->name }} -</h4>
                    <h4>Giáo viên chủ nhiệm: {{ $class->teacher_name }}</h4>
                   </div>
                   <input type="text" id="class_id" value="{{ $class->id }}" disabled>                  
                   <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddStudentModal">Thêm</a>
                   
                   <form action="{{ url('/upload_student/'. $class->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                     <input type="file" name="file">
                     <input type="submit" value="Import Data">
                   </form>
                   <a href="{{ url('/export_student/'.$class->id) }}" class="btn btn-sm btn-success">
                        Xuất file
                   </a>

               </div>
               <div class="card-content">
                   
                   <div id="success_message"></div>
                   <!-- table head dark -->
                   <h5>Tìm kiếm học sinh:</h5>
                    <div class="form-group">
                      <input type="text" name="search" id="search" class="form-control" placeholder="Tra cứu học sinh">
                   </div>
                   <div class="table-responsive">
                       <table class="table mb-0">
                           <thead class="thead-dark">
                               <tr>
                                   <th>id</th>
                                   <th>Họ và tên</th>
                                   <th>Giới tính</th>
                                   <th>Dân tộc</th>
                                   <th>Điểm rèn luyện</th>
                                   <th>Action</th>
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
         fetchStudents();
         function fetchStudents(){
          var class_id = $('#class_id').val();
            $.ajax({
             type: "GET",
             url:"/fetch-student/"+class_id,
             dataType: "json",
             success: function(response){
               $('tbody').html("");
                  $.each(response.students, function(key, item){
                    $('tbody').append(
                      ' <tr>\
                        <td>'+item.id+'</td>\
                        <td>'+item.name+'</td>\
                        <td>'+item.gioitinh+'</td>\
                        <td>'+item.dantoc+'</td>\
                        <td>'+item.renluyen+'</td>\
                        <td><button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button><button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</button></td></tr>'
                        );
                  });          
             }
          });
         }
         function fetch_student(query = '')
        {
           $class_id = $('#class_id').val();
           $.ajax({
            url:"/search_student/"+$class_id,
            method:'GET',
            data:{
              query:query
            },
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
            fetch_student(query);
        });

        $(document).on('click', '.add_file', function(e){
           e.preventDefault();
           var class_id = $('#class_id').val();
           $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({
            type : "POST",
            url :"/upload_student/"+class_id,
            dataType: "json",
            success: function(response){      
                if(response.status == 400){
                  $('#saveform_errlist').html("");
                  $('#saveform_errlist').addClass('alert alert-danger');
                  
                }
                else{
                
                  fetchStudents();
                }
            }
          });
        });

         $(document).on('click', '.add_student', function(e){
           e.preventDefault();
          var class_id = $('#class_id').val();
          var data = {
            'name' : $('.name').val(),
            'address': $('.address').val(),
            'gender': $('.gender').val(),
            'dt': $('.dt').val(),
            'nk': $('.nk').val(),
            'rl': $('.rl').val(),
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            type : "POST",
            url :"/add-student/"+class_id ,
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
                  $('#AddStudentModal').modal('hide');
                  $('#AddStudentModal').find('input').val("");
                  fetchStudents();
                }
            }
          });
        });

        $(document).on('click', '.edit_student', function(e){
          e.preventDefault();
          $('#EditStudentModal').modal('show');
          var class_id = $('#class_id').val();
          var student_id = $(this).val();
          $.ajax({
             type: "GET",
             url:"/edit-student/"+class_id+"/"+student_id,
             success: function(response){
              if(response.status == 404){ 
                $('#success_message').html("");
                $('#success_message').addClass('alert alert-danger');
                $('#success_message').text(response.message);
              }else{
                $('#update_name').val(response.message.name);
                $('#update_gender').val(response.message.gioitinh);        
                $('#update_address').val(response.message.diachi);
                $('#update_dt').val(response.message.dantoc);        
                $('#update_nk').val(response.message.nienkhoa);        
                $('#update_rl').val(response.message.renluyen);        

                $('#student_id').val(student_id);

              } 
             }
          });     
        }); 
        $(document).on('click', '.update_student', function(e){
          e.preventDefault();
          var student_id = $('#student_id').val();
          var data = {
            'name' : $('#update_name').val(),
            'gender' : $('#update_gender').val(),
            'address' : $('#update_address').val(),
            'dt' : $('#update_dt').val(),
            'nk' : $('#update_nk').val(),
            'rl' : $('#update_rl').val(),
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            type: "PUT",
            url: "/update-student/" + student_id,
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
                  $('#EditStudentModal').modal('hide');
                  fetchStudents();
                }
            }
          });
        });

        $(document).on('click', '.delete_student', function(e){
          e.preventDefault();
          var student_id = $(this).val();
          $('#DeleteStudentModal').modal('show');
          $('#delete_student_id').val(student_id);
        });

        $(document).on('click', '.delete_button', function(e){
          e.preventDefault();
          var student_id = $('#delete_student_id').val(); 
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          
          $.ajax({
            type: "DELETE",
            url:"/delete-student/"+ student_id,
            success: function(response){
               $('#success_message').addClass('alert alert-success');
               $('#success_message').text(response.message);
               $('#DeleteStudentModal').modal('hide');
               fetchStudents();
            }
          })
        });

      })
</script>


@endsection