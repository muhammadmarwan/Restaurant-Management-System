@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<section class="content">
<div class="card">
              <div class="card-header">
                <h2 class="card-title"><b>PettyCash Payments</b></h2>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th>Amount</th>
                      <th>Debit Account</th>
                      <th>Bill Number</th>
                      <th>Naration</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($pettyCash as $value)
                  <!-- {{$i=0}} -->
                  <!-- {{$i++}} -->
                    <tr>
                       <td>{{$i}}</td>
                       <td>{{$value->voucherDate}}</td>
                       <td>{{$value->amount}}</td>
                       <td>{{$value->debitAccount}}</td>
                       <td>{{$value->bill_no}}</td>
                       <td>{{$value->narration}}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
</section>

@endsection