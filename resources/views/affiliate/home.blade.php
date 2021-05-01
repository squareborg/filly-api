@extends('affiliate.layout')

@section('affiliate_breadcrumb')
@endsection
@section('affiliate_content')
<affiliate-home
    :subscriptions="{{json_encode($mySubscriptions)}}"
    :total-clicks="{{$user->clicks}}"
    :total-sales="{{$user->sales->count()}}"
    :programs="{{json_encode($programs)}}"
    :program-categories="{{json_encode($programCategories)}}"
    :merchants="{{json_encode($merchants)}}"
    >
</affiliate-home>
@endsection
