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
                <h2 class="card-title"><b>Bank Payment History</b></h2>
                <div class="card-tools">
                <div class="card-tools">
                <a href="{{Route('bankHistoryPdf')}}">
                  <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#exampleModal">
                  Export To Pdf</button></a>
                </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Transaction Type</th>
                      <th>Account</th>
                      <th>Bank Account</th>
                      <th>Bill Number</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Narration</th>
                    </tr>

                    @foreach($bankPayment as $value)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$value->transaction_type}}</td>
                      <td>{{$value->accountId}}</td>
                      <td>{{$value->bankAccount}}</td>
                      <td>{{$value->bill_no}}</td>
                      <td><b>{{$value->amount}}</b></td>
                      <td>{{$value->paymentDate}}</td>
                      <td>{{$value->narration}}</td>
                    </tr>
                    @endforeach
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>

</section>

@endsection