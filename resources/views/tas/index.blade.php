@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Teaching Assistant</div>

                    <div class="panel-body">
                        <div class="" style="padding-bottom: 5px;"><a class="btn btn-default" href="{{ url('/ta/create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add TA</a></div>
                        <div class="table-responsive">
                            <table class="table" id="example" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                {{-- */$x=0;/* --}}
                                @foreach($tas as $item)
                                    {{-- */$x++;/* --}}
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td><a href="{{ url('/ta/show', $item->id) }}">{{ $item->student_id }}</a></td>
                                        <td>
                                            <a href="{{ url('/ta/show', $item->id) }}">{{ $item->firstname_th." ".$item->lastname_th }}</a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-link"><a
                                                        href="{{ url('/students/edit/'.$item->student_id) }}">Edit</a>
                                            </button>
                                        </td>
                                        <td> {!! Form::open(['method'=>'delete','action'=>array('StudentsController@destroy',$item->student_id)]) !!}
                                            <button type="submit" class="btn btn-link"
                                                    onclick="return confirm('Are you sure you want to delete?')">Delete
                                            </button>{!! Form::close() !!}</td>
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
@section('footer')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').dataTable({
                "order": [[3, "desc"]],
                "scrollX": true
            });
        });
    </script>

@endsection