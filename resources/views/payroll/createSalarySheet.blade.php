@extends("layouts.admin")

@section("page-content")

@livewire('salary-sheet',['employeeId' =>$employeeId])

@endsection