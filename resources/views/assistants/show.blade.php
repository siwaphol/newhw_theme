@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">นักศึกษาช่วยสอน</div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>รหัส</th><th>Name</th>
                                </tr>
                                <tr>
                                    <td>{{ $assistant[0]->student_id }}</td><td>{{ $assistant[0]->firstname." ".$assistant[0]->lastname }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection