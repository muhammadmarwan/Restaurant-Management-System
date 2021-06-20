@extends("layouts.admin")
@section("page-content")
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div class="card">
  <div class="card-header">
    <h4><b>Company Informations</b></h4>
  </div>
  <div class="card-body">
    <h5 class="card-title"><b>Company Name :</b></h5>
    <p class="card-text">{{$company->company_name}}</p>
    <br><h5 class="card-title"><b>Company Address :</b></h5>
    <p class="card-text">{{$company->company_address}}</p>
    <br><h5 class="card-title"><b>Country :</b></h5>
    <p class="card-text">{{$company->country}}</p>
    <br><h5 class="card-title"><b>Total Employees :</b></h5>
    <p class="card-text">{{$company->total_employees}}</p>
    <br><h5 class="card-title"><b>Company Email Id :</b></h5>
    <p class="card-text">{{$company->email_id}}</p>
    <br><h5 class="card-title"><b>Phone No :</b></h5>
    <p class="card-text">{{$company->phone}}  -  {{$company->phone2}}  -  {{$company->phone3}}</p>
    <br>
    <a href="{{ Route('editCompanyDetails') }}" class="btn btn-primary btn-sm">Edit Details</a>
  </div>
</div>    

@endsection