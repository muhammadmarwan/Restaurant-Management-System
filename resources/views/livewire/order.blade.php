<div class="row">
  <div class="col-sm-8 col-md-8">
  <div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title">Order Products</h3>
     <div class="card-tools">
     <button accesskey="c" wire:click="ReturnOrder" class="btn btn-danger"data-toggle="modal" data-target="#exampleModal">Return Order</button>
     </div>
  </div>
   <div class="card-body">
        <div class="my-2">
            <input type="text" autofocus wire:keyup="InsertoCart" name="" id="" wire:model="product_code" class="form-control" placeholder="Enter Barcode">
        </div>
        <div class="my-2">
            <input list="encodings" value="" wire:keyup="InsertoCart"wire:model="product_name" class="custom-select" placeholder="Enter Product Name">
            <datalist id="encodings">
            @foreach($products as $product)
                <option value="{{$product->product_name}}"></option>
            @endforeach    
            </datalist>
        </div>
        @if($message!=null)
        <div class="alert alert-success">
        {{$message}}
        </div>
        @endif
        @if(session()->has('success'))
           <div class="alert alert-success">
                {{ session('success') }}
           </div>
        @elseif(session()->has('info'))
            <div class="alert alert-success">
                {{ session('info') }}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error')}}
            </div>
        @endif    
        <table class="table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Disc(%)</th>
                <th>Total</th>
                <th></th>  
            </tr>       
            </thead>
            <tbody class="addMoreProduct">
            @foreach($productInCart as $key => $cart)
            <tr>
                <td>{{$key + 1}}</td>
                <td width="30%">
                    <input type="text" readonly value="{{$cart->product_name}}" class="form-control">
                </td>
                <td width="15%">
                    <div class="row">
                        <div class="col-md-3">
                          @if($rowCount==$cart->id)
                            <label for="">{{$count}}</label>
                          @else
                            <label for="">{{$cart->product_qty}}</label>
                          @endif
                        </div>
                        &nbsp;&nbsp;
                        <div>
                            <button class="btn btn-sm btn-success" 
                            wire:click="IncrementQty({{$cart->id}})"> + </button>
                            <button class="btn btn-sm btn-danger"
                            wire:click="DecrementQty({{$cart->id}})"> - </button>
                        </div>    
                    </div>
                    <!-- <input type="number" name="quantity[]" id="quantity" class="form-control quantity" value="{{$cart->product_qty}}"> -->
                </td>
                <td>
                    <input type="number" readonly class="form-control" value="{{$cart->product_price}}">
                </td>
                <td>
                    <input type="number" size="2" maxlength="2" class="form-control" wire:model="disc" wire:keydown.enter="DiscountCalculate({{$cart->id}})">
                </td>
                <td>
                    @if($rowCount==$cart->id)
                        <input type="number" readonly class="form-control" value="{{$totalAmount}}">
                    @else
                        <input type="number" readonly class="form-control" value="{{$cart->price_total}}">
                    @endif
                </td>
                <td>
                    <a href="" class="btn btn-sm btn-danger rounded-circle" wire:click.prevent="removeProductCart({{$cart->id}})">
                    <i class="fa fa-times"></i></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
   </div>
  </div>
  </div>
  <div class="col-sm-4 col-md-4">
  <div class="card card-primary">
  <div class="card-header">
  <form method="post" action="{{ Route('storeSales') }}">
  @csrf
  @foreach($productInCart as $key => $cart)
                    <input type="hidden" name="product_id[]" value="{{$cart->product_id}}">
              
                    <input type="hidden" name="quantity[]" value="{{$cart->product_qty}}">

                    <input type="hidden" name="price[]" id="price" value="{{$cart->product_price}}">
               
                    <input type="hidden" name="discount[]" id="discount">

                    <input type="hidden" name="total_amount[]" id="total_amount" value="{{$cart->price_total}}">
            @endforeach
     <h3 class="card-title">Total <b class="total">
     {{$grandTotal}}
     </b></h3>
      </div>
      <div class="card-body">
      <div class="btn-group">
        <button type="button" onclick="PrintReceiptFuction('print')" class="btn btn-dark">
        <i class="fa fa-print"></i>Print
        </button>
        <button accesskey ="p" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm-b">
        <i class="fa fa-print"></i>History
        </button>
        <button accesskey="m" type="button" class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-sm-a">
        <i class="fa fa-print"></i>Report
        </button>
        <button accesskey="s" type="button" class="btn btn-success" data-toggle="modal" data-target=".model-keyboard-shotcut">
        <i class="fa fa-print"></i> <br>Close Sale
        </button>
      </div>
      <!-- model for reports -->
      <!-- Small modal -->

    
        <!-- //// -->
        <div class="panel">
            <div class="row">
                <table class="table table-striped">
                    <tr>
                        <td>
                            <label for="">Customer Name</label>
                            <input type="text" name="customer_name" id="" class="form-control">
                        </td>
                        <td>
                            <label for="">Phone</label>
                            <input type="number" name="customer_phone" id="" class="form-control">
                        </td>
                    </tr>
                </table>
                </div>
                <div class="row">
                <label>Payment Method</label>
                </div>
                <div class="row">
                    <td>
                        <span class="radio-item">
                            <input type="radio" name="payment_method" id="payment_method" class="true"
                            value="cash" checked="checked">
                            <label for="payment_method"><i class="fa fa-money-bill text-success"></i>Cash</label>
                        </span>&nbsp;&nbsp;
                        <span class="radio-item">
                            <input type="radio" name="payment_method" id="payment_method" class="true"
                            value="bank_transfer">
                            <label for="payment_method"><i class="fa fa-university text-danger"></i>Bank Transfer</label>
                        </span>&nbsp;&nbsp;
                        <span class="radio-item">
                            <input type="radio" name="payment_method" id="payment_method" class="true"
                            value="card">
                            <label for="payment_method"><i class="fa fa-credit-card text-info"></i>Card</label>
                        </span>&nbsp;&nbsp;
                    </td><br>
                    </div>
                    <div class="row">
                    <td>
                        Payment
                        <input type="number" wire:model="pay_money" name="paid_amount" id="paid_amount" class="form-control">
                    </td>
                    <td>
                        Returning Cash
                        @if($pay_money!=null)
                        <input type="number" readonly  wire:model="balance" name="balance" id="balance" class="form-control">
                        @else
                        <input type="number" readonly name="balance" id="balance" class="form-control">
                        @endif
                    </td>
                    <td>
                        <button type="submit" class="btn-primary btn-block mt-3">Save</button>
                    </td>
                    <td>
                        <button class="btn-danger btn-block mt-3">Save</button>
                    </td>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- model -->
