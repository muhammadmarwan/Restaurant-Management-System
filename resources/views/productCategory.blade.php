@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Product Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="quickForm" method="post" action="{{ Route('storeCategory') }}">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Enter Category Name</label>
                    <input type="name" name="category" class="form-control" id="exampleInputEmail1" placeholder="Enter Category Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Code</label>
                    <input type="name" name="code" class="form-control" id="exampleInputEmail1" placeholder="Enter Code">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Slug</label>
                    <input type="name" name="slug" class="form-control" id="exampleInputEmail1" placeholder="Enter Slug">
                  </div>
                  <div class="form-group">
                  <label>Status</label>
                  <select class="form-control select2" style="width: 100%;" name="status">
                    <option value="0">Active</option>
                    <option value="1">Deactive</option>
                  </select>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
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