@extends("layouts.admin")

@section("page-content")

<div class="col-12 col-sm-12">
    <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            <strong class="p-2">Dine In Tables List</strong>
        </ul>
        <div class="card-tools">
            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#exampleModal">
            Create New Table</button>
        </div>
        </div>
        <div class="card-body">
        <div class="row">
        @foreach($tables as $val)
          <div class="col-sm-2 m-2 deleteButton" id="demo" data-id="{{$val->id}}" data-toggle="modal" data-target="#deleteModel">
            <div class="card card-body card-sm bg-danger itemCard" style="width: 8rem;" wire:click="SalesType('TAKE AWAY')">
                <h4>{{$val->table_no}}</h4>
                <br>
                <small>{{$val->table_name}}</small>    
            </div>
          </div>
        @endforeach
        </div>
        </div> 
    </div>
</div>     

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Table</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ Route('storeDineTable') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label>Table Name</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="text" name="tableName" class="form-control" placeholder="Enter Table Name">
                    </div>
                </div>
              </div>
               <div class="col-md-6">
                <label>Table Number</label>
                <input type="number" name="tableNumber" class="form-control" id="exampleInputEmail1" placeholder="Enter Table Number">
            </div>
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

<!-- Modal For Delete -->
<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <form method="post" action="{{ Route('dineTableDelete') }}"> 
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

<script type="text/javascript" charset="utf-8">
    $(".deleteButton").click(function () {
    var ids = $(this).attr('data-id');
    $("#input_type").val( ids );
    $('#setupCashModel').modal('show');
    });
</script>
@endsection