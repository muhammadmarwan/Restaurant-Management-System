<div class="row">
  <div class="col-sm-8 col-md-8">
  <div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title">Return Products</h3>
     <div class="card-tools">
     </div>
  </div>
   <div class="card-body">
        <div class="my-2">
        @if($cartCount==0)
            <input type="text" autofocus wire:keyup="ListBill" name="" id="" wire:model="bill_code" class="form-control" placeholder="Enter Bill Barcode">
        @endif
        @if($cartCount!=0)  
            <input type="text" readonly class="form-control">
        @endif
        </div>          
        <table class="table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Disc(%)</th>
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
                            <label for="">{{$cart->product_qty}}</label>
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
                    <input type="number" size="2" maxlength="2" class="form-control" wire:model="disc" wire:keydown.enter="DiscountCalculate({{$cart->id}})">
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
  <form method="post" action="{{ Route('storeSales') }}">
  @csrf
  @foreach($productInCart as $key => $cart)
                    <input type="hidden" name="product_id[]" value="{{$cart->product_id}}">
              
                    <input type="hidden" name="quantity[]" value="{{$cart->product_qty}}">

                    <input type="hidden" name="price[]" id="price" value="{{$cart->product_price}}">
               
                    <input type="hidden" name="discount[]" id="discount">

                    <input type="hidden" name="total_amount[]" id="total_amount" value="{{$cart->price_total}}">
            @endforeach
     <h3 class="card-title">Total <b class="total">{{$productInCart->sum('price_total')}}</b></h3>
      </div>
      <!-- //hidden input types -->
      <form method="post" action="{{ Route('storeSales') }}">
        @csrf
        @foreach($productInCart as $key => $cart)
            <input type="hidden" name="product_id[]" value="{{$cart->product_id}}">
            <input type="hidden" name="quantity[]" value="{{$cart->product_qty}}">
            <input type="hidden" name="price[]" id="price" value="{{$cart->product_price}}">
            <input type="hidden" name="total_amount[]" id="total_amount" value="{{$cart->price_total}}">
            @endforeach
      <!-- //end hidden input -->
      <div class="card-body">
        <div class="panel">
            <div class="row">
                <table class="table table-striped">
                    <tr>
                        <td>
                            @if($customerDetails!=null)
                            <label for="">Customer Name</label>
                            <input value="{{$customerDetails->name}}" type="text" name="customer_name" id="" class="form-control">
                            @endif
                        </td>
                        <td>
                            @if($customerDetails!=null)
                            <label for="">Customer Phone</label>
                            <input value="{{$customerDetails->phone}}" type="number" name="customer_phone" id="" class="form-control">
                            @endif
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
                        @if($customerDetails!=null && $customerDetails->payment_method == 'cash')
                            <input type="radio" name="payment_method" id="payment_method" class="true"
                            value="cash" checked="checked">
                        @else
                            <input type="radio" name="payment_method" id="payment_method" class="true"
                            value="cash">
                        @endif
                        <label for="payment_method"><i class="fa fa-money-bill text-success"></i>Cash</label>
                        </span>&nbsp;&nbsp;
                        <span class="radio-item">
                        @if($customerDetails!=null && $customerDetails->payment_method == 'bank')
                            <input type="radio" name="payment_method" id="payment_method" class="true"
                            value="bank" checked="checked">
                        @else
                            <input type="radio" name="payment_method" id="payment_method" class="true"
                            value="bank">
                        @endif
                            <label for="payment_method"><i class="fa fa-university text-danger"></i>Bank Transfer</label>
                        </span>&nbsp;&nbsp;
                        <span class="radio-item">
                        @if($customerDetails!=null && $customerDetails->payment_method == 'card')
                            <input type="radio" name="payment_method" id="payment_method" class="true"
                            value="card" checked="checked">
                        @else
                            <input type="radio" name="payment_method" id="payment_method" class="true"
                            value="card">
                        @endif    
                            <label for="payment_method"><i class="fa fa-credit-card text-info"></i>Card</label>
                        </span>&nbsp;&nbsp;
                    </td><br>
                    </div>
                    <div class="row">
                    <td>
                        Paid Amount
                        @if($customerDetails!=null)
                        <input type="number" value="{{$customerDetails->paid_amount - $customerDetails->balance}}" name="paid_amount" id="paid_amount" class="form-control">
                        @else
                        <input type="number" name="paid_amount" id="paid_amount" class="form-control">
                        @endif
                    </td>
                    <td>
                        Returning Cash
                        @if($customerDetails!=null)
                        <input type="number" value="{{$customerDetails->paid_amount - $customerDetails->balance - $productInCart->sum('price_total')}}" readonly name="balance" id="balance" class="form-control">
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


