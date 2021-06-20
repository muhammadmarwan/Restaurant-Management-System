@extends("layouts.admin")

@section("page-content")

<section class="content">
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Product Barcodes</h3>
              </div>
        <div class="row">
        @foreach($products as $value)
          <div class="col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box">
              <div class="inner">
                <h5><?php echo DNS1D::getBarcodeHTML($value->barcode, 'EAN8');?>
                <p>{{$value->barcode}}</p>
                </h5>
                <p>{{$value->product_name}}</p>
              </div>
            </div>
          </div>
          @endforeach
          </div>    
          </div>
</section>

@endsection