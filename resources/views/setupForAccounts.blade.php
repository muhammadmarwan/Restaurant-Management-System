@extends("layouts.admin")

@section("page-content")


@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

  <section class="content">
  <label>
  <h5 class="mb-2 mt-4"><strong>Payment Account Setup</strong></h5></label>
        <div class="row">
        @foreach($setupAccounts as $value)
          <div class="col-lg-2 col-6">
            <!-- small card -->
            @if($value->selectedAccount == 1)
            <div class="small-box bg-info">
            @else
            <div class="small-box bg-success">
            @endif
              <div class="inner">
                <h3>{{$value->account_type}}</h3>
                @if($value->selectedAccount==1)
                  <h6>Choose</h6>
                @endif
                @if($value->selectedAccount != 1)
                <h6>{{$value->selectedAccount}}</h6>
                @endif
              </div>
              <div class="icon">
              <i class="fas fa-credit-card"></i>
              </div>
              @if($value->selectedAccount == 1)
              <a href="#" data-toggle="modal" data-target="#setupCashModel" class="small-box-footer passingID" data-id="{{$value->transaction_id}}">
                Click To Setup <i class="fas fa-arrow-circle-right"></i>
              </a>
              @endif
              @if($value->selectedAccount != 1)
              <a href="#" data-toggle="modal" data-target="#setupCashModel" class="small-box-footer passingID" data-id="{{$value->transaction_id}}">
                Account Selected
              </a>
              @endif
            </div>
          </div>
          @endforeach
          </div>    
</section>

<!-- model for store cash payment details -->
<div class="modal fade" id="setupCashModel" tabindex="-1" role="dialog" area-labelledby="exampleModelLabel" area-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModelLabel">Select Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
         </div>
         <form method="post" action="{{ Route('storeSetupAccount') }}">
         @csrf
         <div class="modal-body">
         <div class="form-group">
              <input type="hidden" name="type_id" class="form-control" id="input_type" value="" readonly>
            </div>
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
             <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
             <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" charset="utf-8">
    $(".passingID").click(function () {
    var ids = $(this).attr('data-id');
    $("#input_type").val( ids );
    $('#setupCashModel').modal('show');
    });
  </script>

@endsection