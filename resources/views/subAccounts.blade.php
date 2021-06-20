@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="card-header">
                <h1 class="card-title"><b>Product List</b></h1>
                <div class="card-tools m-1">
                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#createUserModal">
                Create Product</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Account Name</th>
                      <th>Main Account Name</th>
                      <th>Account Code</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($subAccounts as $value )
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$value->account_name}}</td>
                      <td>{{$value->mainAccountName}}</td>
                      <td>{{$value->account_code}}</td>
                      <td><button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{$value->id}}" data-toggle="modal" data-target="#exampleModal">Delete</button></td>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

<!-- Modal For Delete -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <form method="post" action="{{ Route('deleteSubAccount') }}"> 
        @csrf
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <input type="hidden" name="id" class="form-control" id="input_type" value="" readonly>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" id="quickForm" method="post" action="{{ Route('storeSubAccounts') }}">
              @csrf
                <div class="card-body">
                <div class="form-group">
                  <label>Choose Parent Account</label>
                  <select class="form-control select2" style="width: 100%;" name="mainAccountId">
                    <option selected disabled>Choose here</option>
                    @foreach($accounts as $value)
                    <option value="{{$value->value}}">{{$value->label}}</option>
                    @endforeach
                  </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Account Name</label>
                    <input type="name" name="accountName" class="form-control" id="exampleInputEmail1" placeholder="Enter Account Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Account Code</label>
                    <input type="name" name="accountCode" class="form-control" id="exampleInputEmail1" placeholder="Enter Account Code">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Account Balance</label>
                    <input type="name" name="accountBalance" class="form-control" id="exampleInputEmail1" placeholder="Enter Account Balance">
                  </div>
                  <div class="form-group">
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
          </form>
      </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
    $(".deleteButton").click(function () {
    var ids = $(this).attr('data-id');
    $("#input_type").val( ids );
    $('#setupCashModel').modal('show');
    });
</script>
@endsection