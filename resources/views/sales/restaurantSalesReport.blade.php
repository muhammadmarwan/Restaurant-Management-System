<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Sales Report</title>
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
        .table{ width: 100%; border-collapse: collapse;}
        th{ text-align: left; padding: 10px; }
        td{ padding: 10px; vertical-align: top;}
        .tb1{ border: 1px solid #dddddd; }
        .row{ display: block; clear: both;  }
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
                                    <span style="text-transform: uppercase;">{{$type}} Sales Report</span><br>
                                    @if($type=='daily')
                                    <p>({{$today}})</p>
                                    @elseif($type=='weekly')
                                    <p>({{$from}}-{{$to}})</p>
                                    @elseif($type=='monthly')
                                    <p><b>({{$month}})</b></p>
                                    @else
                                    <p>({{$from}}-{{$to}})</p>
                                    @endif
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
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th class="tb1">Qty</th>
                                <th class="tb1">Time</th>
                                <th width="17%" class="tb1">Date</th>                      
                                <th class="tb1">Bill No</th>
                                <th class="tb1">Cashier Id</th>
                                <th class="tb1">Tax(5%)</th>
                                <th class="tb1">Revenue</th>
                                <th class="tb1" width="20%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($report as $value)
                            <tr>
                                <td class="tb1">{{$loop->iteration}}</td>
                                <td class="tb1">{{$value->time}}</td>
                                <td class="tb1">{{$value->date}}</td>
                                <td class="tb1">{{$value->bill_no}}</td>
                                <td class="tb1">{{$value->auth_user}}</td>
                                <td class="tb1">{{$value->percentage}}</td>
                                <td class="tb1">{{$value->revenue}}</td>
                                <td class="tb1">{{$value->total_amount}}</td>
                            </tr>
                        @endforeach    
                            <tr class="text-center">
                                <th colspan="5" class="text-right tb1">Total(AED)</th>
                                <td class="tb1"><strong>{{$totalPercentage}}</strong></td>
                                <td class="tb1"><strong>{{$totalRevenue}}</strong></td>
                                <td class="tb1"><strong>{{$total}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <br><br><br>
            <div>
                <small><small>NOTE: This is system generate report no need of signature</small></small>
            </div>
        </div>
    </div>    
</body>
</html>