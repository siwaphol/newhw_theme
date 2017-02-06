@extends('app')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Successfull</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table" id="example" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Status</th>
                                    <th>Student</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Status</th>
                                    <th>Student</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($importStatus as $status)
                                <tr>
                                    <td>{{ $status->course_id }}</td>
                                    <td>{{ $status->section }}</td>
                                    <td>{!!  ($status->status===\App\User::IMPORT_SUCCESS?
                                    '<span class="label label-success">Success</span>'
                                    :'<span class="label label-danger">Not found</span>') !!}</td>
                                    <td>{{$status->amount}}</td>
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
    <script type="text/javascript">

        $(document).ready(function () {
            $('#example').dataTable({
                "order": [[3, "desc"]],
                "scrollX": true
            });
        });
        $(document).ready(function () {
            $('#example1').dataTable({
                "order": [[3, "desc"]],
                "scrollX": true
            });
        });

    </script>
@endsection
