<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Profit And Loss</title>
    <style>
        body{
            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace !important;
            letter-spacing: -0.3px;
        }
        .invoice-wrapper{ width: 700px; margin: auto; }
        .nav-sidebar .nav-header:not(:first-of-type){ padding: 1.7rem 0rem .5rem; }
        .logo{ font-size: 50px; }
        .sidebar-collapse .brand-link .brand-image{ margin-top: -33px; }
        .content-wrapper{ margin: auto !important; }
        .billing-company-image { width: 50px; }
        .billing_name { text-transform: uppercase; }
        .billing_address { text-transform: capitalize; }
        .table{ width: 100%; border-collapse: collapse; }
        th{ text-align: left; padding: 10px; }
        td{ padding: 10px; vertical-align: top; }
        .row{ display: block; clear: both; }
        .text-right{ text-align: right; }
        .table-hover thead tr{ background: #eee; }
        .table-hover tbody tr:nth-child(even){ background: #fbf9f9; }
        address{ font-style: normal; }
    </style>
</head>
<body>
    <div class="row invoice-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <tr>
                            <td>
                                <h2>
                                    <span class="">Profit And Loss - {{$date}}</span>
                                </h2>
                            </td>
                            <td class="text-right">
                                <small>Date: {{$today}}</small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br><br>
            
            <br><br>
            <div class="row">
                <div class="col-12 table-responsive">
                <table class="table table-hover table-sm text-nowrap">
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
                <!-- /.col -->
            </div>
            <br><br><br>
            <div>
                <small><small>NOTE: This is system generate invoice no need of signature</small></small>
            </div>
        </div>
    </div>    
</body>
</html>