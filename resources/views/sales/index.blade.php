@extends("layouts.cashierLayout")

@section("page-content")

<div class="container">
@livewire('order')
<div class="modal">
    <div id="print">
        @include('sales.receipt')
    </div>
</div>
</div>
@endsection

@section('script')
<script>
    // $(document).ready(function(){
    //     alert(1);
    // })

    //print function
    function PrintReceiptFuction(el){
        var data = '<input type="button" value="Print Receipt" id="printPageButton'+
        'class="printPageButton" style="display:block;'+
        'width:100%; border:none; background-color:#008B8B; color: #fff;'+
        'padding: 14px 28px; font-size: 16px; cursor:pointer; text-align:center;'+
        'value="Print Receipt" onclick="window.print()">';

        data+=document.getElementById(el).innerHTML;
        myReceipt = window.open("","myWin","left=150, top=130, width=400, height=400");
            myReceipt.screnX = 0;
            myReceipt.screnX = 0;
            myReceipt.document.write(data);
            myReceipt.document.title = "Print Receipt";
        myReceipt.focus();
        setTimeout(()=>{
            myReceipt.close();
        },5000);    
    }
  
 
</script>
@endsection