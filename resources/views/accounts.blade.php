@extends("layouts.admin")

@section("page-content")

 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        @foreach($accounts as $value)
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>{{$value->account_name}}</h4>

                <p>{{$value->account_id}}</p>
              </div>
              <div class="icon">
              <i class="fas fa-file-invoice-dollar"></i>              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
                <!-- ./col -->
          @endforeach
        </div>
</section>   
@endsection