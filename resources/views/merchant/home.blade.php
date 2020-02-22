@extends('layouts.app')

@section('affiliate_breadcrumb')
<li class="breadcrumb-item active">Home</li>
@endsection
@section('content')
    <div class="container">
        <merchant-home :merchant="{{json_encode($merchant)}}" :merchant-programs="{{json_encode($merchantPrograms)}}" :total-clicks="{{$user->merchantClickCount()}}" :total-sales="{{$user->merchantSalesCount()}}" ></merchant-home>
    </div>
@endsection
