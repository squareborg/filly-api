@extends('admin.layout')

@section('admin_breadcrumb')
<li class="breadcrumb-item active">Users</li>
@endsection
@section('admin_content')
    <programs-approval-queue></programs-approval-queue>
    <admin-programs-list></admin-programs-list>
@endsection
