<div class="modal-dialog">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      <table class="table table-dark">
        <tr>
          <th>Id</th>
          <th>Order Type</th>
          <th>Table No</th>
          <th>Token No</th>
          <th>Order Status</th>
        </tr>
        @foreach($orders as $order)
        <tr>
          <td>#{{$loop->iteration}}</td>
          <td>{{$order->order_type}}</td>
          <td>{{$order->table_no}}</td>
          <td>{{$order->token_no}}</td>
          @if($order->status==0)
          <td><p class="text-center" style="color:red"><b>PENDING</b></p></td>
          @else
          <td><p class="text-center" style="color:green"><b>READY</b></p></td>
          @endif
        </tr>
        @endforeach
      </table>
    </div>
  </div>