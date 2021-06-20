@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="card">
              <div class="card-header">
                <h2 class="card-title"><b>Vendor List</b></h2>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Vendor Name</th>
                      <th>Code</th>
                      <th>V Id</th>
                      <th>Email Id</th>
                      <th>Phone</th>
                      <th>Country By</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($vendor as $value)
                  <tr class="data-row">
                    <td>{{$loop->iteration}}</td>
                    <td class="vendorName">{{$value->name}}</td>
                    <td class="vendorCode">{{$value->vendor_id}}</td>
                    <td class="vendorId">{{$value->id}}</td>
                    <td class="email">{{$value->email_id}}</td>
                    <td class="phone">{{$value->phone}}</td>
                    <td class="country">{{$value->country}}</td>
                    <td>&nbsp;&nbsp;<a href="#" id="edit-item" data-toggle="modal" data-target="#purchasePaymentModel">
                      <i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="" id="delete"data-id="{{$value->transaction_id }}" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-trash"></i></a></td>
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
        <form method="post" action="{{ Route('deleteProduct') }}"> 
        @csrf
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <input type="hidden" name="productId" class="form-control" id="input_type" value="" >
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

<!-- model for edit -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModelLabel">Edit Vendor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
         </div>

         <form method="post" action=" {{Route('vendorUpdate')}} ">
         @csrf
         <input type="hidden" name="vendorId" id="input_vendorId"> 
         <div class="modal-body">
            <div class="form-group">
              <label>Vendor Name</label>            
              <input type="name" name="vendorName" class="form-control" id="input_vendorName">
            </div>
            <div class="form-group">
              <label>Vendor Code</label>
              <input type="name" name="vendorCode" class="form-control" id="input_vendorCode">
            </div>
            <div class="form-group">
              <label>Email Id</label>
              <input type="text" name="emailId" class="form-control" id="input_email">
          </div>
          <div class="form-group">
              <label>Phone</label>
              <input type="name" name="phone" class="form-control" id="input_phone">
            </div>
            <div class="form-group">
                  <label>Country</label>
                  <select class="form-control select2" style="width: 100%;" name="country" id="input_country">
                    <option disabled selected>Please Select Country</option>
                  @foreach($country as $value)
                    <option value="{{$value->name}}">{{$value->name}}</option>
                  @endforeach 
                  </select>
                  </div>
          </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
             <button type="submit" class="btn btn-primary">Submit</button>
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
    var vendorId = row.children(".vendorId").text();
    var vendorCode = row.children(".vendorCode").text();
    var vendorName = row.children(".vendorName").text();
    var email = row.children(".email").text();
    var phone = row.children(".phone").text();
    var country = row.children(".country").text();

    // fill the data in the input fields
    $("#input_vendorId").val(vendorId);
    $("#input_vendorName").val(vendorName);
    $("#input_vendorCode").val(vendorCode);
    $("#input_email").val(email);
    $("#input_phone").val(phone);
    $("#input_country").val(country);

  })
  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})
</script>

<script type="text/javascript" charset="utf-8">
    $("#delete").click(function () {
    var ids = $(this).attr('data-id');
    $("#input_type").val( ids );
    $('#setupCashModel').modal('show');
    });
</script>

@endsection