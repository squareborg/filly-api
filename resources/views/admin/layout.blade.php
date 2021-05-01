@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">

        <div class="row">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
    <div class="container">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'admin/categories' ? 'active' : ''}}" href="{!! route('admin.categories.index')!!}">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'admin/programs' ? 'active' : ''}}" href="{!! route('admin.programs.index')!!}">Programs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'admin/users' ? 'active' : ''}}" href="{!! route('admin.users.index')!!}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'admin/sales' ? 'active' : ''}}" href="{!! route('admin.sales.index')!!}">Sales</a>
                </li>
            </ul>
            <notifications group="main"></notifications>
    <h2>@yield('admin_title')</h2>
        @yield('admin_content')
    </div>
</div>
@endsection

