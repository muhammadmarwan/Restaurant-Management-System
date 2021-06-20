@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

    <div class="card-header">
        <h2 class="card-title"><b>Product Stock</b></h2>

</div>
<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
                <tr>
                  <th>ID</th>
                  <th>Product</th>
                  <th>Category</th>
                  <th>Product Code</th>
                  <th>Available Stock</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              @foreach($stockDetails as $value)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$value->product}}</td>
                  <td>{{$value->category_name}}</td> 
                  <td>{{$value->product_code}}</td>  
                  @if($value->stock <= 10)
                  <th style="color:red"><h3>{{$value->stock}}</h3></th>
                  @endif
                  @if($value->stock > 10)
                  <th><h3 style="color:green">{{$value->stock}}-<small>{{$value->quantity_unit}}</small></h3></th>
                  @endif
                  <td width="5%"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{$value->id}}{{$value->stock}}">Update</td>                
                </tr>
              @endforeach
              </tbody>
          </table>
      </div>
  </div> 

<!-- Modal -->
@if(isset($value))
<div class="modal fade" id="exampleModal{{$value->id}}{{$value->stock}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ Route('updateStock') }}">
        @csrf
          <input type="hidden" name="id" value="{{$value->id}}">
          <input type="number" name="stock"  class="form-control" value="{{$value->stock}}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endif

@endsection

