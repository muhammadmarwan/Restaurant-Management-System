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
     <h3 class="card-title">Subsidary Ledger</h3>
  </div>
    <div class="card-body">
        <div class="form-group">
          <form method="post" action="{{ Route('subsidaryLedgerResult') }}">
          @csrf
            <label for="exampleInputEmail1">Select Vendors</label>
                <select class="form-control select2bs4" style="width: 100%;" name="vendorId">
                @foreach($vendors as $val)
                    <option selected disabled>Choose here</option>
                    <option value="{{$val->transaction_id}}">{{$val->name}}</option>
                @endforeach
                </select>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>From Date</label>
                  <div class="form-group">
                    <input type="date" name="fromDate" class="form-control">
                </div>
                </div>
              </div>              
              <div class="col-md-6">
              <label>To Date</label>
                  <div class="form-group">
                    <input type="date" name="toDate" class="form-control">
                </div>
              </div>
             </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
</section>

@endsection