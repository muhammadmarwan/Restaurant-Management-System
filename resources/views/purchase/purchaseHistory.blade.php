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
                <h2 class="card-title"><b>Purchase History</b></h2>
                <div class="card-tools">
                  <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#exportModel" id="exportBtn">
                  Export To Pdf</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Vendor Name</th>
                      <th>Purchase Type</th>
                      <th>Amount</th>
                      <th>Invoice No</th>
                      <th>Bill No</th>
                      <th>Due Date</th>
                      <th colspan="2"></th> 
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($history as $val)
                    <tr class="data-row">
                      <td>{{$loop->iteration}}</td>
                      <td>{{$val->vendorName}}</td>
                      <td>{{$val->type}}</td>
                      <td>{{$val->amount}}</td>
                      <td>{{$val->invoice_no}}</td>
                      <td>{{$val->bill_no}}</td>
                      <td>{{$val->due_date}}</td>
                      <td>
                        <a href="{{ Route('viewDetails',['id'=>$val->transaction_id])}}">
                        <button type="button" class="btn btn-sm bg-gradient-success">More</button></a>
                        <a href="{{ Route('printPurchaseBill',['date'=>$val->transaction_id])}}">
                        <button type="button" class="btn btn-sm bg-gradient-primary">Print</button></a>
                        <button type="button" id="delete" data-toggle="modal" data-id="{{$val->transaction_id}}" 
                        data-target="#exampleModal" class="btn btn-sm bg-gradient-danger">Delete</button>
                      </td>  
                      <!-- &nbsp;&nbsp;<a href="{{ Route('editPurchase',['id'=>$val->transaction_id]) }}" id="edit-item">
                      <i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                    </tr>
                    @endforeach
                  </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal For Delete -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <form method="post" action="{{ Route('deletePurchaseEntry') }}"> 
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

<!-- Modal -->
<div class="modal fade" id="exportModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form method="post" action="{{Route('printPurchaseHistory')}}">
        @csrf
          <div class="form-group">
            <label>From Date</label>
            <input type="date" name="from" class="form-control">   
          </div>
          <div class="form-group">
            <label>To Date</label>
            <input type="date" name="to" class="form-control">   
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="expBtn" class="btn btn-primary">Export</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).on("click", "#delete", function () {
     var myBookId = $(this).data('id');
     $("#input_type").val( myBookId );
     // it is unnecessary to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});

// $('#expBtn').click(function() {
//      $("#exportModel").hide();
// });

</script>
@endsection