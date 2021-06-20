@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<section class="content">
<div class="card">
              <div class="card-header">
                <h2 class="card-title"><b>General Ledger</b></h2>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th>Bill No</th>
                      <th>Description</th>
                      <th>Debit</th>
                      <th>Credit</th>
                    </tr>
                  </thead>
                  @foreach($generalLedger as $value)
                  <!-- {{$i=0}} -->
                  <!-- {{$i++}} -->
                    <tr>
                      <td>{{$i}}</td>
                      <td>{{$value->date}}</td>
                      <td>{{$value->billNo}}</td>
                      <td>{{$value->description}}</td>
                      <td>{{$value->debit}}</td>
                      <td>{{$value->credit}}</td>  
                    </tr>   
                    @endforeach
                    <tfoot>
                    <tr>
                      <td colspan="3"></td>
                      <td><b>Total :</b></td>
                      <td><b>{{$debitSum}}</b></td>
                      <td><b>{{$creditSum}}</b></td>
                    </tr>
                    </tfoot>
                  </tbody>
                </table>
              </div>
            </div>

</section>

@endsection