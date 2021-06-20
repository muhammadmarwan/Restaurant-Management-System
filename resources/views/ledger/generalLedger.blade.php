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
     <h3 class="card-title">General Ledger</h3>
  </div>
    <div class="card-body">
        <div class="form-group">
          <form method="post" action="{{ Route('generalLedgerResult') }}">
          @csrf
            <label for="exampleInputEmail1">Select Account</label>
                <select class="form-control select2bs4" style="width: 100%;" name="accountId">
                    <option selected disabled>Choose here</option>
                @foreach($accounts as $val)
                    <option value="{{$val->value}}">{{$val->label}}</option>
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