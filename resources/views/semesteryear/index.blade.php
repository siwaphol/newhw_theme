@extends('app')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Manage Semester Year</div>
                    
                    <div class="panel-body">
                        {{--<h1>semesteryears</h1>--}}
                        <h4><a href="{{ url('/semesteryear/create') }}" class="btn btn-default">Add Semester</a></h4>
                        <div class="table-responsive">
                            <table class="table" id="example" cellspacing="0" width="100%" >
                                <thead>
                                <tr>
                                    <th>No</th><th>Semester<th>Year</th><th>Status</th><th>Edit</th><th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No</th><th>Semester<th>Year</th><th>Status</th><th>Edit</th><th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                {{-- */$x=0;/* --}}
                                @foreach($semesteryears as $item)
                                    {{-- */$x++;/* --}}
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td><a href="{{ url('/semesteryear/show', $item->id) }}">{{ $item->semester }}</a></td>
                                        <td><a href="{{ url('/semesteryear/show', $item->id) }}">{{ $item->year }}</a></td>
                                        @if($item->use=="1")
                                        <td>Open</td>
                                        @endif
                                        @if($item->use=="0")
                                        <td>Close</td>
                                        @endif

                                        <td><a href="{{ url('/semesteryear/'.$item->id.'/edit') }}" class="btn btn-link">Edit</a>
                                        </td>
                                        <td> {!! Form::open(['method'=>'delete','action'=>['SemesteryearController@destroy',$item->id]]) !!}<button type="submit" class="btn btn-link" onclick="return confirm('Are you sure you want to delete?')">Delete</button>{!! Form::close() !!}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>

  <script type="text/javascript">

$(document).ready(function() {
    $('#example').dataTable( {
        "order": [[ 3, "desc" ]],
        "scrollX": true
    } );
} );

    </script>
@endsection