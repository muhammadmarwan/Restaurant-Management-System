<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="{{ asset('dist/img/newLogo.png') }}">
   <!-- Tell the browser to be responsive to screen width -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('plugins/ionicons/ionicons.min.css') }}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="{{ asset('fonts/googleFont/googleFont.css') }}" rel="stylesheet">
  <script src="{{ asset('plugins/jquery/jquery-3.5.1.js') }}" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

  <style type="text/css">
		#keyboard {
  margin: 0;s
  padding: 0;
  list-style: none;
  display: none;
  }
  .itemCard:hover {
    -webkit-box-shadow: 3px 3px 5px 6px #ccc; 
    -moz-box-shadow:    3px 3px 5px 6px #ccc;
    box-shadow:         3px 3px 5px 6px #ccc;
  }

  #keyboard li {
  -moz-box-shadow: inset 0px 1px 0px 0px #ffffff;
  -webkit-box-shadow: inset 0px 1px 0px 0px #ffffff;
  box-shadow: inset 0px 1px 0px 0px #ffffff;
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ffffff), color-stop(1, #f6f6f6));
  background: -moz-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
  background: -webkit-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
  background: -o-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
  background: -ms-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
  background: linear-gradient(to bottom, #ffffff 5%, #f6f6f6 100%);
  filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#f6f6f6', GradientType=0);
  background-color: #ffffff;
  -moz-border-radius: 6px;
  -webkit-border-radius: 6px;
  border-radius: 6px;
  border: 1px solid #dcdcdc;
  display: inline-block;
  cursor: pointer;
  color: #666666;
  font-family: Arial;
  font-size: 15px;
  font-weight: bold;
  padding: 6px 24px;
  text-decoration: none;
  text-shadow: 0px 1px 0px #ffffff;
}

#keyboard li:hover {
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f6f6f6), color-stop(1, #ffffff));
  background: -moz-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
  background: -webkit-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
  background: -o-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
  background: -ms-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
  background: linear-gradient(to bottom, #f6f6f6 5%, #ffffff 100%);
  filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#f6f6f6', endColorstr='#ffffff', GradientType=0);
  background-color: #f6f6f6;
}

#keyboard li:active {
  position: relative;
  top: 1px;
}
</style>
  <title>POS</title>
  @livewireStyles
</head>
<body>
  <nav class="navbar fixed-top navbar-light bg-light position-absolute">
    <h3>EasyPOS</h3>
    <!-- <a href="{{ Route('storeSalesRestaurant') }}"><button class="btn btn-outline-success" data-toggle="modal" data-target="#saleType">Save & Print</button></a> -->
    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#orderList">Orders</button>
    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#printBill">Print Bill</button>
    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#quickSaleModel">Payment</button>
    <a href="{{ Route('clearItemCart') }}"><button class="btn btn-outline-danger">Clear Cart</button></a>
    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#latestSale">Latest Sales</button>
    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#reports">Reports</button>
    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#debts">Clear Debts</button>
    <a href="{{ Route('drawerOpen') }}">
    <button class="btn btn-outline-danger">Drawer Open</button></a>
    <!-- <a><button class="btn btn-outline-danger">Refresh</button></a> -->
    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#saleClose">Close Sale</button>
    @if(Auth::user()->user_role==3)
    <a href="{{ Route('logout') }}"><button class="btn btn-outline-danger">Log Out</button></a>
    @else
    <a href="/index"><button class="btn btn-outline-danger">Back</button></a>
    @endif
  </ul>
</nav>

<!-- Modal -->  
<div class="modal fade bd-example-modal-sm-b" id="latestSale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <table class="table table-dark">
        <tr>
          <th>Bill No</th>
          <th>Time</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Payment Status</th>
          <th>Action</th>
        </tr>
        @foreach($todaysSale as $sale)
        <tr>
          <td>#{{$sale->bill_no}}</td>
          <td>{{$sale->time}}</td>
          <td>{{$sale->sale_type}}</td>
          <td>AED <B>{{$sale->total_amount}}</B></td>
          @if($sale->payment_status==0)
          <td><p class="text-center" style="color:red"><b>PENDING</b></p></td>
          @else
          <td><p class="text-center" style="color:green"><b>PAID</b></p></td>
          @endif
          <td><a href="{{Route('deleteSales',['id'=>$sale->transaction_id])}}"><button type="button" class="btn btn-danger btn-sm"><b>Remove</b></button></a></td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