<div class="modal fade bd-example-modal-sm-a" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <table class="table table-dark">
                    <tr>
                        <td><a href="{{Route('salesReport',['type'=>'daily'])}}"><button type="button" class="btn btn-primary">
                        Daily Report</button></a></td>
                        <td><a href="{{Route('salesReport',['type'=>'weekly'])}}"><button type="button" class="btn btn-primary">
                        Weekly Report</button></a></td>
                        <td><a href="{{Route('salesReport',['type'=>'monthly'])}}"><button type="button" class="btn btn-primary">
                        Monthly Report</button></a></td>                        
                    </tr>
                    <tr>
                        <form method="post" action="{{ Route('salesReport') }}"> 
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

    <!-- //model for todaysales -->
      <div class="modal fade bd-example-modal-sm-b" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <card>
                <table class="table table-dark">
                  <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Time</th>
                    <th scope="col">Method</th>
                    <th scope="col">Amount</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($todaySales as $sales)
                <tr>
                  <th scope="row">{{$loop->iteration}}</th>
                  <td>{{$sales->name}}</td>
                  <td>{{$sales->time}}</td>
                  <td>{{$sales->payment_method}}</td>
                  <td>{{$sales->paid_amount - $sales->balance}}</td>
                </tr>
                @endforeach
                </tbody>
                </table>
                </card>
            </div>
        </div>
       </div>

<!-- Modal For Daily Sale Close -->
<div class="model-keyboard-shotcut modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Daily Sale Close</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="get" action="{{ Route('dailySaleClose') }}">
      @csrf
      <div class="card-body">
        <div class="form-group">
            <h5>Todays Sale</h5>
          <div class="my-2">
            <h2 style="color:green;font:12px/30px">{{$closeSale}}</h2>
          </div>
        </div>        
      </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Sale Close</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
      </div>
    </div>
    </form>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#exampleModal').on('shown.bs.modal', function() {
    $('#myInput').trigger('focus');
  });
});
</script>