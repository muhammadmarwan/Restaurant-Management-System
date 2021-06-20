@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif


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
                      <div class="card card-body bg-success itemCard" data-toggle="modal"data-target="#exampleModal" data-id="{{$val->itemId}}">
                        @if($val->item_name==null)
                            <h4>XXXX</h4>
                            <br>
                            <p>xxxx</p>
                        @else
                            <h4><b>{{$val->item_code}}</b></h4>
                            <br>
                            <p>{{$val->item_name}}</p>
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
                      <div class="card card-body bg-warning itemCard"data-toggle="modal"data-target="#exampleModal" data-id="{{$val->itemId}}">
                        @if($val->item_name==null)
                            <h4>XXXX</h4>
                            <br>
                            <p>xxxx</p>
                        @else
                            <h4><b>{{$val->item_code}}</b></h4>
                            <br>
                            <p>{{$val->item_name}}</p>
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
                      <div class="card card-body bg-danger itemCard"data-toggle="modal"data-target="#exampleModal" data-id="{{$val->itemId}}">
                        @if($val->item_name==null)
                            <h4>XXXX</h4>
                            <br>
                            <p>xxxx</p>
                        @else
                            <h4><b>{{$val->item_code}}</b></h4>
                            <br>
                            <p>{{$val->item_name}}</p>
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



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="{{ Route('setupItemsStore') }}">
      @csrf
        <input type="hidden" name="modelId" class="form-control" id="input_type" value="" readonly>
        <div class="form-group">
              <select class="form-control select2" style="width: 100%;" name="item">
                  <option selected disabled>Choose here</option>
                  @foreach($items as $val)
                  <option value="{{$val->transaction_id}}">{{$val->item_name}}</option>
                  @endforeach
              </select> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
    $(".itemCard").click(function () {
    var ids = $(this).attr('data-id');
    $("#input_type").val( ids );
    $('#exampleModal').modal('show');
    });
  </script>
@endsection