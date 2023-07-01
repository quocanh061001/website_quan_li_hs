@extends('home')
@section('css')
<link rel="stylesheet" href={{asset('assets/vendors/choices.js/choices.min.css')}}>
@endsection
@section('content')

{{-- add classes --}}
<div class="modal fade" id="AddGradeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Thêm điểm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-3">
          <input type="text" style="display:none;" id="student_id" disabled>                  

          <div style="display:flex; justify-content:space-around">
             <div class="student_info">

             </div>
             <div class="student_grade" style="margin-left:20px;">

             </div>
          </div> 
        </div>
          <h3>Thông tin điểm</h3>
          <hr>
        <ul id="saveform_errlist"></ul>
          <div style="display:flex; justify-content:space-around">
             
            <div class="subject_grade">
               <p>Tra cứu điểm:</p>
                  <div class="form-group">
                     <input type="text" name="search" id="search_grade" class="form-control" placeholder="Tra cứu điểm">
                  </div>
              <div class="table-responsive" style="max-height:300px">
                <table class="table mb-0 grade_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Môn học</th>
                            <th>Loại điểm</th>
                            <th>Điểm</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="subject_info">
                        
                    </tbody>
                </table>
             </div>
             <br>
            <div class="dtb_list"></div>

            </div>
            <div class="input_grade_field ">
              <div class="form-group mb-3">
          
                <input type="text" id="dtm_id" disabled>                  
              </div>
                <div class="form-group mb-3">
                    <label for="subject">Môn học:</label>
                    <select class="subject form-select" id="subject">
                           
                    </select>
                </div>
                <div class="form-group mb-3">
                  <label for="subject_type">Loại điểm:</label>
                  <select class="subject_type form-select" id="subject_type">
                      
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label for="diem">Điểm:</label>
                  <input type="text" class="diem form-control" id="diem">
                </div>
              <button type="button" class="add_subject_grade btn btn-primary btn-sm">Thêm</button>
              <button type="button" class="update_grade btn btn-primary btn-sm" disabled>Xác nhận sửa</button>

            </div>
          </div>   
          <hr>
          <h3>Thông tin điểm khen thưởng</h3>

          <ul id="ktkl_errlist"></ul>
          <div style="display:flex; justify-content:space-around">            
            <div class="ktkl_grade">
               <p>Tra cứu điểm:</p>
                  <div class="form-group">
                     <input type="text" name="search" id="search_ktkl" class="form-control" placeholder="Tra cứu điểm">
                  </div>
              <div class="table-responsive" style="max-height:300px;">
                <table class="table mb-0 grade_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Thời gian</th>
                            <th>Nội dung</th>
                            <th>Môn học</th>
                            <th>Điểm cộng/trừ</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ktkl_info">
                        
                    </tbody>
                </table>
             </div>
            </div>
            <div class="input_grade_field ">
              <div class="form-group mb-3">
          
                <input type="text" id="hskt_id" disabled>                  
              </div>
                <div class="form-group mb-3">
                    <label for="subject_ktkl">Môn học:</label>
                    <select class="subject_ktkl form-select" id="subject_ktkl">
                           
                    </select>
                </div>
                <div class="form-group mb-3">
                  <label for="ktkl">Nội dung:</label>
                  <select class="ktkl form-select" id="ktkl">
                      
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label for="diem_ktkl">Điểm:</label>
                  <input type="text" class="diem_ktkl form-control" id="diem_ktkl">
                </div>
              <button type="button" class="add_ktkl_grade btn btn-primary btn-sm">Thêm</button>
              <button type="button" class="update_ktkl_grade btn btn-primary btn-sm" disabled>Xác nhận sửa</button>

            </div>
            
          </div>  
       
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>
{{-- end add classes --}}
{{-- delete grade modal --}}
<div class="modal fade" id="DeleteGradeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Xóa điểm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <input type="text" id="delete_grade_id">
        <p>Bạn có muốn xóa điểm này không?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_button">Delete</button>
      </div>
    </div>
  </div>
</div>
{{-- end delete grade modal --}}
{{-- delete grade modal --}}
<div class="modal fade" id="Delete_hskt_GradeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Xóa điểm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <input type="text" id="delete_hskt_grade_id">
        <p>Bạn có muốn xóa điểm này không?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_hskt_button">Delete</button>
      </div>
    </div>
  </div>
