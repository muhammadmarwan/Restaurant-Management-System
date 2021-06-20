@extends("layouts.admin")

@section("page-content")

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Bank Reconciliation</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="quickForm" method="post" action="{{ Route('checkReconciliation') }}">
              @csrf
                <div class="card-body">
                <div class="form-group">
                  <label>Choose Bank Account</label>
                  <select class="form-control select2" style="width: 100%;" name="accountId">
                    <option selected disabled>Choose here</option>
                    @foreach($bankAccounts as $value)
                    <option value="{{$value->value}}">{{$value->label}}</option>
                    @endforeach
                  </select>
                  </div>
                  <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">From Date</label>
                    <input type="date" name="fromDate" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">To Date</label>
                    <input type="date" name="toDate" class="form-control">
                  </div>
                  </div>
                  </div>
                  <div class="form-group">
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
      </div>
    </section>

@endsection



