@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">LECTURER</div>

                    <div class="panel-body">
                        <div class="" style="padding-bottom: 5px;"><a class="btn btn-default" href="{{ url('/teachers/create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Lecturer</a></div>
                        <div class="table-responsive">
                            <table class="table" id="data_table_for_teacher" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($teachers as $item)
                                    <tr>
                                        <td>
                                            <a type="button" class="btn btn-link" href="{{ url('/teachers/show', $item->id) }}">{{ $item->firstname_en." ".$item->lastname_en }}</a>
                                        </td>
                                        <td>
                                            <a type="button" class="btn btn-link" href="{{ url('/teachers/'.$item->id.'/edit') }}">Edit</a>
                                        </td>
                                        <td> {!! Form::open(['method'=>'post','action'=>array('TeachersController@destroy',$item->id)]) !!}
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
            $('#data_table_for_teacher').dataTable({
                "order": [[0, "asc"]],
                "scrollX": true
            });
        });
    </script>
@endsection