</div>
{{-- end delete grade modal --}}
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
                    <h4>Giáo viên chủ nhiệm: {{ $teacher->name }}</h4>
                   </div>
                   <input type="text" id="class_id" value="{{ $class->id }}" disabled>                  
                  

               </div>
               <div class="card-content">
                   <h5>Tìm kiếm học sinh:</h5>
                  <div class="form-group">
                     <input type="text" name="search" id="search" class="form-control" placeholder="Tìm kiếm học sinh">
                  </div>

                   <div id="success_message"></div>

                   <!-- table head dark -->
                   <div class="table-responsive">
                       <table class="table mb-0">
                           <thead class="thead-dark">
                               <tr>
                                   <th>id</th>
                                   <th>Họ và tên</th>
                                   <th>Giới tính</th>
                                   <th>Dân tộc</th>
                                   <th>Điểm rèn luyện</th>
                                   <th>Điểm trung bình</th>
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
{{-- <script src={{asset('assets/js/main.js')}} ></script> --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script>
      $(document).ready(function(){    
         fetchStudents();
         function fetchStudents(){
          var class_id = $('#class_id').val();
            $.ajax({
             type: "GET",
             url:"/fetch_studentgrade/"+class_id,
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
                        <td>'+ item.diemtrungbinh +'</td>\
                        <td><button type="button" value="'+item.id+'" class="add_grade btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddGradeModal">Chi tiết học sinh</button></td></tr>'
                      );
                  });      
             }
          });
         }
         function fetch_grade($student_id){        
             var student_id = $student_id;
             $.ajax({
                type: "GET",
                url:"/student_detail/"+student_id,
                dataType: 'json',
                success: function(response){
                  if(response.status == 404){
                    $('#success_message').html("");
                    $('#success_message').addClass('alert alert-danger');
                    $('#success_message').text(response.message);
                  }else{
                    $('#student_id').val(student_id);

                    $('.student_info').html("");
                    $('.student_grade').html("");
                    $('.subject_info').html("");
                    $('.subject').html("");
                    $('.subject_type').html("");
                    $('.ktkl_info').html("");
                    $('.subject_ktkl').html("");
                    $('.ktkl').html("");
                    $('.dtb_list').html("");
                    
                    $.each(response.dtb_list, function(key, item){
                    $('.dtb_list').append(
                      '<span> '+ item.name+': '+ item.dtb +'</span>'
                    );
                  });

                    $('.student_info').append(
                      '<p> Họ và tên:'+response.student.name+ '</p>\
                       <p> Giới tính:'+response.student.gioitinh+'</p>\
                       <p> Địa chỉ:'+response.student.diachi+'</p>\
                       <p> Dân tộc:'+response.student.dantoc+'</p>'
                    );
                    $('.student_grade').append(
                      '<p> Điểm trung bình các môn:'+response.student.diemtrungbinh+'</p>\
                       <p> Hạnh kiểm:'+ response.hanhkiem+'</p>'
                    );
                    $.each(response.subject_grade, function(key, item){
                    $('.subject_info').append(
                      ' <tr>\
                        <td>'+item.name+'</td>\
                        <td>'+item.loaidiem+'</td>\
                        <td>'+item.diem+'</td>\
                        <td><button type="button" value="'+ item.id +'" class="edit_mark btn btn-primary btn-sm">Sửa</button><button type="button" value="'+ item.id +'" class="delete_mark btn btn-danger btn-sm">Xóa</button></td>\
                        </tr>'
                    );
                  });
                  $.each(response.subject, function(key, item){
                    $('.subject').append(
                      '<option value='+item.id+'>'+item.name+'</option>'
                    );
                  });
                  $.each(response.loaidiem, function(key, item){
                    $('.subject_type').append(
                      '<option value='+item.id+'>'+item.name+'</option>'
                    );
                  });
                  $.each(response.hskt_grade, function(key, item){
                    $('.ktkl_info').append(
                      ' <tr>\
                        <td>'+item.created_day+'</td>\
                        <td>'+item.kt_kl+'</td>\
                        <td>'+item.name+'</td>\
                        <td>'+item.diem+'</td>\
                        <td><button type="button" value="'+ item.id +'" class="edit_hskt btn btn-primary btn-sm">Sửa</button><button type="button" value="'+ item.id +'" class="delete_hskt btn btn-danger btn-sm">Xóa</button></td>\
                        </tr>'
                    );
                  });
                  $.each(response.subject, function(key, item){
                    $('.subject_ktkl').append(
                      '<option value='+item.id+'>'+item.name+'</option>'
                    );
                  });
                  $.each(response.kt_kl, function(key, item){
                    $('.ktkl').append(
                      '<option value='+item.id+'>'+item.name+'</option>'
                    );
                  });
                  

                  }
                }
             });
         }
        
         function fetch_student_data(query = '')
        {
           $.ajax({
            url:"{{ route('search') }}",
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
             fetch_student_data(query);
        });

        function fetch_grade_data(query = '')
        {
           $student_id = $('#student_id').val();
           $.ajax({
            url:"/search_grade/"+$student_id,
            method:'GET',
            data:{
              query:query
            },
            dataType:'json',
            success:function(data)
            {
                $('.subject_info').html("");
                $('.subject_info').append(data.table_data);      
            }
           })
        }

         $(document).on('keyup', '#search_grade', function(){
            var query = $(this).val();
            fetch_grade_data(query);
        });

         function fetch_ktkl_data(query = '')
        {
           $student_id = $('#student_id').val();
           $.ajax({
            url:"/search_ktkl/"+$student_id,
            method:'GET',
            data:{
              query:query
            },
            dataType:'json',
            success:function(data)
            {
                $('.ktkl_info').html("");
                $('.ktkl_info').append(data.table_data);      
            }
           })
        }

         $(document).on('keyup', '#search_ktkl', function(){
            var query = $(this).val();
            fetch_ktkl_data(query);
        });

//----------------add grade-------------//
         $(document).on('click', '.add_grade', function(e){
             e.preventDefault();
             fetch_grade($(this).val());        
         });

         $(document).on('click', '.add_subject_grade', function(e){
           e.preventDefault();
          var student_id = $('#student_id').val();
          var data = {
            'subject' : $('.subject').val(),
            'loaidiem' : $('.subject_type').val(),
            'diem' : $('.diem').val()
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            type : "POST",
            url :"/add-studentgrade/"+student_id ,
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
                  // $('#AddGradeModal').find('input').val("");
                  $('#diem').val("");
                  fetch_grade(student_id);
                  // fetchStudents();
                }
            }
          });
        });

        $(document).on('click', '.edit_mark', function(e){
          e.preventDefault();
          var class_id = $('#class_id').val();
          var student_id = $('#student_id').val();
          var diemtm_id = $(this).val();
          $('.update_grade').prop("disabled", false);
          $('.add_subject_grade').prop("disabled", true);
         
          $.ajax({
             type: "GET",
             url:"/edit-studentgrade/"+class_id+"/"+student_id+"/"+diemtm_id,
             success: function(response){
              if(response.status == 404){ 
                $('#success_message').html("");
                $('#success_message').addClass('alert alert-danger');
                $('#success_message').text(response.message);
              }else{
                $('#dtm_id').val(diemtm_id);
                $('.diem').val(response.diem);              
                $('.subject').html("");
                $('.subject_type').html("");
                $('.subject').append(
                      '<option value='+response.subject_select+' selected>'+response.tenmonhoc+'</option>'
                    );
                $.each(response.subject, function(key, item){
                    $('.subject').append(
                      '<option value='+item.id+'>'+item.name+'</option>'
                    );
                  });
                  $('.subject_type').append(
                      '<option value='+response.loaidiem_select+' selected>'+response.tenloaidiem+'</option>'
                    );
                $.each(response.loaidiem, function(key, item){
                    $('.subject_type').append(
                      '<option value='+item.id+'>'+item.name+'</option>'
                    );
                  });     
              } 
             }
          });     
        }); 
        $(document).on('click', '.update_grade', function(e){
          e.preventDefault();
          var student_id = $('#student_id').val();
          var dtm_id = $('#dtm_id').val();
          var data = {
            'diem' : $('.diem').val(),
            'loaidiem' : $('.subject_type').val(),
            'monhoc' : $('.subject').val()
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            type: "PUT",
            url: "/update-studentgrade/" + student_id + "/" + dtm_id,
            data: data,
            dataType: "json",
            success: function(response){
              if(response.status == 400){
                  $('#saveform_errlist').html("");
                  $('#saveform_errlist').addClass('alert alert-danger');
                  $.each(response.errors, function(key, err_values){
                     $('#saveform_errlist').append('<li>' + err_values+'</li>');
                  });
                }else if(response.status == 404){
                  $('#saveform_errlist').html("");
                  $('#saveform_errlist').addClass('alert alert-danger');
                  $('#saveform_errlist').text(response.message);

                }else{
                  
                  $('.update_grade').prop("disabled", true);
                  $('.add_subject_grade').prop("disabled", false);

                  $('#saveform_errlist').html('');
                  $('#saveform_errlist').remove('alert-danger');
                  $('.diem').val("");
                  $('#dtm_id').val("");
                  fetch_grade(student_id);
                }
            }
          });
        });

        $(document).on('click', '.delete_mark', function(e){
          e.preventDefault();
          var dtm_id = $(this).val();
          $('#DeleteGradeModal').modal('show');
          $('#delete_grade_id').val(dtm_id);
        });

        $(document).on('click', '.delete_button', function(e){
          e.preventDefault();
          var dtm_id = $('#delete_grade_id').val(); 
          var student_id = $('#student_id').val();

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          
          $.ajax({
            type: "DELETE",
            url:"/delete-studentgrade/"+ dtm_id,
            success: function(response){
               $('#DeleteGradeModal').modal('hide');
               fetch_grade(student_id);
            }
          })
        });

        $(document).on('click', '.add_ktkl_grade', function(e){
           e.preventDefault();
          var student_id = $('#student_id').val();
          var data = {
            'subject' : $('.subject_ktkl').val(),
            'makhenthuong' : $('.ktkl').val(),
            'diem' : $('.diem_ktkl').val()
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            type : "POST",
            url :"/add-hsktgrade/"+student_id ,
            data : data,
            dataType: "json",
            success: function(response){      
                if(response.status == 400){
                  $('#ktkl_errlist').html("");
                  $('#ktkl_errlist').addClass('alert alert-danger');
                  $.each(response.errors, function(key, err_values){
                     $('#ktkl_errlist').append('<li>' + err_values+'</li>');
                  });
                }
                else{
                  $('#ktkl_errlist').html('');
                  // $('#AddGradeModal').find('input').val("");
                  $('#diem_ktkl').val("");
                  fetch_grade(student_id);
                }
            }
          });
        });
        $(document).on('click', '.edit_hskt', function(e){
          e.preventDefault();
          var class_id = $('#class_id').val();
          var student_id = $('#student_id').val();
          var hskt_id = $(this).val();
          $('.update_ktkl_grade').prop("disabled", false);
          $('.add_ktkl_grade').prop("disabled", true);
         
          $.ajax({
             type: "GET",
             url:"/edit-hsktgrade/"+class_id+"/"+student_id+"/"+hskt_id,
             success: function(response){
              if(response.status == 404){ 
                $('#success_message').html("");
                $('#success_message').addClass('alert alert-danger');
                $('#success_message').text(response.message);
              }else{
                $('#hskt_id').val(hskt_id);
                $('#diem_ktkl').val(response.diem);              
                $('.subject_ktkl').html("");
                $('.ktkl').html("");
                $('.subject_ktkl').append(
                      '<option value='+response.subjectktkl_select+' selected>'+response.tenmonhoc+'</option>'
                    );
                $.each(response.subject, function(key, item){
                    $('.subject_ktkl').append(
                      '<option value='+item.id+'>'+item.name+'</option>'
                    );
                  });
                  $('.ktkl').append(
                      '<option value='+response.ktkl_select+' selected>'+response.tenktkl+'</option>'
                    );
                $.each(response.ktkl, function(key, item){
                    $('.ktkl').append(
                      '<option value='+item.id+'>'+item.name+'</option>'
                    );
                  });     
              } 
             }
          });     
        }); 
        $(document).on('click', '.update_ktkl_grade', function(e){
          e.preventDefault();
          var student_id = $('#student_id').val();
          var hskt_id = $('#hskt_id').val();
          var data = {
            'diem' : $('.diem_ktkl').val(),
            'ktkl' : $('.ktkl').val(),
            'monhoc' : $('.subject_ktkl').val()
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            type: "PUT",
            url: "/update-hsktgrade/" + student_id + "/" + hskt_id,
            data: data,
            dataType: "json",
            success: function(response){
              if(response.status == 400){
                  $('#ktkl_errlist').html("");
                  $('#ktkl_errlist').addClass('alert alert-danger');
                  $.each(response.errors, function(key, err_values){
                     $('#ktkl_errlist').append('<li>' + err_values+'</li>');
                  });
                }else if(response.status == 404){
                  $('#ktkl_errlist').html("");
                  $('#ktkl_errlist').addClass('alert alert-danger');
                  $('#ktkl_errlist').text(response.message);

                }else{
                  
                  $('.update_ktkl_grade').prop("disabled", true);
                  $('.add_ktkl_grade').prop("disabled", false);

                  $('#ktkl_errlist').html('');
                  $('#ktkl_errlist').remove('alert-danger');
                  $('.diem_ktkl').val("");
                  $('#hskt_id').val("");
                  fetch_grade(student_id);
                }
            }
          });
        });
        $(document).on('click', '.delete_hskt', function(e){
          e.preventDefault();
          var hskt_id = $(this).val();
          $('#Delete_hskt_GradeModal').modal('show');
          $('#delete_hskt_grade_id').val(hskt_id);
        });

        $(document).on('click', '.delete_hskt_button', function(e){
          e.preventDefault();
          var hskt_id = $('#delete_hskt_grade_id').val(); 
          var student_id = $('#student_id').val();

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          
          $.ajax({
            type: "DELETE",
            url:"/delete-hsktgrade/"+ hskt_id,
            success: function(response){
               $('#Delete_hskt_GradeModal').modal('hide');
               fetch_grade(student_id);
            }
          })
        });
      })
</script>


@endsection