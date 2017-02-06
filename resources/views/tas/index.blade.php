@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <div class="panel-title">
                            Teaching Assistant
                        </div>
                        <div class="heading-elements">
                            <div class="btn-group heading-btn">
                                <button type="button" class="btn btn-default btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-person"></i> Course<span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{url('ta/create')}}">Add TA</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
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
@section('script')
    <script src="https://unpkg.com/axios@0.12.0/dist/axios.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').dataTable({
                "order": [[3, "desc"]],
                "scrollX": true
            });
        });
    </script>

@endsection