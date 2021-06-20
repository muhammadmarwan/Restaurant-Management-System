@extends("layouts.admin")

@section("page-content")


<section class="content">
<div class="card">
<div class="card-header">
    <h2 class="card-title"><b>Salary Report ({{$month}}-{{$year}})</b> </h2>
        <div class="card-tools">
            <a href="{{ Route('printSalaryReport',['month'=>$month,'year'=>$year])}}">
                <button type="button" class="btn btn-block btn-primary">Export to PDF</button>
            </a>
        </div>
        </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Employee Name</th>
                      <th>Employee Id</th>
                      <th>Designation</th>
                      <th>Total Working Days</th>
                      <th>Net Salary</th>
                    </tr>
                  </thead>
                  @foreach($salaryReport as $value)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$value->name}}</td>
                      <td>{{$value->employee_id}}</td>
                      <td>{{$value->designation}}</td>
                      <td>{{$value->total_working_days}}</td>
                      <td>{{$value->net_salary}}</td>
                    </tr>
                  @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
</section>

@endsection