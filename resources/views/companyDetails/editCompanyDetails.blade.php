@extends("layouts.admin")
@section("page-content")

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
    <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card">
              <div class="card-header">
                <h4><b>Edit Company Informations</b></h4>
                <div class="card-tools">
                    <b>Date : {{$today}}</b>
                </div>
              </div>
              <form role="form" id="quickForm" method="post" action="{{ Route('updateCompanyDetails') }}">
              @csrf
                <div class="card-body">
                  <div class="row">
                  <div class="col">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Company Name</label>
                    <input type="text" value="{{$company->company_name}}" name="companyName" class="form-control">
                  </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Company Address</label>
                        <input type="text" value="{{$company->company_address}}" name="address" class="form-control">
                    </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Country</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="country">
                        <option selected disabled>Choose here</option>
                        @foreach($country as $val)
                        <option value="{{ $val->name }}" {{ $val->name == $company->country ? 'selected' : '' }}>{{ $val->name }}</option>
                        @endforeach
                  </select>
                </select>                      
                </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Total Employees</label>
                        <input type="text" value="{{$company->total_employees}}" name="totalEmployees" class="form-control">
                    </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Id</label>
                        <input type="text" value="{{$company->email_id}}" name="emailId" class="form-control">
                    </div>
                  </div>
                  </div>       
                  <div class="row">
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone Numbers</label>
                    <input type="text" value="{{$company->phone}}" name="phone1" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">.</label>
                    <input type="text" value="{{$company->phone2}}" name="phone2" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">.</label>
                    <input type="text" value="{{$company->phone3}}" name="phone3" class="form-control" placeholder="Enter Phone Number">
                  </div>
                  </div>
                  </div>       
                  <div class="form-group">
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection