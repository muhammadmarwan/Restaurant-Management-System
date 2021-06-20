<section class="content">
    <div class="container">
      <div class="card-header">
        <h3 class="card-title">Purchase Products</h3>
      </div>
      <div class="card-body">
        <div class="my-2">
          <input type="text" autofocus wire:keyup="InsertoCart" name="" id="" wire:model="product_code" class="form-control" placeholder="Enter Barcode">
        </div>
        <div class="my-2">
          <input list="encodings" value="" wire:keyup="InsertoCart" wire:model="product_name" class="custom-select" placeholder="Enter Product Name">
          <datalist id="encodings">
            @foreach($products as $product)
            <option value="{{$product->product_name}}"></option>
            @endforeach
          </datalist>
        </div>
        <form method="post" action="{{ Route('inventoryProducts') }}">
      @csrf
      @foreach($productInCart as $key => $cart)
          <input type="hidden" name="product_id[]" value="{{$cart->product_id}}">
              
          <input type="hidden" value="{{$cart->product_qty}}">

          <input type="hidden" id="price" value="{{$cart->product_price}}">
               
          <input type="hidden" id="discount">
      @endforeach
        <input type="hidden" name="purchaseId" value="{{$purchaseId}}">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th></th>
              <th width="30%">Product</th>
              <th>Qty</th>
              <th>Unit Price</th>
              <th>Expiry Date</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          @foreach($productInCart as $cart)            
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>
                <input type="text" value="{{$cart->product_name}}" class="form-control">
              </td>
              <td width="15%">
                <input type="number" name="quantity[]" value="{{$cart->quantity}}" class="form-control">
              </td>
              <td>
                <input type="number" name="unitPrice[]" class="form-control" value="{{$cart->unit_price}}">
              </td>
              <td>
                <input type="date" class="form-control"  name="expiryDate[]">
              </td>
              <td>
                <a class="btn btn-sm btn-danger rounded-circle" wire:click.prevent="removeProductCart({{$cart->id}})">
                  <i class="fa fa-times"></i>
                </a>
              </td>
            </tr>   
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
   
  </div>
  </form>
  </div>
  </div>
</section>