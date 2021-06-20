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
                <h3 class="card-title">Sales <small>  Reports</small></h3>
              </div>
              <div class="modal-content">
                <table class="table">
                    <tr class="text-center">
                        <td><a href="{{Route('restaurantSalesReport',['type'=>'daily'])}}"><button type="button" class="btn btn-primary">
                        Daily Report</button></a></td>
                        <td><a href="{{Route('restaurantSalesReport',['type'=>'weekly'])}}"><button type="button" class="btn btn-primary">
                        Weekly Report</button></a></td>
                        <td><a href="{{Route('restaurantSalesReport',['type'=>'monthly'])}}"><button type="button" class="btn btn-primary">
                        Monthly Report</button></a></td>                        
                    </tr>
                    <tr>
                        <form method="post" action="{{ Route('restaurantSalesReport') }}"> 
                        @csrf   
                        <td colspan="3"><div class="form-group">
                                <label>From Date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" name="fromDate" class="form-control">
                            </div>
                            </div>
                            <div class="form-group">
                                <label>To Date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" name="toDate" class="form-control">
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
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>


@endsection