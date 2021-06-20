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
                <h3 class="card-title"><small>Create </small> SubAccounts</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="quickForm" method="post" action="{{ Route('storeSubAccounts') }}">
              @csrf
                <div class="card-body">
                <div class="form-group">
                  <label>Choose Parent Account</label>
                  <select class="form-control select2" style="width: 100%;" name="mainAccountId">
                    <option selected disabled>Choose here</option>
                    @foreach($accounts as $value)
                    <option value="{{$value->value}}">{{$value->label}}</option>
                    @endforeach
                  </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Account Name</label>
                    <input type="name" name="accountName" class="form-control" id="exampleInputEmail1" placeholder="Enter Account Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Account Code</label>
                    <input type="name" name="accountCode" class="form-control" id="exampleInputEmail1" placeholder="Enter Account Code">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Account Balance</label>
                    <input type="name" name="accountBalance" class="form-control" id="exampleInputEmail1" placeholder="Enter Account Balance">
                  </div>
                  <div class="form-group">
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@endsection