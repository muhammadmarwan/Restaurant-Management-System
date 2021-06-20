@extends("layouts.admin")

@section("page-content")

<section class="content">
<div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title">Purhchase Entry Edit</h3>
  </div>
    <div class="card-body">
        <div class="form-group">
          <form method="post" action="{{ Route('updatePurchaseEntry') }}">
          @csrf
            <input type="hidden" value="{{$purchase->id}}" name="purchaseId">
            <label for="exampleInputEmail1">Select Vendor</label>
                <select class="form-control select2bs4" style="width: 100%;" name="vendorId">
                    <option selected disabled>Choose here</option>
                    @foreach($vendor as $val)
                    <option {{ $val->value == $purchase->vendor_id ? 'selected':'' }}>{{$val->label}}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Select Debit Account</label>
                  <select class="form-control select2bs4" style="width: 100%;" name="accountId">
                     <option selected disabled>Choose here</option>
                       @foreach($accounts as $val)
                       <option value="{{$val->value}}">{{$val->label}}</option>
                       <option {{ $val->value == $purchase->debit_account_no ? 'selected':'' }}>{{$val->label}}</option>
                       @endforeach
                  </select>
                </div>
              </div>              
            </div>
            <div class="row">
              
              <div class="col-md-12">
                <div class="form-group">
                <label>Invoice No</label>
                  <input type="text" name="invoiceNo" class="form-control" id="exampleInputEmail1" value="{{$purchase->invoice_no}}">
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label>Due Date</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="date" name="due_date" class="form-control" value="{{$purchase->date}}">
                    </div>
                </div>
              </div>
               <div class="col-md-6">
                <label>Purchase Narration</label>
                <input type="text" name="description" class="form-control" id="exampleInputEmail1" value="{{$purchase->description}}">
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                <label>Total Amount</label>
                <input type="text" name="amount" class="form-control" id="exampleInputEmail1" value="{{$purchase->amount}}">
                </div>
            </div>
            </div>
            <div class="card-footer">      
             </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
      </div>
    </div>
</section>

@endsection