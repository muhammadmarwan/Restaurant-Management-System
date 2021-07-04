<div class="container-fluid">
    <div class="row">
      <div class="col-3 px-1 bg-dark position-fixed" id="sticky-sidebar">
        <div class="nav flex-column flex-nowrap vh-100 overflow-auto text-white p-2">
          <h1>XXXXXXXXXX</h1>
          <table class="table table-sm">
            <thead>
              <td style="font-size: 13px;width:50%" width="80%"><strong>Items</td>
              <td style="font-size: 13px;" class="text-right"><strong>Qty</td>
              <td style="font-size: 13px;" class="text-right"><strong>Price</td>
              <td style="font-size: 13px;" class="text-right"><b>Total</b></td>
              <td></td>
            </thead>
            <tbody>
            @foreach($ItemsCart as $val)
              <tr>
                <td><small>{{$val->item_name}}</small></td>
                <td class="text-right"><small>{{$val->quantity}}</small></td>
                <td class="text-right"><small>{{$val->price}}</small></td>
                <td class="text-right"><small>{{$val->total_price}}</small></td>
                <a href="#"><td wire:click="RemoveItem({{$val->id}})" style="background-color:#cc2929;border-radius: 40px;">
                <i class="fas fa-minus-circle"></i></td></a>
              </tr>
            @endforeach
              <tr>
                <td><small>XXXX</small></td>
                <td><small>XXXX</small></td>
                <td class="text-right"><small>XXXX</small></td>
                <td class="text-right" colspan="2"><small>XXXX</small></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="footer fixed-bottom bg-light position-fixed" >
          <div class="col-3">
          <table class="table table-sm">
            <tr>
              <td><h3>Total :</h3></td>
              <td><h2>{{$total}} DH</h2></td>
            </tr>
          </table>
          <table class="table table-dark">
            <tr>
              <th><button type="submit" class="btn btn-danger btn-sm" 
              data-toggle="modal" data-target="#tableSelect1">DINE IN</button></th>
              <th><a href="{{ Route('takeAway') }}"><button type="submit" class="btn btn-danger btn-sm">TAKE AWAY</button></a></th>
              <th><button type="submit" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delivery">
              DELIVERY  .</button></th>
            </tr>
          </table>
        </div>
    </div>
</div>

<!-- //Dine Table large model -->
<div wire:ignore.self class="modal fade bd-example-modal-lg" id="tableSelect1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Select Table</h3>
      </div>
      <div class="modal-body">
        <div class="row">
        @foreach($tableSelect as $val) 
          <div class="col-sm-2 m-2">
          <a href="{{ Route('storeDineOrder',['id'=>$val->table_no]) }}">
            <div class="card card-body card-sm bg-danger itemCard" style="width: 8rem;">
                <h4>{{$val->table_no}}</h4>
                <br>
                <small>{{$val->table_name}}</small>    
            </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<!-- //Delivery model -->
<div class="modal fade bd-example-modal" id="delivery" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Delivery Details</h3>
      </div>
      <div class="modal-body">
      <form method="post" action="{{ Route('deliveryStore') }}">
      @csrf
        <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4">Name</label>
          <input type="text" name="customerName" class="form-control" id="inputEmail4" placeholder="Customer Name">
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Phone</label>
          <input type="number" name="customerPhone" class="form-control" id="inputPassword4" placeholder="Customer Phone">
        </div>
        </div>
        <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputPassword4">Address</label>
          <input type="text" name="address" class="form-control" id="inputPassword4" placeholder="Address">
        </div>
        </div>
        <div class="form-row">
          <button type="submit" class="btn btn-primary">Proceed</button>
        </div>
        </form>
    </div>
    </div>
  </div>
</div>

<div class="col-9 offset-3 position-fixed" id="main">
      <h1>Main Area</h1>
      <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                  @if($tabId==1)
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Small Items</a>
                  @else
                    <a class="nav-link" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Small Items</a>
                  @endif  
                  </li>
                  <li class="nav-item success">
                  @if($tabId==2)
                    <a class="nav-link active" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Main Items</a>
                  @else
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Main Items</a>
                  @endif  
                  </li>
                  <li class="nav-item">
                  @if($tabId==3)
                    <a class="nav-link active" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Extra Items</a>
                  @else
                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Extra Items</a>
                  @endif
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                @if($tabId==1)
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                @else
                  <div class="tab-pane fade show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                @endif  
                  <div class="row">
                  @foreach($normal as $val)
                    <div class="col-md-2">
                      <div style="height:110px" class="card card-body bg-danger itemCard mh-110" wire:click="InsertoCart({{$val->itemId}})">
                        @if($val->item_name==null)
                            <h4>XXXX</h4>
                            <br>
                        @else
                            <small style="text-transform: uppercase;">{{$val->item_name}} (<b>{{$val->amount}}</b>)</small>
                        @endif                        
                      </div>
                    </div>
                    @endforeach
                    </div>
                  </div>
                  @if($tabId==2)
                  <div class="tab-pane fade show active" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                  @else
                  <div class="tab-pane fade show" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                  @endif
                  <div class="row">
                  @foreach($main as $val)
                    <div class="col-md-2">
                      <div style="height:110px" class="card card-body bg-success itemCard" wire:click="InsertoCart({{$val->itemId}})">
                        @if($val->item_name==null)
                            <h4>XXXX</h4>
                            <br>
                        @else
                        <small style="text-transform: uppercase;">{{$val->item_name}} (<b>{{$val->amount}}</b>)</small>
                        @endif
                      </div>
                    </div>
                    @endforeach
                    </div>
                  </div>
                  @if($tabId==3)
                  <div class="tab-pane fade show active" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                  @else
                  <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                  @endif
                  <div class="row">
                  @foreach($extra as $val)
                    <div class="col-md-2">
                      <div style="height:110px" class="card card-body bg-warning itemCard" wire:click="InsertoCart({{$val->itemId}})">
                        @if($val->item_name==null)
                            <h4>XXXX</h4>
                            <br>
                        @else
                        <small style="text-transform: uppercase;">{{$val->item_name}} (<b>{{$val->amount}}</b>)</small>
                        @endif
                      </div>
                    </div>
                    @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<script>
    $('.itemCard').on("click", function(event) {
        $('#tableSelect1').modal( 'hide' ),
    });
</script>