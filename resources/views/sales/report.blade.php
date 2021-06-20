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
                                    <span class="">Grocery</span>
                                </h2>
                                <h4>
                                    <span class="">{{$type}} Report</span>
                                </h4>
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
                                <th>Qty</th>
                                <th width="20%">Date</th>
                                <th>Time</th>                      
                                <th>Invoice ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($report as $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$value->date}}</td>
                                <td>{{$value->time}}</td>
                                <td>#1212</td>
                                <td>{{$value->customerName}}</td>
                                <td>{{$value->amount}}</td>
                            </tr>
                        @endforeach    
                            <tr>
                                <th colspan="5" class="text-right">Total Sale</th>
                                <td><strong>{{$total}}</strong></td>
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