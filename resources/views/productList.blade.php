@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="card">
              <div class="card-header">
                <h1 class="card-title"><b>Product List</b></h1>
                <div class="card-tools m-1">
                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#createUserModal">
                Create Product</button>
                </div>
                
                <!-- <div class="card-tools m-1">
                  <input type="text" name="search" id="search" class="form-control" placeholder="Search User Data" />
                </div> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Category</th>
                      <th>Product</th>
                      <th>Brand</th>
                      <th>Id</th>
                      <th>Code</th>
                      <th>Unit</th>
                      <th>Created By</th>
                      <th>Action</th>
                    </tr>
                    @foreach($products as $product)
                    <tr class="data-row">
                      <td>{{$loop->iteration}}</td>
                      <td class="category">{{$product->category_name}}</td>
                      <td class="product">{{$product->product_name}}</td>
                      <td class="brand">{{$product->brand}}</td>
                      <td class="id">{{$product->id}}</td>
                      <td class="code">{{$product->product_code}}</td>
                      <!-- @if($product->barcode_status == 1)
                      <td>--barcode not generated--</td>
                      @elseif($product->barcode_status == 2)
                      <td><?php echo DNS1D::getBarcodeHTML($product->barcode, 'EAN8');?></td>
                      @endif --> 
                      <td class="unit">{{$product->quantity_unit}}</td>
                      <td>{{$product->createdBy}}</td>
                      <td>&nbsp;&nbsp;<a href="#" id="edit-item" data-toggle="modal" data-target="#purchasePaymentModel">
                      <i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="" id="delete"data-id="{{$product->transaction_id }}" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    @endforeach
                  </thead>
                  <tbody>                 
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

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
        <h5 class="modal-title" id="exampleModelLabel">Purchase Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
         </div>

         <form method="post" action=" {{Route('updateProduct')}} ">
         @csrf
         <input type="hidden" name="user_id" id="input_id"> 
         <div class="modal-body">
            <div class="form-group">
              <label>Category Name</label>            
              <select class="form-control"  name="category">
              <option selected disabled>Choose here</option>
              @foreach($category as $value)
              <option value="{{ $value->value }}">{{ $value->label }}</option>
              @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Product Name</label>
              <input type="name" name="product" class="form-control" id="input_product">
            </div>
            <div class="form-group">
              <label>Product Code</label>
              <input type="text" name="code" class="form-control" id="input_code">
          </div>
            <div class="form-group">
              <label>Brand</label>
              <input type="text" name="brand" class="form-control" id="input_brand">
          </div>
          <div class="form-group">
          <label for="exampleInputEmail1">Unit</label>
          <select class="form-control select2" style="width: 100%;" name="unit" id="input_unit">
          <option selected disabled>Choose here</option>
          @foreach($units as $value)
          <option value="{{$value->unit}}">{{$value->type}}</option>
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
      <form role="form" id="quickForm" method="post" action="{{ Route('storeProduct') }}">
      @csrf
      <div class="card-body">
      <div class="form-group">
        <label>Choose Product Category</label>
        <select class="form-control select2" style="width: 100%;" name="category">
          <option selected disabled>Choose here</option>
          @foreach($category as $value)
          <option value="{{$value->value}}">{{$value->label}}</option>
          @endforeach
        </select>
        </div>
        <div class="row">
        <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputEmail1">Name</label>
          <input type="name" name="productName" class="form-control" id="exampleInputEmail1" placeholder="Enter Product Name">
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputEmail1">Code</label>
          <input type="name" name="productCode" class="form-control" id="exampleInputEmail1" placeholder="Enter Product Code">
        </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputEmail1">Brand</label>
          <input type="text" name="brand" class="form-control" id="exampleInputEmail1" placeholder="Enter Product Brand">
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputEmail1">Narration</label>
          <input type="text" name="narration" class="form-control" id="exampleInputEmail1" placeholder="Enter Best Before Months">
        </div>
        </div>
        </div>
        <div class="row">
       
        <div class="col-md-12">
        <div class="form-group">
          <label for="exampleInputEmail1">Unit</label>
          <select class="form-control select2" style="width: 100%;" name="quantityUnit">
          <option selected disabled>Choose here</option>
          @foreach($units as $value)
          <option value="{{$value->unit}}">{{$value->type}}</option>
          @endforeach
        </select>
        </div>
        </div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Barcode</label>
          <input type="string" name="barcode" class="form-control" id="exampleInputEmail1" placeholder="Barcode here">
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
    var userId = row.children(".id").text();
    var category = row.children(".category").text();
    var product = row.children(".product").text();
    var code = row.children(".code").text();
    var brand = row.children(".brand").text();
    var unit = row.children(".unit").text();

    // fill the data in the input fields
    $("#input_id").val(userId);
    $("#input_category").val(category);
    $("#input_product").val(product);
    $("#input_code").val(code);
    $("#input_brand").val(brand);
    $("#input_unit").val(unit);
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