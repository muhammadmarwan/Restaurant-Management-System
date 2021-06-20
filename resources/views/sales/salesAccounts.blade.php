@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<section class="content">
  <label>
  <h5 class="mb-2 mt-4"><strong>Sales Accounts Setup</strong></h5></label>
    <div class="row">
          <div class="col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>Cash Sale</h4>
                  <h6>Choose</h6>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#exampleModal1{{$cash='cash'}}" class="small-box-footer passingID">
                Click To Setup <i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
          <div class="col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>Card Sale</h4>
                  <h6>Choose</h6>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#exampleModal2{{$card='card'}}" class="small-box-footer passingID">
                Click To Setup <i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
          <div class="col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>Debitor</h4>
                  <h6>Choose</h6>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#exampleModal3{{$debitor='debitor'}}" class="small-box-footer passingID">
                Click To Setup <i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
          <div class="col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>Sale Revenue</h4>
                  <h6>Choose</h6>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#exampleModal4{{$revenue='revenue'}}" class="small-box-footer passingID">
                Click To Setup <i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
          <div class="col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>Tax Sale</h4>
                  <h6>Choose</h6>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#exampleModal5{{$tax='tax'}}" class="small-box-footer passingID">
                Click To Setup <i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
          <div class="col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>Tips</h4>
                  <h6>Choose</h6>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" data-toggle="modal" data-target="#setupCashModel" class="small-box-footer passingID">
                Click To Setup <i class="fas fa-arrow-circle-right"></i>
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
      <form method="post" action="{{ Route('storeSalesAccounts') }}">
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
      <form method="post" action="{{ Route('storeSalesAccounts') }}">
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
<div class="modal fade" id="exampleModal3{{$debitor}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ Route('storeSalesAccounts') }}">
      @csrf
      <div class="modal-body">
      <input type="hidden" value="{{$debitor}}" name="type">
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
      <form method="post" action="{{ Route('storeSalesAccounts') }}">
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
      <form method="post" action="{{ Route('storeSalesAccounts') }}">
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



