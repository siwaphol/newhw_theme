@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Datail Homework</div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>ID.</th>
                                    <th>Name</th><th>type</th><th>detail</th><th>subfolder</th>
                                    <th>Duedate</th><th>Acceptdate</th>
                                </tr>
                                <tr>
                                    <td>{{ $homework1->id }}</td><td>{{ $homework1->name }}</td>
                                    <td>{{ $homework1->type_id }}</td>
                                    <td>{{ $homework1->detail }}</td>
                                    <td>{{ $homework1->sub_folder }}</td>
                                    <td>{{ $homework1->due_date }}</td>
                                    <td>{{ $homework1->acceppt_date }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection