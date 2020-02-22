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
            <notifications group="main"></notifications>

<h2>@yield('affiliate_title')</h2>
@yield('affiliate_content')
</div>
</div>
@endsection

