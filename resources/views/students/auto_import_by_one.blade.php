@extends('app')

@section('css')

@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <div class="panel-title">
                            Course Section List
                        </div>
                    </div>
                    <div class="panel-body">
                        <h4 align="center">Students Import By Course Section Select</h4>
                        <div class="table-responsive">
                            <table class="table" id="course-section-table" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Course No</th>
                                    <th>Section</th>
                                    <th>Import</th>
                                </tr>
                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Course No</th>
                                    <th>Section</th>
                                    <th>Import</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($courseSections as $cs)
                                    <tr>
                                        <td>{{$cs->course_id}}</td>
                                        <td>{{$cs->section}}</td>
                                        <td><a
                                                    href="{{url('students/import')}}/{{$cs->course_id}}/{{$cs->section}}"
                                                    class="btn btn-default">Import</a></td>
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
    <script>
        $('#course-section-table').DataTable();
    </script>
@endsection