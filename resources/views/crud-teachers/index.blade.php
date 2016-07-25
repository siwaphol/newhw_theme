@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    
                    <div class="panel-body">
                        <h1>crud-teachers</h1>
                        <h2><a href="{{ url('/crud-teachers/create') }}">Create</a></h2>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>SL.</th><th>Name</th><th>Actions</th>
                                </tr>
                                @foreach($crud_teachers as $item)
                                    <tr>
                                        <td>{{ $x }}</td><td><a href="{{ url('/crud-teachers', $item->id) }}">{{ $item->name }}</a></td><td><a href="{{ url('/crud-teachers/'.$item->id.'/edit') }}">Edit</a> / {{ Form::open(['method'=>'delete','action'=>['Crud-teachersController@destroy',$item->id]]) }}<button type="submit" class="btn btn-link">Delete</button>{{ Form::close() }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection