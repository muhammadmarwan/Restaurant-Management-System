@extends("layouts.admin")

@section("page-content")
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card">
              <div class="card-header">
                <h4><b>Employee Details</b></h4>
                <h3 style="color:red;text-transform: uppercase;"><b></b></h3>
              </div>
            <form role="form" id="quickForm" method="post" action="{{ Route('employeeUpdate') }}">
              @csrf
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Employee Name</label>
                    <input type="text" value="{{$employee->name}}" name="employeeName" class="form-control">
                    <input type="hidden" value="{{$employee->employee_id}}" name="employeeId" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Designation</label>
                    <input type="text" value="{{$employee->designation}}" name="designation" class="form-control">
                  </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Age</label>
                    <input type="text" value="{{$employee->age}}" name="age" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Date Of Join</label>
                    <input type="date" value="{{$employee->date_of_joining}}" name="doj" class="form-control">
                  </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nationality</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="nationality">
                     <option selected disabled>Choose here</option>
                       @foreach($nationality as $val)
                        <option value="{{ $val->name }}" {{ $val->name == $employee->nationality ? 'selected' : '' }}>{{ $val->name }}</option>
                       @endforeach
                  </select>                  
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Emirates Id</label>
                    <input type="text" value="{{$employee->emirates_id}}" name="emiratesId" class="form-control">
                  </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone</label>
                    <input type="text" value="{{$employee->phone}}" name="phone" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Id</label>
                    <input type="text" value="{{$employee->email_id}}" name="emailId" class="form-control">
                  </div>
                  </div>
                  </div><br>
                  
                  <div class="row" style="background-color:rgba(0,0,0,.03)">
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Basic Salary</label>
                    <input type="text" value="{{$employee->basic_salary}}"  name="basicSalary" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Other Allowances</label>
                    <input type="text" value="{{$employee->other_allowances}}" name="otherAllowances" class="form-control">
                  </div>
                  </div>
                  <div class="form-group m-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>
              </form>
            </div>
      </div>
    </section>
@endsection