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
    
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('affiliate.home')}}">Affiliate</a></li>
        @yield('affiliate_breadcrumb')
    </ol>
    </nav>

    <h2>@yield('affiliate_title')</h2>
        @yield('affiliate_content')
    </div>
</div>
@endsection

