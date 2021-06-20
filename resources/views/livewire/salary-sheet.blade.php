<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card">
              <div class="card-header">
                <h4><b>Salary Sheet</b></h4>
                <h3 style="color:red;text-transform: uppercase;"><b>{{$lastMonth}}</b></h3>
                <div class="card-tools">
                    <b>{{$today}}</b>
                </div>
              </div>
              <form role="form" id="quickForm" method="post" action="{{ Route('salarySheetStore') }}">
              @csrf
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Employee Name</label>
                    <input type="text" readonly value="{{$employee->name}}" name="employeeName" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Employee Id</label>
                    <input type="text" readonly value="{{$employee->employee_id}}" name="employeeId" class="form-control">
                  </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Month</label>
                    <input type="text" readonly value="{{$lastMonth}}" name="month" class="form-control">
                    <input type="hidden" value="{{$year}}" name="year" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Total Working Days</label>
                    <input type="text" name="totalDays" class="form-control" placeholder="0">
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Leave Days</label>
                    <input type="text" name="leaveDays" class="form-control" placeholder="0">
                  </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Basic Salary</label>
                    <input type="text" readonly value="{{$employeeSalary->basic_salary}}" name="basicSalary" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Other Allowances</label>
                    <input type="text" readonly value="{{$employeeSalary->other_allowances}}" name="allowances" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Salary Per Month</label>
                    <input type="text" readonly value="{{$employeeSalary->gross_salary_payable}}" name="salaryPerMonth" class="form-control">
                  </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Advance</label>
                    <input type="text" readonly value="0" name="advance" class="form-control">
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Deduction</label>
                    @if($bonusAmount==null)
                        <input type="text" wire:keyup="Deduction" wire:model="deductAmount" placeholder="0" name="deduction" class="form-control">
                    @else
                        <input type="text" readonly wire:keyup="Deduction" wire:model="deductAmount" placeholder="0" name="deduction" class="form-control">
                    @endif
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Bonus</label>
                    @if($deductAmount==null)
                        <input type="text" wire:keyup="Bonus" wire:model="bonusAmount" placeholder="0" name="bonus" class="form-control">
                    @else
                        <input type="text" readonly wire:keyup="Bonus" wire:model="bonusAmount" placeholder="0" name="bonus" class="form-control">
                    @endif
                  </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Total Net Salary</label>
                    <input type="text" readonly value="{{$totalNetSalary}}" name="totalNetSalary" class="form-control">
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