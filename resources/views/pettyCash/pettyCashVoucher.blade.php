@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@if(count($errors))
            <div class="form-group">
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
@endif

<section class="content">
<div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title">PettyCash Voucher</h3>
  </div>
    <div class="card-body">
      <form method="post" action="{{ Route('pettyCashVoucherStore') }}">
        @csrf
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
                <div class="form-group">
                <label>Amount</label>
                <input type="text" name="amount" class="form-control" id="exampleInputEmail1" placeholder="Enter Amount">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Bill Number</label>
                  <input type="text" name="billNo" class="form-control" id="exampleInputEmail1" placeholder="Enter Bill Number">
                  </select>
                </div>
              </div> 
              <div class="col-md-6">
              <div class="form-group">
                <label>Narration</label>
                  <input type="text" name="narration" class="form-control" id="exampleInputEmail1" placeholder="Enter Narration">
                  </select>
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                  <label>Select Account</label>
                  <select class="form-control select2bs4" style="width: 100%;" name="accountId">
                     <option selected disabled>Choose here</option>
                       @foreach($accounts as $val)
                       <option value="{{$val->value}}">{{$val->label}}</option>
                       @endforeach
                  </select>
                </div>
              </div>              
            </div>               
            <div class="card-footer">      
             </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
</section>

@endsection