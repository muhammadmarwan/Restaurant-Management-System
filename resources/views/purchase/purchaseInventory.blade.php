@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@if(count($errors))
            <div class="form-group">
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
@endif

<section class="content">

  <!-- SELECT2 EXAMPLE -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Purhchase Inventory</h3>
    </div>
    <div class="card-body">
    <form method="post" action="{{ Route('inventoryStore') }}">
    @csrf
      <div class="form-group">
          <label for="exampleInputEmail1">Select Vendor</label>
          <select class="form-control select2bs4" style="width: 100%;" name="vendorId">
            <option selected disabled>Choose here</option>
            @foreach($vendor as $val)
            <option value="{{$val->value}}">{{$val->label}}</option>
            @endforeach
          </select>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Invoice No</label>
            <input type="text" name="invoiceNo" class="form-control" id="exampleInputEmail1" placeholder="Enter Invoice No">
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Select Debit Account</label>
            <select class="form-control select2bs4" style="width: 100%;" name="accountId">
              <option selected disabled>Choose here</option>
              @foreach($accounts as $val)
              <option value="{{$val->value}}">{{$val->label}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Total Amount</label>
            <input type="text" name="amount" class="form-control" id="exampleInputEmail1" placeholder="Enter Amount">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Purchase Date</label>
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
              <input type="date" name="purchaseDate" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Purchase Description</label>
            <input type="text" name="description" class="form-control" id="exampleInputEmail1" placeholder="Enter Amount">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Due Date</label>
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
              <input type="date" name="due_date" class="form-control">
            </div>
          </div>
        </div>
      <table class="table">
      <tr>
        <th>Id</th>
        <th>Product</th>
        <th>Unit</th>
        <th>Qty</th>
        <th>Total</th>
        <th></th>
      </tr>
      <tr>
        <td>1.</td>
        <td><select class="form-control" type='text' id='first_name' name='productName[]'>
              <option selected disabled>Choose here</option>
              @foreach($products as $val)
              <option value="{{$val->value}}">{{$val->label}}</option>
              @endforeach
            </select>
        </td>

        <td><select class="form-control" type='text' id='first_name' name='unit[]'>
              <option selected disabled>Choose here</option>
              @foreach($quantityUnits as $val)
              <option value="{{$val->unit}}">{{$val->unit}}</option>
              @endforeach
            </select>
        </td>

        <td><input class="form-control" type='number' id='quantity' name='quantity[]'/></td>
        <td><input class="form-control" type='number' id='total' name='total[]'/></td>
        <td><button type="button" class="btn btn-danger" class="rem">X</button></td>
      </tr>
    </table>

    <button type="button" class='addmore btn btn-light'><b>+ Add More</b></button>
      </div>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
    
  </div>
  </form>
  </div>
  </div>

</section>

<script>
  var i=2;
  $(".addmore").on('click',function(){
    var data="<tr><td>"+i+".</td>";
        data +="<td><select class='form-control' type='text' id='productName' name='productName[]'><option selected disabled>Choose here</option>@foreach($products as $val)<option value='{{$val->value}}'>{{$val->label}}</option>@endforeach</select></td>"
        data +="<td><select class='form-control' type='text' id='unit' name='unit[]'><option selected disabled>Choose here</option>@foreach($quantityUnits as $val)<option value='{{$val->unit}}'>{{$val->unit}}</option>@endforeach</select></td>"
        data += "<td><input type='text' class='form-control' id='quantity"+i+"' name='quantity[]'/></td><td><input class='form-control' type='number' id='uPrice' name='total[]'/></td><td><button type='button' class='rem btn btn-danger'>X</button></td></tr>";
        $('table').append(data);
        i++;
});
$(".table").on('click','.rem',function(){
        $(this).parent().parent().remove();
    });

$(document).ready(function(){
 
  $("#quantity").keyup(function(){
    var total = $("#total").val()
      console.log(total)
  });
});

</script>

@endsection