@extends('layouts.app')

@section('content')
<div class="container">
    <program-edit  @role('admin') :admin="true" @endrole program-uuid="{{$uuid}}"></program-edit>
</div>
@endsection
