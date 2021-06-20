@extends("layouts.admin")

@section("page-content")

<div class="container">
<div class="card-header">
  <h2 class="card-title"><b>Salary Sheet</b></h2><br>
    <b style="color:green;text-transform: uppercase;">
        {{$lastMonth}}</b>
    <div class="card-tools">
      <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#publish">
      Publish</button>
    </div>
</div>

<div class="card-body table-responsive p-0">
    <table class="table table-bordered text-center">
        <thead>
        <tr>
            <th>ID</th>
            <th>Employee Id</th>
            <th>Employee Name</th>
            <th>Designation</th>
            <th>Salary</th>
            <th width="15%">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$employee->employee_id}}</td>
            <td>{{$employee->name}}</td>
            <td>{{$employee->designation}}</td>
            @if($employee->salary==null)
            <td>------------</td>
            <td>
              <a href="{{Route('createSalarySheet',['employeeId'=>$employee->employee_id])}}">
              <button type="button" class="btn btn-sm btn-warning">
                Create Salary Sheet
              </button>
              </a>
            </td>
            @else
            <td>{{$employee->salary}}</td>
            <td>
                <strong style="color:green">Created</strong>
            </td>  
            @endif
        </tr>
        @endforeach 
        </tbody>
      </table>
    </div>
</div>
</div>

<!-- Modal For Daily Sale Close -->
<div class="model-keyboard-shotcut modal fade" id="publish" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Employees Salary For <b style="color:green;text-transform: uppercase;">
        {{$lastMonth}}</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="get" action="{{ Route('salaryPublish') }}">
      @csrf
      <div class="card-body">
        <div class="form-group">
          @if($salarySum!=0)
          <h5>Total Amount</h5>
          <div class="my-2">
            <h2 style="color:green;font:12px/30px">{{$salarySum}}</h2>
          </div>
          @else
            <h2 style="color:green;font:12px/30px">Published</h2>
          @endif
        </div>        
      </div>
      </div>
      <div class="modal-footer">
      @if($salarySum!=0)
        <button type="submit" class="btn btn-success">Publish Salary</button>
      @endif  
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
      </div>
    </div>
    </form>
  </div>
</div>

@endsection