@extends("layouts.admin")

@section("page-content")
<section class="content">
    <div class="card">
              <div class="card-header">
                <h2 class="card-title"><b>Cashier History</b></h2>
                <div class="card-tools">
                <div class="card-tools">
                  <!-- <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#exampleModal">
                  Export To Pdf</button> -->
                </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>From User</th>
                      <th>To User</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Amount</th>
                    </tr>
                    @foreach($cashierChange as $value)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$value->fromUser}}</td>
                      <td>{{$value->toUser}}</td>
                      <td>{{$value->date}}</td>
                      <td>{{$value->time}}</td>
                      <td><h3><b>{{$value->amount}}</b></h3></td>
                    </tr>
                    @endforeach
                  </thead>
                  <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection