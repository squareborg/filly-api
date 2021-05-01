@extends('affiliate.layout')

@section('affiliate_breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('affiliate.home') }}">Affiliate Home</a></li>
            <li class="breadcrumb-item active">{{$subscription->program->name}}</li>
        </ol>
    </nav>

@endsection
@section('affiliate_content')
    <subscribed-program-show program-uuid="{{$subscription->uuid}}"></subscribed-program-show>
@endsection