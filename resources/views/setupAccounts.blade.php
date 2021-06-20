@extends("layouts.admin")

@section("page-content")

 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-info" data-toggle="modal" data-target="#setupAccountModel">
              <div class="inner">
                <h4>Cash</h4>
              </div>
              <div class="icon">
              <i class="fas fa-file-invoice-dollar"></i>              </div>
              <a href="" class="small-box-footer">Click to setup<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
  </section> 

<div class="modal fade" id="setupAccountModel" tabindex="-1" role="dialog" area-labelledby="exampleModelLabel" area-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModelLabel">Model Title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
         </div>

         <form method="post" action="{{ Route('index') }}">
         <div class="modal-body">
            <div class="form-group">
              <label>Select Your Account</label>
              <select class="form-control select2" style="width: 100%;" name="account">
                  <option selected disabled>Choose here</option>
                  <option value="1">Accounts</option>
              </select>
            </div>
          </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
             <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>

@endsection