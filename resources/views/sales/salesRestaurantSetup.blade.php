@extends("layouts.admin")

@section("page-content")

<section class="content">
  <label>
  <h5 class="mb-2 mt-4"><strong>Sales Restaurant Setup</strong></h5></label>
    <div class="row">
          <div class="col-lg-2 col-6">
            <!-- small card -->
            @if($cash!=null)
            <div class="small-box bg-success">
            @else
            <div class="small-box bg-info">
            @endif
              <div class="inner">
                <h4>Cash Sale</h4>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#exampleModal1{{$cash='cash'}}" class="small-box-footer passingID">
                Click Here <i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
          <div class="col-lg-2 col-6">
            <!-- small card -->
            @if($card!=null)
            <div class="small-box bg-success">
            @else
            <div class="small-box bg-info">
            @endif
              <div class="inner">
                <h4>Card Sale</h4>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#exampleModal2{{$card='card'}}" class="small-box-footer passingID">
                Click Here <i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
          <div class="col-lg-2 col-6">
          @if($revenue!=null)
            <div class="small-box bg-success">
            @else
            <div class="small-box bg-info">
          @endif
              <div class="inner">
                <h4>Sale Revenue</h4>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#exampleModal4{{$revenue='revenue'}}" class="small-box-footer passingID">
                Click Here<i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
          <div class="col-lg-2 col-6">
            @if($tax!=null)
              <div class="small-box bg-success">
            @else
              <div class="small-box bg-info">
            @endif
              <div class="inner">
                <h4>Tax Sale</h4>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#exampleModal5{{$tax='tax'}}" class="small-box-footer passingID">
                Click Here <i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
    </div>    
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal1{{$cash}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ Route('restaurantSetupStore') }}">
      @csrf
      <div class="modal-body">
        <input type="hidden" value="{{$cash}}" name="type">
        <div class="form-group">
              <label>Select Your Account</label>
              <select class="form-control select2" style="width: 100%;" name="account">
                  <option selected disabled>Choose here</option>
                  @foreach($accounts as $val)
                  <option value="{{$val->value}}">{{$val->label}}</option>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal2{{$card}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ Route('restaurantSetupStore') }}">
      @csrf
      <div class="modal-body">
      <input type="hidden" value="{{$card}}" name="type">
      <div class="form-group">
              <label>Select Your Account</label>
              <select class="form-control select2" style="width: 100%;" name="account">
                  <option selected disabled>Choose here</option>
                  @foreach($accounts as $val)
                  <option value="{{$val->value}}">{{$val->label}}</option>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal4{{$revenue}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ Route('restaurantSetupStore') }}">
      @csrf
      <div class="modal-body">
      <input type="hidden" value="{{$revenue}}" name="type">
      <div class="form-group">
              <label>Select Your Account</label>
              <select class="form-control select2" style="width: 100%;" name="account">
                  <option selected disabled>Choose here</option>
                  @foreach($accounts as $val)
                  <option value="{{$val->value}}">{{$val->label}}</option>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal5{{$tax}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ Route('restaurantSetupStore') }}">
      @csrf
      <div class="modal-body">
      <input type="hidden" value="{{$tax}}" name="type">
      <div class="form-group">
              <label>Select Your Account</label>
              <select class="form-control select2" style="width: 100%;" name="account">
                  <option selected disabled>Choose here</option>
                  @foreach($accounts as $val)
                  <option value="{{$val->value}}">{{$val->label}}</option>
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

@endsection