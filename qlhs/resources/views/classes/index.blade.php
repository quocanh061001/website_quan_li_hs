@extends('home')
@section('css')
<link rel="stylesheet" href={{asset('assets/vendors/choices.js/choices.min.css')}}>
@endsection
@section('content')
{{-- add classes --}}
<div class="modal fade" id="AddClassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="exampleModalLabel">Add Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul id="saveform_errlist"></ul>
          <div class="form-group mb-3">
            <label for="name">Tên lớp:</label>
            <input type="text" class="name form-control" id="name">
          </div> 
          <div class="form-group mb-3">
            <label for="khoi">Khối:</label>
            <select class="khoi form-select" id="khoi">
                
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="gvcn">Giáo viên chủ nhiệm:</label>
            <select class="gvcn form-select" id="gvcn">
                
            </select>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_classes">Save</button>
        </div>
      </div>
    </div>
  </div>
  {{-- end add classes --}}

{{-- edit teacher modal --}}
<div class="modal fade" id="EditClassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Edit & Update Classes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <ul id="updateform_errlist">

        </ul>

        <input type="text" id="class_id">
        <div class="form-group mb-3">
          <label for="update_class_name">Tên lớp:</label>
          <input type="text" id="update_class_name" class="name form-control">
        </div>
        <div class="form-group mb-3">
          <label for="update_khoi">Khối:</label>
          <select name="khoi" class="khoi form-select" id="update_khoi">
                
          </select>
       
        </div>
        <div class="form-group mb-3">
          <label for="update_gvcn">giáo viên chủ nhiệm:</label>
          <select name="gvcn" class="gvcn form-select" id="update_gvcn">
              
          </select>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_class">Save</button>
      </div>
    </div>
  </div>
</div>
{{-- end edit teacher modal --}}

{{-- delete student modal --}}

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
                   <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddClassModal">Thêm</a>
                   
               </div>
               <div class="card-content">
                   
                   <div id="success_message"></div>
                   <!-- table head dark -->
                   <div class="form-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Tra cứu lớp">
                 </div>
                   <div class="table-responsive">
                       <table class="table mb-0">
                           <thead class="thead-dark">
                               <tr>
                                   <th>id</th>
                                   <th>Tên</th>
                                   <th>Giáo viên chủ nhiệm</th>
                                   <th>Khối</th>
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
        fetchClasses();
        function fetchClasses(){
            $.ajax({
             type: "GET",
             url:"/fetch-classes",
             dataType: "json",
             success: function(response){
               $('tbody').html("");
                  $.each(response.classes, function(key, item){
                    $('tbody').append(
                      ' <tr>\
                        <td>'+item.id+'</td>\
                        <td>'+item.name+'</td>\
                        <td>'+item.gvcn+'</td>\
                        <td>'+item.khoi+'</td>\
                        <td><button type="button" value="'+item.id+'" class="edit_classes btn btn-primary btn-sm">Edit</button><a class="btn btn-danger" style="text-decoration:none; color:white" href="class_student/'+item.id+'">Chi tiết lớp</a></td>\
                      </tr>');
                  });
                  $('.khoi').html("");
                  $.each(response.khoi, function(key, item){
                     $('.khoi').append(
                         '<option value='+item.id+'>'+item.name+'</option>'
                     );
                  });
                  $('.gvcn').html("");
                  $.each(response.gvcn, function(key, item){
                     $('.gvcn').append(
                         '<option value='+item.id+'>'+item.name+'</option>'
                     );
                  });
             }
          });
        }
        function fetch_class(query = '')
        {
           $.ajax({
            url:"/search_class",
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
            fetch_class(query);
        });
        
        $(document).on('click', '.add_classes', function(e){
           e.preventDefault();
          var data = {
            'name' : $('.name').val(),
            'khoi': $('.khoi').val(),
            'gvcn': $('.gvcn').val(),
           
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
            type : "POST",
            url : "add-classes",
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
                  $('#AddClassModal').modal('hide');
                  $('#AddClassModal').find('input').val("");
                  fetchClasses();
                }
            }
          });

        });
        $(document).on('click', '.edit_classes', function(e){
          e.preventDefault();
          $('#EditClassModal').modal('show');
          var class_id = $(this).val();
          $.ajax({
             type: "GET",
             url:"/edit-classes/"+ class_id,
             success: function(response){
              if(response.status == 404){ 
                $('#success_message').html("");
                $('#success_message').addClass('alert alert-danger');
                $('#success_message').text(response.message);
              }else{
                $('#update_class_name').val(response.message.name);
                // $('#update_khoi').val(response.message.khoi);        
                // $('#update_gvcn').val(response.message.gvcn);     
                $('#class_id').val(class_id);    
              }
                  $('#update_khoi').html("");
                  $('#update_khoi').append(
                      '<option value='+response.message.makhoi+' selected>'+response.khoi_selected+'</option>'
                    );
                  $.each(response.khoi, function(key, item){
                     $('#update_khoi').append(
                         '<option value='+item.id+'>'+item.name+'</option>'
                     );
                  });
                  $('#update_gvcn').html("");
                  $('#update_gvcn').append(
                      '<option value='+response.message.magv+' selected>'+response.gvcn_selected+'</option>'
                    );
                  $.each(response.gvcn, function(key, item){
                     $('#update_gvcn').append(
                         '<option value='+item.id+'>'+item.name+'</option>'
                     );
                  }); 
             }
          });
                 
        }); 
        $(document).on('click', '.update_class', function(e){
          e.preventDefault();
          var class_id = $('#class_id').val();
          var khoi = document.getElementById("update_khoi");
          var gvcn = document.getElementById("update_gvcn");
          var data = {
            'name' : $('#update_class_name').val(),
            'khoi' : khoi.value,
            'gvcn' : gvcn.value,
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            type: "PUT",
            url: "update-classes/" + class_id,
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
                  $('#EditClassModal').modal('hide');
                  fetchClasses();
                }
            }
          });
        });
    })
</script>
@endsection