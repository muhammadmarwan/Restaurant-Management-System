@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="card-header">
    <h2 class="card-title"><b>Items List</b></h2>
    <div class="card-tools">
    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#exampleModal">
    Create New Items</button>
    </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Item Code</th>
            <th>Item Id</th>
            <th>Description</th>
            <th>Amount</th>
            <th width="15%">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
        <tr class="data-row">
            <td>{{$loop->iteration}}</td>
            <td class="itemName">{{$item->item_name}}</td>
            <td class="itemCode">{{$item->item_code}}</td>
            <td class="itemId">{{$item->id}}</td>
            <td class="description">{{$item->description}}</td>
            <td class="amount">{{$item->amount}}</td>
            <td><button type="button" class="btn btn-warning btn-sm" id="edit-item">Edit</button>
            <button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{$item->id}}" data-toggle="modal" data-target="#exampleModalDelete">Delete</button></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="{{ Route('storeItems') }}">
        @csrf
            <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                  <label>Item Name</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="text" name="name" class="form-control" placeholder="Enter Item Name">
                    </div>
                </div>
              </div>              
            </div>
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Item Code</label>
                  <input type="text" name="itemCode" class="form-control" id="exampleInputEmail1" placeholder="Enter Item Code">
                  </select>
                </div>
              </div> 
              <div class="col-md-6">
              <div class="form-group">
                <label>Amount</label>
                  <input type="number" name="amount" class="form-control" id="exampleInputEmail1" placeholder="Enter Amount">
                  </select>
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Description</label>
                  <input type="text" name="description" class="form-control" id="exampleInputEmail1" placeholder="Enter Description">
                  </select>
                </div>
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


<!-- Modal for edit -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="{{ Route('updateItems') }}">
        @csrf
            <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                  <label>Item Name</label>
                    <input type="hidden" name="itemId" id="input_id">
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="text" id="input_name" name="name" class="form-control" placeholder="Enter Item Name">
                    </div>
                </div>
              </div>              
            </div>
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Item Code</label>
                  <input type="text" id="input_code" name="itemCode" class="form-control" id="exampleInputEmail1" placeholder="Enter Item Code">
                  </select>
                </div>
              </div> 
              <div class="col-md-6">
              <div class="form-group">
                <label>Amount</label>
                  <input type="number" id="input_amount" name="amount" class="form-control" id="exampleInputEmail1" placeholder="Enter Amount">
                  </select>
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Description</label>
                  <input type="text" id="input_description" name="description" class="form-control" id="exampleInputEmail1" placeholder="Enter Description">
                  </select>
                </div>
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
<div class="modal fade" id="exampleModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <form method="post" action="{{ Route('deleteItem') }}"> 
        @csrf
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <input type="hidden" name="itemId" class="form-control" id="input_type" value="" readonly>
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
    var itemId = row.children(".itemId").text();
    var itemName = row.children(".itemName").text();
    var itemCode = row.children(".itemCode").text();
    var description = row.children(".description").text();
    var amount = row.children(".amount").text();

    // fill the data in the input fields
    $("#input_id").val(itemId);
    $("#input_name").val(itemName);
    $("#input_code").val(itemCode);
    $("#input_description").val(description);
    $("#input_amount").val(amount);

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
