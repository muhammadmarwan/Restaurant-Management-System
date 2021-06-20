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
                <h2 class="card-title"><b>Trial Balance</b></h2>
                <div class="card-tools">
                <a href="{{ Route('printTrialBalance',['date'=>$date])}}">
                <button type="button" class="btn btn-block btn-primary">Export to PDF</button>
                </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
              
                <table class="table table-hover table-sm text-nowrap">
                  <thead>
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><B>Running Balance : {{$sumCreditYear1 + $sumCreditYear2}}</B></td>
                    </tr>
                  </thead>
                 </table> 
                <table class="table table-hover table-sm text-nowrap">
                  <thead>
                    <tr style="background-color:#dee2e6">
                      <th>ID</th>
                      <th>Account Name</th>
                      <th colspan="2">For The Month</th>
                      <th colspan="2">Year To Date</th>
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
                  @foreach($result1 as $value)
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
                      <td><b>{{$sumDebit1}}</b></td>
                      <td><b>{{$sumCredit1}}</b></td>
                      <td><b>{{$sumDebitYear1}}</b></td>
                      <td><b>{{$sumCreditYear1}}</b></td>
                    </tr>
                    @foreach($result2 as $value)
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
                       <td><b>{{$sumDebit2}}</b></td>
                       <td><b>{{$sumCredit2}}</b></td>
                       <td><b>{{$sumDebitYear2}}</b></td>
                       <td><b>{{$sumCreditYear2}}</b></td>
                     </tr>
                     <tr style = "background-color: #f2f2f2">
                        <td></td>
                        <td><b>Grand Total :</b></td>
                        <td><b>{{$sumDebit1 + $sumDebit2}}</b></td>
                        <td><b>{{$sumCredit1 + $sumCredit2}}</b></td>
                        <td><b>{{$sumDebitYear1 + $sumDebitYear2}}</b></td>
                        <td><b>{{$sumCreditYear1 + $sumCreditYear2}}</b></td>
                      </tr>
                  </tbody>
                </table>
              </div>
          </div>
</section>

@endsection