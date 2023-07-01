@extends('home')
@section('css')
<link rel="stylesheet" href={{asset('assets/vendors/choices.js/choices.min.css')}}>
@endsection
@section('content')


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
                </div>
                <div class="card-content">
                    
                    <div id="success_message"></div>
                    <!-- table head dark -->
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tên tài khoản</th>
                                    <th>email</th>
                                    <th>Role</th>
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
        fetchteacher();
        function fetchteacher(){
          $.ajax({
             type: "GET",
             url:"/fetch-user",
             dataType: "json",
             success: function(response){
              $('tbody').html("");
                  $.each(response.users, function(key, item){
                    $('tbody').append(
                      ' <tr>\
                        <td>'+item.name+'</td>\
                        <td>'+item.email+'</td>\
                        <td>'+item.role+'</td>\
                        <td><button type="button" value="'+item.id+'" class="edit_teacher btn btn-primary btn-sm">Edit</button><button type="button" value="'+item.id+'" class="delete_teacher btn btn-danger btn-sm">Delete</button></td>\
                      </tr>');
                  });
                  
             }
          });
        }

    });
</script>
@endsection