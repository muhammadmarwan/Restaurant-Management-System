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
<div class="card">
              <div class="card-header">
                <h2 class="card-title"><b>Pending Payments</b></h2>
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
                      <th>Payment Type</th>
                      <th>Amount</th>
                      <th>Bill No</th>
                      <th>Due Date</th>
                      <th>Payable Account</th> 
                      <th>Payment Status</th>
                      <th>Pay</th>
                    </tr>
                  </thead>
                  <tbody>
                  <!-- {{$i=0}} -->
                  <!-- {{$i++}} -->
                    @foreach($purchase as $val)
                    <tr class="data-row">
                      <td>{{$i}}</td>
                      <td class="vName">{{$val->vendorName}}</td>
                      <td>{{$val->type}}</td>
                      <td class="amount">{{$val->amount}}</td>
                      <td class="billNo">{{$val->bill_no}}</td>
                      <td>{{$val->due_date}}</td>
                      <td class="pending">{{$val->pending}}</td>
                      @if($val->pending==0)
                      <td style="color:#009933" colspan="2"><b>PAID</b></td>
                      @endif
                      @if($val->pending!=0)
                      <td style="color:#ffcc00"><b>PENDING</b></td>
                      <td><button class="btn btn-block bg-gradient-success payBtn" id="edit-item" data-id="{{$val->id}}" data-toggle="modal" data-target="#purchasePaymentModel">PAY</button>
                     @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
  </section>

<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModelLabel">Purchase Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
         </div>

         <form method="post" action=" {{Route('storePurchasePayment')}} ">
         @csrf
         <input type="hidden" name="hidden_id" id="hidden_id"> 
         <div class="modal-body">
            <div class="form-group">
              <label>Vendor Name</label>
              <input type="name" name="vendorName" class="form-control" id="input_vName" readonly>
            </div>
            <div class="form-group">
              <label>Bill No</label>
              <input type="name" name="billNumber" class="form-control" id="input_billNo" readonly>
            </div>
            <div class="form-group">
              <label>Amount</label>
              <input type="name" name="amount" class="form-control" id="input_amount" readonly>
            </div>
            <div class="form-group">
              <label>Payment Method</label>
              <select class="form-control select2" style="width: 100%;" name="paymentMethod" id="paymentMethod">
                    <option selected disabled>Choose payment method</option>
                    @foreach($paymentMethod as $val)
                    <option value="{{$val->value}}">{{$val->label}}</option>
                    @endforeach
              </select>           
          </div>
          <div class="form-group">
              <label>Payment Date</label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="date" name="paymentDate" class="form-control">
                </div>
          </div>
          <div class="form-group">
              <label>Narration</label>
              <input type="name" name="narration" class="form-control" id="input_billNo">
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
    var vName = row.children(".vName").text();
    var billNo = row.children(".billNo").text();
    var amount = row.children(".pending").text();


    // fill the data in the input fields
    $("#input_vName").val(vName);
    $("#input_billNo").val(billNo);
    $("#input_amount").val(amount);
  })
  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})
</script>
@endsection

