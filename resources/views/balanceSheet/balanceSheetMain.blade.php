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
                <h2 class="card-title text-center"><b>Balance Sheet </b> ( {{$date}} )</h2>
                <div class="card-tools">
                <a href="{{ Route('printBalanceSheet',['date'=>$date])}}">
                <button type="button" class="btn btn-block btn-primary">Export to PDF</button>
                </a>
                </div>
                </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                  <tr style="background-color:#dee2e6">
                      <th>ID</th>
                      <th>Account Name</th>
                      <th colspan="2">For The Month ({{$month}})</th>
                      <th colspan="2">Year To Date ({{$year}})</th>
                    </tr>
                    <tr>
                      <th></th>
                      <th></th>
                      <th>Debit</th>
                      <th>Credit</th>
                      <th>Debit</th>
                      <th>Credit</th>
                    </tr>
                  </thead>
                  @foreach($balanceSheet as $value)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                      <td>{{$value->accountName}}</td>
                      <td>{{$value->debit}}</td>
                      <td>{{$value->credit}}</td>
                      <td>{{$value->debitYear}}</td>
                      <td>{{$value->creditYear}}</td>
                    </tr>
                  @endforeach
                  <tr style="background-color:#dee2e6">
                      <td></td>
                      <td><b>Total :</b></td>
                      <td><b>{{$totalDebit}}</b></td>
                      <td><b>{{$totalCredit}}</b></td>
                      <td><b>{{$totalDebitYear}}</b></td>
                      <td><b>{{$totalCreditYear}}</b></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
</section>

@endsection