<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Payment</h3>
      </div>
    <div class="modal-body">
    <div class="row">
    <div class="col-6">
     <div class="container">
        <div class="row">
            <input type="number" class="form-control text-center" name="tokenNumber" placeholder="Enter Token Number"
            autofocus wire:keyup="CheckBillCode" wire:model="billCode">
        </div>
        <div class="row p-4 m-4">
            <div class="col-12">
                <h1 class="p-2">Total : <b>{{$billAmount}}</b></h1>

                <h2 class="p-2">Return : <b>450</b></h2>

            </div>
        </div>
     </div>
    </div>
    <div class="col-6">
    <div class="row p-2 m-3">
            <span class="radio-item">
                <input type="radio" name="payment_method" id="payment_method" class="true"
                value="cash" checked="checked" style="transform: scale(2);">&nbsp;&nbsp;
                <label for="payment_method"><i class="fa fa-money-bill text-success"></i>Cash</label>
            </span>&nbsp;&nbsp;&nbsp;
            <span class="radio-item">
                <input type="radio" name="payment_method" id="payment_method" class="true"
                value="bank_transfer" style="transform: scale(2);">&nbsp;&nbsp;
                <label for="payment_method"><i class="fa fa-credit-card text-danger"></i>Card</label>
            </span>&nbsp;&nbsp;&nbsp;
            <span class="radio-item">
                <input type="radio" name="payment_method" id="payment_method" class="true"
                value="card" style="transform: scale(2);">&nbsp;&nbsp;
                <label for="payment_method"><i class="fa fa-university text-info"></i>Debtors</label>
            </span>
        </div>
      <form wire:submit.prevent="submit">  
      <input type="number" class="form-control text-center mb-2" name="tokenNumber" placeholder="Enter Paying Amount"
      wire:model="amount" id="code">
      <!-- <input class="text-center form-control mb-2" id="code" wire:keyup="getAmount" wire:modal="amount" name="amount" placeholder="Enter Pay Amount"> -->
    <div class="container">
      <div class="row">
        <div class="card" style="width: 10rem;">
          <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '1';">1</button>
            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '2';">2</button>
            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '3';">3</button>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '4';">4</button>
            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '5';">5</button>
            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '6';">6</button>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '7';">7</button>
            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '8';">8</button>
            <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '9';">9</button>
          </div>
      <div class="btn-group">
        <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value.slice(0, -1);">&lt;</button>
        <button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('code').value=document.getElementById('code').value + '0';">0</button>
        <button type="submit" class="btn btn-primary py-3">Go</button>
        </form>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      <div class="container p-1">
        <div class="row">
            <div class="col text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-success btn-lg btn-block">PAY</button>
            </div>
            </div>
        </div>
      </div>  
    </div>
  </div>
</div>