@extends('admin.layout')
@section('admin_breadcrumb')
<li class="active"><a href="{{url('/admin/users')}}">Users</a></li>
<li class="active">{{$user->name}}</li>
@endsection
@section('admin_content')
   <user-detail :user-id="{{$user->id}}"></user-detail>
@endsection