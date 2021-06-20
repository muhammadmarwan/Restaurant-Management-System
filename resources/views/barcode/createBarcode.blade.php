@extends("layouts.admin")

@section("page-content")


<?php echo DNS1D::getBarcodeHTML($transaction, 'C39');?>



@endsection