@extends('app')

@section('content')
<?php  echo var_dump($homework_assignments);?>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    
                    <div class="panel-body">
                        <h1>homework_assignments{{$course}}</h1>
                        <h2><a href="{{ url('/homework_assignment/create',$course) }}">Create</a></h2>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>SL.</th><th>Name</th><th>Actions</th>
                                </tr>
                                {{-- */$x=0;/* --}}
                                @foreach($homework_assignments as $item)
                                    {{-- */$x++;/* --}}
                                    <tr>
                                        <td>{{ $x }}</td><td><a href="{{ url('homework_assignment/show', $item->id) }}">{{ $item->homeworkFileName }}</a></td>
                                        <td><a href="{{ url('/homework_assignment/'.$item->id.'/edit') }}">Edit</a> /
                                        {{ Form::open(['method'=>'delete','action'=>['Homework_assignmentController@destroy',$item->id]]) }}<button type="submit" class="btn btn-link">Delete</button>{{ Form::close() }}</td>
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