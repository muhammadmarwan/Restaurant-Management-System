@extends("layouts.admin")

@section("page-content")

<div class="card">
  <div class="card-header">
    <h4><b>Purchase Informations</b></h4>
  </div>
  <div class="card-body">
  <table class="table table-dark">
    <thead>
        <th>Vendor Name</th>
        <th>Purchase Type</th>
        <th>Amount</th>
        <th>Tax</th>
        <th>Invoice No</th>
        <th>Payment Due Date</th>
    </thead>
    <tbody>
        <td>{{$purchase->vendorName}}</td>
        <td>{{$purchase->type}}</td>
        <td>{{$purchase->total_amount}}</td>
        <td>5%</td>
        <td>{{$purchase->invoice_no}}</td>
        <td>{{$purchase->due_date}}</td>
    </tbody>
  </table>
  @if($purchase->type=='Inventory')
  <div class="card-header">
    <h5><b><u>Products</u></b></h5>
  </div>
  <table class="table table-sm">
    <thead>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Amount</th>
    </thead>
    @foreach($products as $value)
    <tbody>
    <tr>
        <td>{{$value->label}}</td>
        <td>{{$value->quantity}}-{{$value->unit}}</td>
        <td>{{$value->total}}</td>
    </tr>
    </tbody>
    @endforeach
  </table>
  @endif  
  </div>
</div>

@endsection