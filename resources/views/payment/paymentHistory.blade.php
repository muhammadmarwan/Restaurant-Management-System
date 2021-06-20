@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<section class="content">
<div class="card">
              <div class="card-header">
                <h2 class="card-title"><b>Payment History</b></h2>
                <div class="card-tools">
                   <input type="text" name="search" id="search" class="form-control" placeholder="Search User Data" />
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Payment Method</th>
                      <th>Vendor</th>
                      <th>Amount</th>
                      <th>Bill No</th>
                      <th>Paid Date</th>
                      <th>Print</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
  </section>

<script>
$(document).ready(function(){

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ route('paymentHistorySearch') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>

@endsection

