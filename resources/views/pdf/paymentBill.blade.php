<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Some Random Title</title>
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
                                    <span class="">Payment Bill</span>
                                </h2>
                            </td>
                            <td class="text-right">
                                <strong>{{$today}}</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br><br>
            <div class="row invoice-info">
                <table class="table">
                    <tr>
                        <td>
                            <div class="">
                                <address>
                                    <strong>{{$billData->vendorName}}</strong><br>
                                    {{$billData->vendorAddress}}<br>
                                    {{$billData->state}},{{$billData->country}}<br>
                                    Email: stackcoder.in@gmail.com
                                </address>
                            </div>
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            <div class="text-right">
                                <b>Invoice #1001</b><br>
                                Paid for REASON
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- /.col -->
            </div>
            <br><br>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Product Name</td>
                                <td>Amount paid for Product Name</td>
                                <td class="text-right">&#8377; 1000</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Sub Total</td>
                                <td class="text-right"><strong>&#8377; 1000</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">TAX (18%)</td>
                                <td class="text-right"><strong>&#8377; 180</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Total Payable</td>
                                <td class="text-right"><strong>&#8377; 1180</strong></td>
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