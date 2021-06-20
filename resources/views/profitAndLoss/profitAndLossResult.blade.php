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
                <h2 class="card-title"><b>Profit And Loss ({{$date}})</b></h2>
                <div class="card-tools">
                <a href="{{ Route('printProfitAndLoss',['date'=>$date])}}">
                <button type="button" class="btn btn-block btn-primary">Export to PDF</button>
                </a>
                </div>
                </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-sm">
                  <thead>
                  <tr style="background-color:#dee2e6">
                      <th>ID</th>
                      <th>Account Name</th>
                      <th colspan="2">For The Month ({{$month}})</th>
                      <th colspan="2">Year To Date ({{$year}})</th>
                    </tr>
                    <tr>
                      <th></th>
                      <th>Income</th>
                      <th>Credit</th>
                      <th>Debit</th>
                      <th>Credit</th>
                      <th>Debit</th>
                    </tr>
                  </thead>
                  @foreach($profitAndLoss as $value)
                    @if($value->type=='Income')
                    <tr>
                    <td>{{$loop->iteration}}</td>
                      <td>{{$value->accountName}}</td>
                      <td>{{$value->credit}}</td>
                      <td>{{$value->debit}}</td>
                      <td>{{$value->creditYear}}</td>
                      <td>{{$value->debitYear}}</td>
                    </tr>
                    @endif
                  @endforeach
                  <tr style="background-color:#dee2e6">
                      <td></td>
                      <td><b>Total Income :</b></td>
                      <td colspan="2"><b>{{$sumCreditIncome}}</b></td>
                      <td colspan="2"><b>{{$sumCreditYearIncome}}</b></td>
                    </tr>
                  <tr>
                      <th></th>
                      <th>Expense</th>
                      <th>Credit</th>
                      <th>Debit</th>
                      <th>Credit</th>
                      <th>Debit</th>
                    </tr>
                  @foreach($profitAndLoss as $value)
                    @if($value->type=='Expenditure')
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$value->accountName}}</td>
                    <td>{{$value->credit}}</td>
                      <td>{{$value->debit}}</td>
                      <td>{{$value->creditYear}}</td>
                      <td>{{$value->debitYear}}</td>
                    </tr>
                    @endif
                  @endforeach
                  <tr style="background-color:#dee2e6">
                      <td></td>
                      <td><b>Total Expense :</b></td>
                      <td colspan="2"><b>{{$sumDebitExpense}}</b></td>
                      <td colspan="2"><b>{{$sumDebitYearExpense}}</b></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><b>Profit And Loss : </b></td>
                      <td><b>{{$result}} - {{$resultAmount}}</b></td>
                      <td></td>
                      <td><b>{{$resultYear}} - {{$resultAmountYear}}</b></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
</section>

@endsection