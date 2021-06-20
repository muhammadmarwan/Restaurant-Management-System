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
                <h3 class="card-title"><small>Create </small>Vendor </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="quickForm" method="post" action="{{ Route('storeVendor') }}">
              @csrf
                <div class="card-body">
                 <div class="form-group">
                    <label for="exampleInputEmail1">Vendor Name</label>
                    <input type="name" name="vendorName" class="form-control" id="exampleInputEmail1" placeholder="Enter Vendor Name">
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Vendor Id</label>
                    <input type="name" name="vendorId" class="form-control" id="exampleInputEmail1" placeholder="Enter Vendor Id">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Id</label>
                    <input type="email" name="emailId" class="form-control" id="exampleInputEmail1" placeholder="Enter Email Id">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone Number</label>
                    <input type="name" name="phone" class="form-control" id="exampleInputEmail1" placeholder="Enter Phone Number">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <textarea type="address" name="address" class="form-control" id="exampleInputEmail1" placeholder="Enter Address"></textarea>
                  </div>
                  <div class="form-group">
                  <label>Country</label>
                  <select class="form-control select2" style="width: 100%;" name="country">
                    <option disabled selected>Please Select Country</option>
                  @foreach($country as $value)
                    <option value="{{$value->name}}">{{$value->name}}</option>
                  @endforeach 
                  </select>
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