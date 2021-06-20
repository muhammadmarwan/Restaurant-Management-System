<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Trial Balance</title>
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
                                    <span class="">Trial Balance</span>
                                </h2>
                            </td>
                            <td class="text-right">
                                <strong>Date: {{$today}}</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br><br>
            
            <br><br>
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-condensed table-sm table-hover">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>Running Balance</th>
                      <th>{{$sumDebitYear1 + $sumDebitYear2}}</th>
                    </tr>
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