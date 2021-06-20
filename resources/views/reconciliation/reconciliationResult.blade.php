@extends("layouts.admin")

@section("page-content")


<section class="content">
<div class="card">
              <div class="card-header">
                <h2 class="card-title"><b>Bank Reconciliation</b></h2>
                <div class="card-tools">
                <a href="{{Route('bankReconciliationPdf',['accountId'=>$accountId,'fromDate'=>$from,'toDate'=>$to])}}">
                  <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#exampleModal">
                  Export To Pdf</button></a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-sm text-nowrap">
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
                    @foreach($result as $value)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$value->date}}</td>
                      <td>{{$value->bill_no}}</td>
                      <td>{{$value->narration}}</td>
                      <td>{{$value->debit}}</td>
                      <td>{{$value->credit}}</td>
                    </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><b>Running Balance :</b></td>
                      <td colspan="2"><b>{{$runningBalance}}</b></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
</section>

@endsection