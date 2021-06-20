@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="container">
<div class="row">
<div class="col-8">
<section class="content">
    <div id="chart-container" class="p-5">
    </div>
</section>
</div>
<div class="col-4">
<div class="container p-3">
<div class="info-box mb-3 bg-info m-2 p-4">
  <span class="info-box-icon"><i class="fas fa-cash-register"></i></span>
    <div class="info-box-content">
    <span class="info-box-text"><h6>Today's Sale</h6></span>
    <span class="info-box-number"><h4><b>{{$todaysSale}} DH</b></h4></span>
    </div>
</div>
<div class="info-box mb-3 bg-warning m-2 p-4">
  <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
    <div class="info-box-content">
        <span class="info-box-text"><h6>Debts Amount</h6></span>
        <span class="info-box-number"><h4><b>{{$debts}} DH</h4></b></span>
    </div>
</div>
<div class="info-box mb-3 bg-success m-2 p-4">
  <span class="info-box-icon"><i class="fas fa-money-check-alt"></i></span>
    <div class="info-box-content">
        <span class="info-box-text"><h6>Petty Cash</h6></span>
        <span class="info-box-number"><h4><b>{{$pettyCash}} DH</h4></b></span>
    </div>
</div>
<div class="info-box mb-3 bg-danger m-2 p-4">
    <span class="info-box-icon"><i class="fas fa-users"></i></span>
        <div class="info-box-content">
            <span class="info-box-text"><h6>Total Employees</h6></span>
            <span class="info-box-number"><h4><b>{{$employees}}</h4></b></span>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('plugins/highcharts/highcharts.js') }}"></script>
<script>
    var datas = <?php echo json_encode($datas) ?>

    Highcharts.chart('chart-container',{
        title:{
            text:'Current Year Sale'
        },
        subtitle:{
            text:'Sale Graph'
        },
        xAxis:{
            title:{
                text:'Months'
            },
            categories:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
        },
        yAxis:{
            title:{
                text:'Sale Amount'
            }
        },
        legend:{
            layout:'vertical',
            align:'right',
            verticalAlign:'middle'
        },
        plotOptions:{
            series:{
                allowPointSelect:true
            }
        },
        series:[{
            name:'Sale',
            data:datas
        }],
        responsive:{
            rules:[
                {
                    condition:{
                        maxWidth:500
                    },
                    chartOption:{
                        legent:{
                            layout:'horizontal',
                            align:'center',
                            verticalAlign:'bottom'
                        }
                    }
                }
            ]
        }
    })
</script>

@endsection