<!-- //end--model// -->

<!-- Modal -->  
<div class="modal fade bd-example-modal-sm-b" id="debts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <table class="table table-dark">
        <tr>
          <th>Bill No</th>
          <th>Time</th>
          <th width="50%">Date</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Payment Status</th>
        </tr>
        @foreach($pendingSale as $sale)
        <tr>
          <td>#{{$sale->bill_no}}</td>
          <td>{{$sale->time}}</td>
          <td>{{$sale->date}}</td>
          <td>{{$sale->sale_type}}</td>
          <td>AED <B>{{$sale->total_amount}}</B></td>
          @if($sale->payment_status==0)
          <td><p class="text-center" style="color:red"><b>PENDING</b></p></td>
          @else
          <td><p class="text-center" style="color:green"><b>PAID</b></p></td>
          @endif
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
<!-- //end--model// -->

<!-- Order List -->  
<div class="modal fade bd-example-modal-sm-b" id="orderList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  @widget('order_list')

</div>
<!-- //end--model// -->
<!-- //model for create bill -->
<div class="modal fade" id="printBill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <table class="table table-dark">
      <tr>
        <td><button type="submit" id="dine" data-toggle="modal" data-target="#tableSelect" class="btn btn-primary btn-lg">DINE IN</button></td>
      
        <td><button type="submit" id="take" data-toggle="modal" data-target="#takeAway" class="btn btn-warning btn-lg">TAKE AWAY</button></td>
      
        <td><button type="submit" id="deliveryTab" data-toggle="modal" data-target="#deliveryPrint" class="btn btn-danger btn-lg">DELIVERY</button></td>
      </tr>   
      </table>
    </div>
  </div>
</div>
<!-- endmodel -->

<!-- take away -->
<div class="modal fade bd-example-modal-lg" id="takeAway" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Take Away Sale</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          @foreach($takeAway as $value)
          <div class="col-sm-2 m-2">
          <a href="{{ Route('takeAwaySaleStore',['id'=>$value->token_no]) }}">
            <div class="card card-body card-sm bg-danger itemCard" style="width: 8rem;">
                <small>Token No</small><h4>#{{$value->token_no}}</h4>
                <br>
                <small>Total: {{$value->total_amount}}</small>
            </div>
            </a>
            <p class="text-center"><a href="{{ Route('takeAwayOrderCancel',['tokenNo'=>$value->token_no]) }}">Cancel</a></p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<!-- //Dine Table large model -->
<div class="modal fade bd-example-modal-lg" id="tableSelect" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Select Table</h3>
      </div>
      <div class="modal-body">
        <div class="row">
        @foreach($table as $value)
          <div class="col-sm-2 m-2">
          <a href="{{ Route('customerInvoicePrint',['id'=>$value->table_no]) }}">
            <div class="card card-body card-sm bg-danger itemCard" style="width: 8rem;">
                <small>Table</small> <h4>#{{$value->table_no}}</h4>
                <br>
                @if($value->engaged_status==1)
                <a href="#" class="btn btn-success disabled">Engaged</a>
                @else
                <a href="#" class="btn btn-primary disabled">Free</a>
                @endif
            </div>
            </a>
            <p class="text-center"><a href="{{ Route('customerInvoiceCancel',['tableNo'=>$value->table_no]) }}">Cancel</a></p>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- //delivery Table large model -->
