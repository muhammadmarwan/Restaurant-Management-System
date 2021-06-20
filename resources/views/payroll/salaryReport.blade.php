@extends("layouts.admin")

@section("page-content")


<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Payroll <small>  Report</small></h3>
              </div>
              <div class="modal-content">
                <table class="table">
                    <tr>
                        <form method="post" action="{{ Route('salaryReportResult') }}">
                        @csrf   
                        <td colspan="3">
                            <div class="form-group">
                                <label>Select Month</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="month" name="month" class="form-control">
                            </div>
                            </div>
                            <div class="form-group">
                               <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </td>
                        </form>
                    </tr>
                </table>
            </div>
            </div>
            </div>
        </div>
      </div>
    </section>

@endsection