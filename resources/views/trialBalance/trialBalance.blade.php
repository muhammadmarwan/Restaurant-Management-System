@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@if(count($errors))
            <div class="form-group">
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
@endif

<section class="content">
<div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title">Trial Balance</h3>
  </div>
    <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              <form method="post" action="{{ Route('trialBalanceResult') }}">
              @csrf
                <div class="form-group">
                  <label>Please Select Date</label>
                  <input type="date" name="date" class="form-control">              
               </div>
              </div>  
            </div>              
            <div class="card-footer">      
             </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
</section>


@endsection