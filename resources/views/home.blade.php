@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>You are logged in!</p>
                    @role('admin')
                    <a class="btn" href="{{url('/admin/users')}}">Admin Area</a>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
