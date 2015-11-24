@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Homework</div>
                    <h4 align="center"> course {{$course['course']}} section {{$course['sec']}}</h4>
                    <div class="panel-body">

                        <button type="button" class="btn btn-default">{!! link_to_action('Homework1Controller@create','Create',array('course'=>$course['course'],'sec'=>$course['sec']))!!}</button>

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>SL.</th><th>Name</th><th>Actions</th>
                                </tr>
                                {{-- */$x=0;/* --}}
                                @foreach($homework1s as $item)
                                    {{-- */$x++;/* --}}
                                    <tr>
                                        <td>{{ $x }}</td><td><a href="{{ url('/homework/show', $item->id) }}">{{ $item->name }}</a></td><td><a href="{{ url('/homework/'.$item->id.'/edit') }}">Edit</a> / {!! Form::open(['method'=>'delete','action'=>['Homework1Controller@destroy',$item->id]]) !!}<button type="submit" class="btn btn-link">Delete</button>{!! Form::close() !!}</td>
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