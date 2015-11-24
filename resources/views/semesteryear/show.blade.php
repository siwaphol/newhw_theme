@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Semester Year</div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>ID.</th><th>Semester</th><th>Year</th><th>Status</th>
                                </tr>
                                <tr>
                                    <td>{{ $semesteryear->id }}</td>
                                    <td>{{ $semesteryear->semester }}</td>
                                    <td>{{ $semesteryear->year }}</td>
                                    @if($semesteryear->use=="1")
                                    <td>Open</td>
                                    @endif
                                    @if($semesteryear->use=="0")
                                    <td>Close</td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection