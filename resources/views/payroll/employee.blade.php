@extends("layouts.admin")

@section("page-content")

<div class="card-header">
  <h2 class="card-title"><b>Employees</b></h2>
    <div class="card-tools">
      <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#exampleModal1">
      Register Employee</button>
    </div>
</div>
<div class="card-body table-responsive p-0">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Emp Id</th>
            <th>Designation</th>
            <th>Nationality</th>
            <th>Mobile No</th>
            <th>Status</th>
            <th width="15%">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
        <tr class="data-row">
            <td>{{$loop->iteration}}</td>
            <td class="itemName">{{$employee->name}}</td>
            <td class="itemName">{{$employee->employee_id}}</td>
            <td class="itemCode">{{$employee->designation}}</td>
            <td class="itemId">{{$employee->nationality}}</td>
            <td class="description">{{$employee->phone}}</td>
            @if($employee->status==0)
                <td style="color:green"><b>ACTIVE</b></td>
            @else
                <td style="color:red"><b>INACTIVE</b></td>
            @endif
            <td><a href="{{ Route('employeeEdit',['id'=>$employee->employee_id]) }}"><button type="button" class="btn btn-warning btn-sm" id="edit-item">Edit</button></a>
            <button type="button" class="btn btn-danger btn-sm  deleteButton" data-id="{{$employee->id}}">Delete</button></td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
</div>

<!-- Modal For Delete -->
<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <form method="post" action="{{ Route('deleteEmployee') }}"> 
        @csrf
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <input type="hidden" name="userId" class="form-control" id="input_type" value="" readonly>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade bd-example-modal-lg" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Employee Registration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="{{ Route('employeeStore') }}">
        @csrf
            <div class="row">
              <div class="col-md-8">
              <div class="form-group">
                  <label>Employee Name</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="text" name="employeeName" class="form-control" placeholder="Enter Employee Name">
                    </div>
                </div>
              </div>
              <div class="col-md-4">
              <div class="form-group">
                <label>Age</label>
                  <input type="number" name="employeeAge" class="form-control" id="exampleInputEmail1" placeholder="Enter Employee Age">
                  </select>
                </div>
              </div>               
            </div>
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Designation</label>
                  <input type="text" name="designation" class="form-control" id="exampleInputEmail1" placeholder="Enter Item Code">
                  </select>
                </div>
              </div> 
              <div class="col-md-6">
              <div class="form-group">
                <label>Date Of Joining</label>
                  <input type="date" name="doj" class="form-control">
                  </select>
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Nationality</label>
                  <select class="form-control select2bs4" style="width: 100%;" name="nationality">
                     <option selected disabled>Choose here</option>
                       @foreach($nationality as $val)
                       <option value="{{$val->name}}">{{$val->name}}</option>
                       @endforeach
                  </select>
                </div>
              </div> 
              <div class="col-md-6">
              <div class="form-group">
                <label>Emirates Id</label>
                  <input type="text" name="emiratesId" class="form-control" placeholder="Enter Emirates Id Number">
                  </select>
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Email_id</label>
                  <input type="text" name="emailId" class="form-control" id="exampleInputEmail1" placeholder="Enter Email Id">
                  </select>
                </div>
              </div> 
              <div class="col-md-6">
              <div class="form-group">
                <label>Phone Number</label>
                  <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number">
                  </select>
                </div>
              </div> 
            </div>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="next" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">Save changes</button>
      </div>
    </div>  
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Employee Salary Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Basic Salary</label>
                  <input type="number" name="basicSalary" class="form-control" id="exampleInputEmail1" placeholder="Enter Basic Salary">
                  </select>
                </div>
              </div> 
              <div class="col-md-6">
              <div class="form-group">
                <label>Other Allowances</label>
                  <input type="number" name="allowances" class="form-control" placeholder="Enter Allowances">
                  </select>
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Salary</label>
                  <input type="number" name="salary" class="form-control" placeholder="Enter Allowances">
                  </select>
                </div>
              </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Save changes</button>
      </div>
      </form>
    </div>  
  </div>
</div>


<script>
        $('#next').on("click", function(event) {
        $('#exampleModal1').modal( 'hide' );
        
        });
</script>

<script type="text/javascript" charset="utf-8">
    $(".deleteButton").click(function () {
    var ids = $(this).attr('data-id');
    $("#input_type").val( ids );
    $('#deleteModel').modal('show');
    });
</script>

@endsection