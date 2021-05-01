@extends('admin.layout')

@section('admin_breadcrumb')
<li class="breadcrumb-item active">Users</li>
@endsection
@section('admin_content')
    <a class="btn btn-primary mb-2" href="/admin/users/create"><i class="fa fa-plus"></i> Create User</a>
    <users-list></users-list>
@endsection
