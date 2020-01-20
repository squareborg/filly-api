@extends('admin.layout')

@section('admin_content')
    <h2 class="mb-3">Edit Category {{$programCategory->id}}</h2>
    <div class="lg: w-50">
    {!! Form::model($programCategory, ['route' => ['admin.categories.update', $programCategory->id]])!!}
    <div class="form-group">
        {!! Form::label('name', 'Category Name', ['class' => 'awesome']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
    </div>
@endsection
