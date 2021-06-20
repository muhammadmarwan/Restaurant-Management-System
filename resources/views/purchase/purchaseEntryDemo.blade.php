@extends("layouts.admin")

@section("page-content")

<section class="content">

<!-- SELECT2 EXAMPLE -->
<div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title">Purhchase Entry</h3>
  </div>
    <div class="card-body">
        <div class="form-group">
          <form method="post" action="{{ Route('purchaseEntryStore') }}">
          @csrf
            <label for="exampleInputEmail1">Please Select Vendor</label>
                <select class="form-control select2bs4" style="width: 100%;" name="vendor">
                    <option selected disabled>Choose here</option>
                    @foreach($vendor as $val)
                    <option value="{{$val->value}}">{{$val->label}}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Please Select Debit Account</label>
                  <select class="form-control select2bs4" style="width: 100%;" name="account">
                     <option selected disabled>Choose here</option>
                       @foreach($accounts as $val)
                       <option value="{{$val->value}}">{{$val->label}}</option>
                       @endforeach
                  </select>
                </div>
              </div>              
              <div class="col-md-6">
                <div class="form-group">
                <label>Minimal</label>
                  <select class="form-control select2bs4" style="width: 100%;" name="mini">
                    <option selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select>
                </div>
              </div>
            </div>
            <label>Please Select Product</label>
            <div class="card-footer">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th style="text-align: center"><a href="#" class="btn btn-info addRow">+</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="form-control select2bs4" style="width: 100%;" name="account[]">
                                    <option selected disabled>Choose here</option>
                                    @foreach($accounts as $val)
                                    <option value="{{$val->value}}">{{$val->label}}</option>
                                    @endforeach
                                </select> 
                            </td>
                            <td><input type="text" name="product[]" class="form-control"></td>
                            <td style="text-align:center"><a href="#" class="btn btn-danger remove">-</a></td>
                        </tr>
                    </tbody>
                </table>      
             </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
</section>

<script type="text/javascript">
    $('.addRow').on('click',function(){
        addRow();
    });
    
    function addRow(){
        var tr = 
        '<tr>'+
            '<td>'+
                 '<select class="form-control select2bs4" style="width: 100%;" name="account[]">'+
                    '<option selected disabled>Choose here</option>'+
                    '@foreach($accounts as $val)'+
                    '<option value="{{$val->value}}">{{$val->label}}</option>'+
                    '@endforeach'+
                  '</select>'+ 
            '</td>'+
            '<td><input type="text" name="product[]" class="form-control"></td>'+
            '<td style="text-align:center"><a href="#" class="btn btn-danger remove">-</a></td>'+
        '</tr>';
        
        $('tbody').append(tr);
    };
    $('tbody').on('click','.remove',function(){
        $(this).parent().parent().remove();
    });
</script>


@endsection