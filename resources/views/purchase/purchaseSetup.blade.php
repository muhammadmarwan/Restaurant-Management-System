@extends("layouts.admin")

@section("page-content")

<section class="content">
    <div class="card-header">
        <h3 class="card-title"><b>Purchase Accounts <small>  Setup</small></b></h3>
    </div>
    <div class="card-body">
    <div class="row">
          <div class="col-lg-2 col-6">
            <!-- small card -->
            @if($count!=null)
            <div class="small-box bg-success">
            @else
            <div class="small-box bg-info">
            @endif
              <div class="inner">
                <h4>Purchase Tax</h4>
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" id="setup" data-toggle="modal" data-target="#exampleModal" data-id="1"
              class="small-box-footer passingID">
                Click Here <i class="fas fa-arrow-circle-right"></i>
              </a>              
            </div>
          </div>
    </div>
  </div>      
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" action="{{ Route('storePurchaseSetup') }}">
      @csrf
      <div class="modal-body">
      <input type="hidden" value="1" name="type">
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
