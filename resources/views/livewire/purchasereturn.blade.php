<div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title">Purhchase Return</h3>
    <div class="card-tools">
    @if($date)
        <label>Purchase Date : </label>
        <span class="badge badge-light">{{$date}}</span>
    @endif    
    </div>
    </div>
    <div class="card-body">
        <div class="form-group">
          <form method="post" action="{{ Route('purchaseReturnCheck') }}">
          @csrf
            <label for="exampleInputEmail1">Select Vendor</label>
                <select class="form-control vendor" wire:model="selectedVendor" 
                style="width: 100%;" name="vendorId">
                    <option selected value="">Choose here</option>
                    @foreach($vendor as $val)
                    <option value="{{ $val->transaction_id }}">{{ $val->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Purchases</label>
                  <select class="form-control purchase"wire:model="selectedPurchase" style="width: 100%;" name="purchaseId">  
                  <option selected value="">Choose here</option>
                  @foreach($purchase as $val)
                  <option value="{{ $val->transaction_id }}">{{ $val->description}} ({{$val->invoice_no}})</option>
                  @endforeach
                  @foreach($purchaseInventory as $val)
                  <option value="{{ $val->transaction_id }}">{{ $val->description}} ({{$val->invoice_no}})</option>
                  @endforeach
                  </select>
                </div>
              </div> 
              <div class="col-md-4">
                <div class="form-group">
                <label>Amount</label>
                <input type="text" value="{{$amount}}"name="amount" class="form-control" id="exampleInputEmail1" placeholder="Enter Amount">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                <label>Invoice No</label>
                  <input type="text" value="{{$invoiceNo}}" name="invoiceNo" class="form-control" id="exampleInputEmail1" placeholder="Enter Invoice No">
                  </select>
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Date</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="date" name="date" class="form-control">
                    </div>
                </div>
              </div>  
               <div class="col-md-6">
                <label>Narration</label>
                <input type="text" name="narration" class="form-control" id="exampleInputEmail1" placeholder="Enter Narration">
            </div>
            <!-- @if($purchaseProducts!=null)            
            <table class="table">
              <thead>
                <tr>
                  <th>Products</th>
                  <th>Unit</th>
                  <th>Available Qty</th>
                  <th style="width:20%">Return Qty</th>
                <tr>
              <thead>
              <tbody>
                  @foreach($purchaseProducts as $value)
                  <tr>
                    <td>{{$value->product_name}}</td>
                    <td>{{$value->unit}}</td>
                    <td>{{$value->quantity}}</td>
                    <td><input type="text" value="{{$value->quantity}}" name="quantity[]" class="form-control"></td>
                  <tr>
                  @endforeach
              </tbody>
            </table>
            @endif -->
            </div>
            <div class="card-footer">      
             </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
