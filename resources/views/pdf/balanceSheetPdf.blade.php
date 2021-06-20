<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Balance Sheet</title>
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
                                    <span class="">Balance Sheet  <br>({{$date}}-{{$endDate}})</span>
                                </h2>
                            </td>
                            <td class="text-right">
                                <small>Date: {{$today}}</small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 table-responsive">
                <table class="table table-bordered table-sm text-nowrap">
                  <thead>
                  <tr style="background-color:#dee2e6">
                      <th>Assets</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  @foreach($assets as $value)
                    <tr>
                      <td>{{$value->accountName}}</td>
                      <td>{{$value->actualAmount}}</td>               
                    </tr>
                  @endforeach
                  <tr style="background-color:#dee2e6">
                      <td><b>Total</b></td>
                      <td><b>{{$totalAsset}}</b></td>
                  </tr>
                  <tr style="background-color:#dee2e6">
                    <th>Liabilities</th>
                    <th>Amount</th>
                  </tr>
                  @foreach($liabilities as $value)
                    <tr>
                      <td>{{$value->accountName}}</td>
                      <td>{{$value->actualAmount}}</td>               
                    </tr>
                  @endforeach
                  <tr style="background-color:#dee2e6">
                      <td><b>Total : </b></td>
                      <td><b>{{$totalLiability}}</b></td>
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