@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Lecturer</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Edit</th>
                                </tr>
                                <tr>
                                    <td>{{ $teacher->id }}</td>
                                    <td>{{ $teacher->username }}</td>
                                    <td>{{ $teacher->firstname_th." ".$teacher->lastname_th }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td><a type="button" class="btn btn-default" href="{{ url('/teachers/'.$teacher->id.'/edit') }}"><i class="icon-pencil position-left"></i> Edit</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Course</div>

                    <div class="panel-body">

     <div class="table-responsive">
    <table class="table">
        <tr>
            <th>Course No</th>
            <th>Title</th>
            <th>Section</th>
        </tr>
        @foreach($courseSec as $aCourseSec)
        <tr>
            <td>{{ $aCourseSec->course_id }}</td><td>{{ $aCourseSec->course_name }}</td><td>{{ $aCourseSec->section }}</td>
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