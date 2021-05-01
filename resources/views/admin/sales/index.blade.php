@extends('admin.layout')

@section('admin_breadcrumb')
<li class="breadcrumb-item active">Sales</li>
@endsection
@section('admin_content')
    <admin-sales :sales="{{json_encode($sales)}}"></admin-sales>
@endsection
