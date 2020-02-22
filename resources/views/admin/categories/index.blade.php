@extends('admin.layout')

@section('headjs')
<script>
        function checkDelete(e, catid){
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this category, all programs with this category will need a new category choosing",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    window.location.href = route('admin.categories.destroy', catid)
                }
              });
        }
    </script>
@endsection
@section('admin_content')
    <table class="table border bg-white mt-2">
        <thead>
            <th>Name</th><th>Actions</th>
        </thead>
        @foreach($categories as $category)
            <tr><td>{{$category->name}}</td><td><a href="{!! route('admin.categories.edit', $category) !!}" class="btn btn-secondary">Rename</a> <a onclick="checkDelete(event, {{$category->id}} )" href="#" class="btn btn-danger">Delete</a></td></tr>
        @endforeach
    </table>
    {!! Form::open(['route' => 'admin.categories.store']) !!}
    <div class="form-group">

    {!! Form::label('name', 'New Category name') !!}

    {!! Form::text('name', null, ['class' => 'form-control']) !!}

    </div>
    {!! Form::submit('Add category', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}

@endsection
