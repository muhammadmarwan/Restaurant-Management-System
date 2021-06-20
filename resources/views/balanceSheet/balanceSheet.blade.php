@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if(count($errors))
<div class="form-group">
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<section class="content">
<div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title">Balance Sheet</h3>
  </div>
    <div class="card-body">
    <div class="container">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Date</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Month</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Year</a>
                  </li>
                </ul>
              </div>

             
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                  <form method="post" action="{{ Route('viewBalanceSheet') }}">
                  @csrf
                  <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control">              
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                  <form method="post" action="{{ Route('viewBalanceSheet') }}">
                  @csrf
                  <div class="form-group">
                    <label>Month</label>
                    <input type="month" name="month" class="form-control" placeholder="Select Month">              
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                  <form method="post" action="{{ Route('viewBalanceSheet') }}">
                  @csrf
                  <div class="form-group">
                  <label>Year</label>
                  <select name="year" class="form-control">
                    <option disabled selected>Please Select Year</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                    <option value="2032">2032</option>
                    <option value="2033">2033</option>
                    <option value="2034">2034</option>
                    <option value="2035">2035</option>
                    <option value="2036">2036</option>
                    <option value="2037">2037</option>
                    <option value="2038">2038</option>
                    <option value="2039">2039</option>
                    <option value="2040">2040</option>
                    <option value="2041">2041</option>
                    <option value="2042">2042</option>
                    <option value="2043">2043</option>
                    <option value="2044">2044</option>
                    <option value="2045">2045</option>
                    <option value="2046">2046</option>
                    <option value="2047">2047</option>
                    <option value="2048">2048</option>
                    <option value="2049">2049</option>
                    <option value="2050">2050</option>
                  </select>                
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
    </div>
</section>

@endsection