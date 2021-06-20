<div class="container-fluid">
    <div class="row">
      <div class="col-3 px-1 bg-dark position-fixed" id="sticky-sidebar">
        <div class="nav flex-column flex-nowrap vh-100 overflow-auto text-white p-2">
          <h1>Demo Items</h1>
          <table class="table table-sm">
            <thead>
              <td><strong>Items</td>
              <td><strong>Qty</td>
              <td><strong>Unit Price</td>
              <td><strong>Total Amount</strong></td>
            </thead>
            <tbody>
            @foreach($ItemsCart as $val)
              <tr>
                <td><small>{{$val->item_name}}</small></td>
                <td class="text-right"><small>{{$val->quantity}}</small></td>
                <td class="text-right"><small>{{$val->price}}</small></td>
                <td class="text-right"><small>{{$val->total_price}}</small></td>
              </tr>
            @endforeach
              
              <tr>
                <td><small>XXXX</small></td>
                <td><small>XXXX</small></td>
                <td class="text-right"><small>XXXX</small></td>
                <td class="text-right"><small>XXXX</small></td>

              </tr>
            </tbody>
          </table>
        </div>
        <div class="footer fixed-bottom bg-light position-fixed" >
          <div class="col-3">
          <table class="table table-sm">
            <tr>
              <td><strong>Total :</strong></td>
              <td><h3>90 AED</h3></td>
            </tr>
            <tr>
              <td><small>Payment Method :</small></td>
              <td><input type="text" wire:keydown="demo" class="form-control form-control-sm"></td>
            </tr>
          </table>
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
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">
                    Small Cource</a>
                  </li>
                  <li class="nav-item success">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">
                    Main Cource</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">
                    Extra</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill" href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Settings</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                  <div class="row">
                  @foreach($normal as $val)
                    <div class="col-md-2">
                      <div class="card card-body bg-success itemCard" wire:click="InsertoCart({{$val->itemId}})">
                        @if($val->item_name==null)
                            <h4>XXXX</h4>
                            <br>
                            <small>xxxx</small>
                        @else
                            <h4><b>{{$val->item_code}}</b></h4>
                            <br>
                            <small>xxxx</small>
                        @endif                        
                      </div>
                    </div>
                    @endforeach
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                  <div class="row">
                  @foreach($main as $val)
                    <div class="col-md-2">
                      <div class="card card-body bg-warning itemCard">
                        @if($val->item_name==null)
                            <h4>XXXX</h4>
                            <br>
                            <small>xxxx</small>
                        @else
                            <h4><b>{{$val->item_code}}</b></h4>
                            <br>
                            <small>{{$val->item_name}}</small>
                        @endif
                      </div>
                    </div>
                    @endforeach
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                  <div class="row">
                  @foreach($extra as $val)
                    <div class="col-md-2">
                      <div class="card card-body bg-danger itemCard" wire:click="ItemInsertCart({{$val->itemId}})">
                        @if($val->item_name==null)
                            <h4>XXXX</h4>
                            <br>
                            <small>xxxx</small>
                        @else
                            <h4><b>{{$val->item_code}}</b></h4>
                            <br>
                            <small>{{$val->item_name}}</small>
                        @endif
                      </div>
                    </div>
                    @endforeach
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="card card-body bg-primary itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-primary itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-primary itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-primary itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-primary itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-primary itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>

                    <!-- //normal items -->
                    <div class="col-md-2">
                      <div class="card card-body bg-success itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-success itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-success itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-success itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-success itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-success itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>

                    <!-- //big items -->
                    <div class="col-md-2">
                      <div class="card card-body bg-warning itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-warning itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-warning itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-warning itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-warning itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-warning itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>

                    <!-- //large items -->
                    <div class="col-md-2">
                      <div class="card card-body bg-danger itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-danger itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-danger itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-danger itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-danger itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-body bg-danger itemCard">
                        <h4>Tea</h4><br>
                        <small>Tea 10 AED</small>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
