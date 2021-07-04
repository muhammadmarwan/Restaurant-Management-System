  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Payment</h3>
        <h1 style="color:green;">Drawer Cash : <b>{{$cashAmount}}</b></h1>
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" 
        data-target="#updateCash">Update Cash</button>
      </div>
    <div class="modal-body">
    <div class="row">
    <div class="col-6">
     <div class="container">
        <div class="row">
            <select class="form-control text-center" name="tokenNumber" placeholder="Enter Token Number Or Barcode"
              wire:model="billCode">
              <option selected >---------------------------Select Bill----------------------------------</option>
            @foreach($saleDataList as $val)
              @if($val->sale_type=='DINE IN')
              <option label="{{$val->data}} (Table No : {{$val->table_no}})" value="{{$val->bill_no}}">
              @else
              <option label="{{$val->data}}" value="{{$val->bill_no}}">
              @endif
            @endforeach 
            </select>
        </div>
        <div class="row p-1">
        <div class="col-12">
            <div class="card card-body text-center"  style="background:#f7cac9">
              <h5>TOTAL</h5>
              <h1><b>{{$billAmount}}</b></h1>
              @if($billAmount >= 5)
              <small>Include 5% Tax</small>
              @endif
            </div>
          </div>
        </div>
        <div class="row p-1">
        <div class="col-12">
            <div class="card card-body text-center"  style="background:#f7cac9">
              <h5>PAID</h5>
              <h4><b>{{$payAmount}}</b></h4>
            </div>
          </div>
        </div>
        <div class="row p-1">
          <div class="col-md-12">
            <div class="card card-body text-center" style="background:#d5f4e6">
              <h5>RETURN</h5><br>
              <h4><b>{{$returnAmount}}</b></h4>
            </div>
          </div>
        </div>  
     </div>
    </div>
    <div class="col-6">
    <div class="container">
      <label>Discounts</label><br>
      @if($discount==5)
      <button type="button" class="btn btn-success" wire:click="discount({{$id='5'}})">5%</button>
      @else
      <button type="button" class="btn btn-warning" wire:click="discount({{$id='5'}})">5%</button>
      @endif
      @if($discount==10)
      <button type="button" class="btn btn-success" wire:click="discount({{$id='10'}})">10%</button>
      @else
      <button type="button" class="btn btn-warning" wire:click="discount({{$id='10'}})">10%</button>
      @endif
      @if($discount==15)
      <button type="button" class="btn btn-success" wire:click="discount({{$id='15'}})">15%</button>
      @else
      <button type="button" class="btn btn-warning" wire:click="discount({{$id='15'}})">15%</button>
      @endif 
      @if($discount==20)     
      <button type="button" class="btn btn-success" wire:click="discount({{$id='20'}})">20%</button>
      @else
      <button type="button" class="btn btn-warning" wire:click="discount({{$id='20'}})">20%</button>
      @endif
      @if($discount==25)     
      <button type="button" class="btn btn-success" wire:click="discount({{$id='25'}})">25%</button>
      @else
      <button type="button" class="btn btn-warning" wire:click="discount({{$id='25'}})">25%</button>
      @endif
      @if($discount==30)
      <button type="button" class="btn btn-success" wire:click="discount({{$id='30'}})">30%</button>
      @else
      <button type="button" class="btn btn-warning" wire:click="discount({{$id='30'}})">30%</button>
      @endif
    </div>
    <div class="row  m-2">
    <label>Payment Method</label><br>
      <div class="container">
            <span class="radio-item">
                <input type="radio" name="payment_method" id="payment_method" class="true"
                value="cash" checked="checked" style="transform: scale(2);"
                wire:click="paymentMethod('cash')">&nbsp;&nbsp;
                <label for="payment_method"><i class="fa fa-money-bill text-success"></i>Cash</label>
            </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="radio-item">
                <input type="radio" name="payment_method" id="payment_method" class="true"
                value="bank_transfer" style="transform: scale(2);" 
                wire:click="paymentMethod('card')">&nbsp;&nbsp;
                <label for="payment_method"><i class="fa fa-credit-card text-danger"></i>Card</label>
            </span>
        </div>
      </div>  
      <input type="number" readonly class="form-control text-center mb-2" name="tokenNumber" placeholder="Enter Paying Amount"
      value="{{$payAmount}}">
      <!-- <input class="text-center form-control mb-2" id="code" wire:keyup="getAmount" wire:modal="amount" name="amount" placeholder="Enter Pay Amount"> -->
    <div class="container">
      <div class="row p-2">
        <div class="col-6">
        <div class="card" style="width: 10rem;">
          <div class="btn-group">
          <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{1}})">1</button>
            <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{2}})">2</button>
            <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{3}})">3</button>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{4}})">4</button>
            <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{5}})">5</button>
            <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{6}})">6</button>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{7}})">7</button>
            <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{8}})">8</button>
            <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{9}})">9</button>
          </div>
      <div class="btn-group">
      <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard('.')">.</button>
        <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{0}})">0</button>
        <button type="button" class="btn btn-outline-secondary py-3" wire:click="keyBoard({{90}})"><</button> 

      </div>
      </div>
      </div>
      <div class="col-6 text-center bg-success itemCard" style="border-radius: 10px;" wire:click="payBill">
        <div style="padding: 70px 0;text-align: center;">
          <h1 class="p-8 m-3"><b>PAY</b></h1>
        </div>
      </div>
      </div>
      </div>
      </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateCash" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Cash Drawer Amount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{Route('cashUpdate')}}">
      @csrf
      <div class="modal-body">
        <input type="number" name="cash" class="form-control" value="{{$cashAmount}}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>