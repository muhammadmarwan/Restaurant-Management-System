<div class="row">
  <div class="col-sm-8 col-md-8">
  <div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title">Return Products</h3> 
  </div>
   <div class="card-body">
        <div class="my-2">
        @if($cartCount==0)
            <input type="text" autofocus wire:keyup="InsertoCart" name="" id="" wire:model="bill_code" class="form-control" placeholder="Enter Barcode">
        @elseif($cartCount!=0)
            <input type="text" readonly wire:keyup="InsertoCart" name="" id="" wire:model="bill_code" class="form-control" placeholder="Enter Barcode">
        @endif
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
                <th>Total</th>
                <th><a href="#" class="btn btn-sm btn-success rounded-circle add_more"><i class="fa fa-plus"></i></a></th>  
            </tr>       
            </thead>
            <tbody class="addMoreProduct">
            @foreach($productInCart as $key => $cart)
            <tr>
                <td>{{$key + 1}}</td>
                <td>
                    <input type="text" value="{{$cart->product_name}}" class="form-control">
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
                            wire:click.prevent="IncrementQty({{$cart->id}})"> + </button>
                            <button class="btn btn-sm btn-danger"
                            wire:click.prevent="DecrementQty({{$cart->id}})"> - </button>
                        </div>    
                    </div>
                    <!-- <input type="number" name="quantity[]" id="quantity" class="form-control quantity" value="{{$cart->product_qty}}"> -->
                </td>
                <td>
                    <input type="number"class="form-control" value="{{$cart->product_price}}">
                </td>
                <td>
                    <input type="number" class="form-control" value="{{$cart->price_total}}">
                </td>
                <td>
                    <a href="" class="btn btn-sm btn-danger rounded-circle delete">
                    <i class="fa fa-times" wire:click="removeProductCart({{$cart->id}})"></i></a>
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
  <form method="post" action="{{ Route('storeSalesReturn') }}">
  @csrf
  @foreach($productInCart as $key => $cart)
                    <input type="hidden" name="product_id[]" value="{{$cart->product_id}}">
              
                    <input type="hidden" name="quantity[]" value="{{$cart->product_qty}}">

                    <input type="hidden" name="price[]" id="price" value="{{$cart->product_price}}">
               
                    <input type="hidden" name="total_amount[]" id="total_amount" value="{{$cart->price_total}}">
            @endforeach
     <h3 class="card-title">Total <b class="total">{{$productInCart->sum('price_total')}}</b></h3>
      </div>
      <div class="card-body">
        <div class="panel">
            <div class="row">
                <table class="table table-striped">
                    <input type="hidden" name="bill_no" @if(isset($customers)) value="{{$customers->barcode}}" @endif>
                    <input type="hidden" name="order_id" @if(isset($customers)) value="{{$customers->id}}" @endif>
                    <tr>
                        <td>
                            <label for="">Customer Name</label>
                            <input type="text" readonly @if(isset($customers)) value="{{$customers->name}}" @endif name="customer_name" id="" class="form-control">
                        </td>
                        <td>
                            <label for="">Phone</label>
                            <input type="number" readonly @if(isset($customers)) value="{{$customers->phone}}" @endif name="customer_phone" id="" class="form-control">
                        </td>
                    </tr>
                </table>
                </div>
                <div class="row">
                </div>
                    <div class="row">
                    <td>
                        Paid Amount
                        @if(isset($orderDetails))
                        <input type="number" readonly value="{{$orderDetails->paid_amount - $orderDetails->balance}}" name="paid_amount" id="paid_amount" class="form-control">
                        @else
                        <input type="number" readonly name="paid_amount" id="paid_amount" class="form-control">
                        @endif
                    </td>
                    <td>
                        Returning Cash
                        @if(isset($orderDetails))
                        <input type="number" value="{{$orderDetails->paid_amount - $orderDetails->balance - $productInCart->sum('price_total')}}" readonly name="return_amount" id="balance" class="form-control">
                        @else
                        <input type="number" readonly name="return_amount" id="balance" class="form-control">
                        @endif
                    </td>
                    <td>
                        <button type="submit" class="btn-primary btn-block mt-3">Submit</button>
                    </td>
                    <td>
                        <button type="button" class="btn-danger btn-block mt-3" wire:click.prevent="ClearCart">Cancel</button>
                    </td>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function() {
  $('#exampleModal').on('shown.bs.modal', function() {
    $('#myInput').trigger('focus');
  });
});
</script>