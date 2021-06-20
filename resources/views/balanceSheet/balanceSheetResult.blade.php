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
                <h2 class="card-title text-center"><b>Balance Sheet </b> ( {{$date}} - {{$endDate}} )</h2>
                <div class="card-tools">
                <a href="{{ Route('printBalanceSheet',['date'=>$date,'type'=>$dateType])}}">
                <button type="button" class="btn btn-block btn-primary">Export to PDF</button>
                </a>
                </div>
                </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-sm text-nowrap">
                  <thead>
                    <tr style="background-color:#dee2e6">
                      <th>Assets</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  @foreach($array as $value)
                  @if($value->account_name=='Assets')
                    <tr>
                      <td>{{$value->accountName}}</td>
                      <td>{{$value->actualAmount}}</td>               
                    </tr>
                  @endif  
                  @endforeach
                  <tr style="background-color:#dee2e6">
                      <td><b>Total</b></td>
                      <td><b>{{$totalAsset}}</b></td>
                  </tr>
                  <tr style="background-color:#dee2e6">
                    <th>Liabilities</th>
                    <th>Amount</th>
                  </tr>
                  @foreach($array as $value)
                  @if($value->account_name=='Liability')
                    <tr>
                      <td>{{$value->accountName}}</td>
                      <td>{{$value->actualAmount}}</td>               
                    </tr>
                  @endif
                  @endforeach
                  <tr style="background-color:#dee2e6">
                    <th>Equity</th>
                    <th>Amount</th>
                  </tr>
                  <tr>
                      <td><strong>{{$product['accountName']}}</strong></td>
                      <td>{{$product['actualAmount']}}</td>               
                  </tr>
                  <tr>
                      <td>{{$product2['accountName']}}</td>
                      <td>{{$product2['actualAmount']}}</td>               
                  </tr>  
                  <tr style="background-color:#dee2e6">
                      <td><b>Total : </b></td>
                      <td><b>{{$totalLiability}}</b></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
</section>

@endsection