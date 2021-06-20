    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="invoice-POS">
<div class="printed_content">
    <center id="logo">
        <div class="logo"></div>
        <div class="info"></div>
            <h2>POS Ltd</h2>
    </center>
</div>
<div class="mid">
    <div class="info">
        <h2>Contact Us</h2>
        <p>
            Address : Parambath House,Payyoli Post,
            Email : marwan@gmail.com
            Phone : 7558996612
        </p>
    </div>
</div>

<div class="bot">
    <div id="table">
        <table>
            <tr class="tabletitle">
                <td class="Item">Item</td>
                <td class="Hours">QTY</td>
                <td class="Rate">Unit</td>
                <td class="Rate">Discount</td>
                <td class="Rate">Sub Total</td>
            </tr>
            @foreach($order_receipt as $receipt)
            <tr class="service">
                <td class="tableitem"><p class="itemtext">{{$receipt->product_name}}</p></td>
                <td class="tableitem"><p class="itemtext">{{$receipt->quantity}}</p></td>
                <td class="tableitem"><p class="itemtext">{{number_format($receipt->unitprice, 2)}}</p></td>
                <td class="tableitem"><p class="itemtext">{{$receipt->descount}}</p></td>
                <td class="tableitem"><p class="itemtext">{{number_format($receipt->amount,2)}}</p></td>
            </tr>
            @endforeach
            <tr class="tabletitle">
                <td></td>
                <td></td>
                <td></td>
                <td class="Rate">Tax</td>
                @if(!$order_receipt)
                <td class="Payment"> Sub Total {{number_format($receipt->amount,2)}}</td>
                @endif
            </tr>
            <tr class="tabletitle">
                <td></td>
                <td></td>
                <td></td>
                <td class="Rate">Total</td>
                <td class="Payment">
                {{number_format($order_receipt->sum('amount'),2)}}<h2>
                </h2></td>
            </tr>
        </table>
        <div class="legalcopy">
            <p class="legal"><strong>
            ***Thank You For Visiting***
            </strong><br>
                This is test content for billing
            </p>
        </div>
        <div class="serial-number">
        Serial : <span class="serial"> 
        1212123123
        </span>
        <span>24/03/2020 &nbsp; &nbsp;00:56</span>    
        </div>
    </div>
</div>
</div>
<style>
    #invoice-POS{
        box-shadow: 0 0 1in -0.25in rgb(0, 0, 0.5);
        padding: 2mm;
        margin:0 auto;
        width: 58mm;
        background:#fff
    }
    #invoice-POS ::selection{
        background: #34495E;
        color:#fff;
    }
    #invoice-POS  ::-moz-selection{
        background: #34495E;
        color: #fff;
    }
    #invoice-POS h1{
        font-size:1.5em;
        color: #222;
    }
    #invoice-POS h2{
        font-size:0.8em;
        color: #222;
    }
    #invoice-POS h3{
        font-size: 1.2em;
        font-weight:300;
        line-height: 2em;
    }
    #invoice-POS p{
        font-size:0.7em;
        line-height: 1.2em;
        color: #666;
    }
    #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot{
        border-bottom: 1px solid #eee;
    }  
    #invoice-POS #top{
        min-height:100px;
    }
    #invoice-POS #mid{
        min-height:80px;
    } 
    #invoice-POS #bot{
        min-height:50px;
    }
    #invoice-POS #top .logo{
        height: 60px;
        width: 60px;
        background-image:url() no-repeat;
        background-size: 60px 60px;
        border-radius: 50px;
    }
    #invoice-POS .info{
        display: block;
        margin-left :0;
        text-align: center;
    }
    #invoice-POS .title{
        float:right;
    }
    #invoice-POS title p{
        text-align:right;
    }
    #invoice-POS table{
        width: 100%;
        border-collapse: collapse;
    }
    #invoice-POS .tabletitle{
        font-size: 0.6em;
        background:#eee
    }
    #invoice-POS .service{
        border-bottom: 1px solid #eee;
    }
    #invoice-POS .item{
        width:24mm;

    }
    #invoice-POS .itemtext{
        font-size:0.5em;
    }
    #invoice-POS #legalcopy{
        margin-top:5mm;
        text-align:center;
    }
    
    .serial-number{
        margin-top:5mm;
        margin-bottom:2mm;
        text-align:center;
        font-size: 12px;
    }
    .serial{
        font-size:10px !important;
    }
</style>    
</body>
</html>
