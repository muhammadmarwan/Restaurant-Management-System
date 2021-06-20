@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@if(session()->has('message2'))
    <div class="alert alert-danger">
        {{ session()->get('message2') }}
    </div>
@endif
<div class="card">
<div class="card-header">
                <h2 class="card-title"><b>Users List</b></h2>
                <div class="card-tools">
                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#createUserModal">
                Create User</button>
                </div>
              </div>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Qty</th>
                      <th>User ID</th>
                      <th>Full Name</th>
                      <th>User Role</th>
                      <th>Date</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th colspan="3" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($userList as $value)
                  <tr class="data-row">
                    <td>{{$loop->iteration}}</td>
                    <td class="userId">{{$value->user_id}}</td>
                    <td class="userName">{{$value->user_name}}</td>
                    <td class="role">{{$value->role}}</td>
                    <td>{{$value->date}}</td>
                    <td class="email">{{$value->email_id}}</td>
                    <td class="phone">{{$value->phone_number}}</td>
                    <td><button class="btn btn-block bg-gradient-success btn-sm payBtn" id="edit-item" data-toggle="modal" >Edit</button></td>
                    <td><button class="btn btn-block bg-gradient-warning btn-sm" data-toggle="modal" data-target="#pswdUpdate{{$value->id}}">Pswd</button></td>
                    <td><button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{$value->user_id}}" data-toggle="modal" data-target="#exampleModal">Delete</button></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>

<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModelLabel">Purchase Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
         </div>

         <form method="post" action=" {{Route('updateUser')}} ">
         @csrf
         <input type="hidden" name="userId" id="input_id"> 
         <div class="modal-body">
            <div class="form-group">  
              <label>User name</label>
              <input type="name" name="userName" class="form-control" id="input_name">
            </div>
            <div class="form-group">
                  <label>User Role</label>
                  <select class="form-control select2" style="width: 100%;" name="userRole">
                    <option value="1">Admin</option>
                    <option value="2">Accountant</option>
                    <option value="3">Cashier</option>
                    <option value="4">Kitchen</option>

                  </select>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="name" name="email" class="form-control" id="input_email">
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" name="phone" class="form-control" id="input_phone">
          </div>
          </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
             <button type="submit" class="btn btn-success">Done</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal For Delete -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <form method="post" action="{{ Route('deleteUser') }}"> 
        @csrf
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <input type="hidden" name="userId" class="form-control" id="input_type" value="" readonly>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal For Password Update -->
<div class="modal fade" id="pswdUpdate{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change User Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="{{Route('changeUserPassword')}}">
      @csrf
        <input type="hidden" value="{{$value->id}}" name="id">
        <div class="form-group">
              <label>Enter New Password</label>
              <input type="password" name="pass" class="form-control" placeholder="Please Enter New Password">
            </div>
            <div class="form-group">
              <label>Confirm New Password</label>
              <input type="password" name="confPass" class="form-control" placeholder="Please Confirm New Password">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" id="quickForm" method="post" action="{{ Route('store') }}">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Full Name</label>
                    <input type="name" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter Your Full Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Id</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Your Email Id">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone Number</label>
                    <input type="phone" name="phone" class="form-control" id="exampleInputEmail1" placeholder="Enter Your Phone Number">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                  <label>User Role</label>
                  <select class="form-control select2" style="width: 100%;" name="userRole">
                    <option value="1">Admin</option>
                    <option value="2">Accountant</option>
                    <option value="3">Cashier</option>
                    <option value="4">Kitchen</option>
                  </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>



<script>
  $(document).ready(function() {
  /**
   * for showing edit item popup
   */
  $(document).on('click', "#edit-item", function() {

    $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
    var options = {
      'backdrop': 'static'
    };
    $('#edit-modal').modal(options)
  })

  // on modal show
  $('#edit-modal').on('show.bs.modal', function() {
    var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
    var row = el.closest(".data-row");

    // get the data
    var id = el.data('item-id');
    var userId = row.children(".userId").text();
    var userName = row.children(".userName").text();
    var userRole = row.children(".role").text();
    var email = row.children(".email").text();
    var phone = row.children(".phone").text();


    // fill the data in the input fields
    $("#input_id").val(userId);
    $("#input_name").val(userName);
    $("#input_role").val(userRole);
    $("#input_email").val(email);
    $("#input_phone").val(phone);

  })
  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})
</script>
 
<script type="text/javascript" charset="utf-8">
    $(".deleteButton").click(function () {
    var ids = $(this).attr('data-id');
    $("#input_type").val( ids );
    $('#setupCashModel').modal('show');
    });
</script>

@endsection