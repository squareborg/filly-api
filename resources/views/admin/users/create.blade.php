@extends('admin.layout')

@section('admin_breadcrumb')
<li class="breadcrumb-item"><a href="/admin/users/">Users</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection
@section('admin_content')
    <user-create></user-create>
@endsection