<div class="modal fade bd-example-modal-lg" id="deliveryPrint" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Delivery Sale</h3>
      </div>
      <div class="modal-body">
        <div class="row">
        @foreach($delivery as $value)
          <div class="col-sm-2 m-2">
          <a href="{{Route('deliverySaleStore',['tokenNo'=>$value->token_no])}}">
            <div class="card card-body card-sm bg-danger itemCard" style="width: 8rem;">
                <small>Token No</small><h4>#{{$value->token_no}}</h4>
                <br>
                <small>Customer: </small>{{$value->customer}}
            </div>
            </a>
            <p class="text-center"><a href="{{ Route('deliveryOrderCancel',['tokenNo'=>$value->token_no]) }}">Cancel</a></p>
            </div>
        @endforeach
          </div>
        </div>
      </div>
    </div>
</div>

<!-- modal for reports -->
<div class="modal fade bd-example-modal-sm-a" id="reports" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <table class="table table-dark">
                    <tr>
                        <td><a href="{{Route('restaurantSalesReport',['type'=>'daily'])}}"><button type="button" class="btn btn-primary">
                        Daily Report</button></a></td>
                        <td><a href="{{Route('restaurantSalesReport',['type'=>'weekly'])}}"><button type="button" class="btn btn-primary">
                        Weekly Report</button></a></td>
                        <td><a href="{{Route('restaurantSalesReport',['type'=>'monthly'])}}"><button type="button" class="btn btn-primary">
                        Monthly Report</button></a></td>                        
                    </tr>
                    <tr>
                        <form method="post" action="{{ Route('restaurantSalesReport') }}"> 
                        @csrf   
                        <td colspan="3"><div class="form-group">
                                <label>From Date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" name="fromDate" class="form-control">
                            </div>
                            </div>
                            <div class="form-group">
                                <label>To Date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" name="toDate" class="form-control">
                            </div>
                            </div>
                            <div class="form-group">
                               <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </td>
                        </form>
                    </tr>
                </table>
            </div>
        </div>
    </div>

<!-- Modal For Daily Sale Close -->
<div class="model-keyboard-shotcut modal fade" id="saleClose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Daily Sale Close</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="get" action="{{Route('printReport')}}">
      @csrf
      <div class="card-body">
        <div class="form-group">
            <h5>Todays Sale</h5>
          <div class="my-2">
            <h2 style="color:green;font:12px/30px">{{$total}}</h2>
          </div>
        </div>        
      </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Sale Close</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#cashierChange">Cashier Change</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Modal for cashier change -->
<div class="modal fade" id="cashierChange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Transfer Cash</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="{{ Route('cashierChange') }}">
      @csrf
        <div class="form-group">
          <input type="number" class="form-control" name="amount" placeholder="Enter Drawer Amount">
        </div>
        <div class="form-group">
          <label>Choose Parent Account</label>
          <select class="form-control select2" style="width: 100%;" name="user">
            <option selected disabled>Choose here</option>
            @foreach($cashier as $value)
            <option value="{{$value->user_id}}">{{$value->user_name}} - {{$value->user_id}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Transfer Amount</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- //model for quick Pay// -->
<div class="modal fade bd-example-modal-lg" id="quickSaleModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
@livewire('payment-rest')
</div>



@livewire('sale-rest')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>        
<!-- jQuery -->
<script type="text/javascript">
var curInputBox = null;

function showKeyboard(inputbox) {
$('#keyboard').show();
// inputbox.value = "";
curInputBox = inputbox;
return false;
}

$('#keyboard .char').click(function() {
if (!curInputBox) {
return;
}
var charklicked = $(this).html();
curInputBox.value += charklicked;
});

$('#keyboard .close').click(function() {
$('#keyboard').hide();
});
</script>
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
          $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- ChartJS -->
        <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
        <!-- JQVMap -->
        <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <!-- Summernote -->
        <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('dist/js/adminlte.js') }}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('dist/js/demo.js') }}"></script>
        @livewireScripts
        <!-- <script>
        $('#dine').on("click", function(event) {
        $('#printBill').modal( 'hide' );
        
        });
        $('#take').on("click", function(event) {
        $('#printBill').modal( 'hide' );
        
        });
        $('#deliveryTab').on("click", function(event) {
        $('#printBill').modal( 'hide' );
        
        });
        </script> -->
</body>

</html>