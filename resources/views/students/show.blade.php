@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Student</div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>รหัส</th><th>Name</th><th>คณะ</th><th>อีเมล</th><th>สถานะ</th><th>Delete</th>
                                </tr>

                                @foreach( $student as $result)
                                <tr>
                                <?php $role_id=$result->role_id;
                                        $student_id=$result->student_id;
                                ?>
                                    <td>{{$result->student_id}}</td><td>{{$result->firstname." ".$result->lastname}}</td><td>{{$result->faculty}}</td><td>{{$result->email}}</td><td>{{$result->status}}</td>
                                 <td>
                                         {!! Form::open(['url' => 'students/delete']) !!}

                                        <input type="hidden" name="course" id="course" value='{{$course['co']}}'>
                                        <input type="hidden" name="sec" id="sec" value='{{$course['sec']}}'>
                                        <input type="hidden" name="id" id="id" value='{{$result->student_id}}'>
                                        <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure you want to delete student from this section?')">Delete</button>

                                        {!! Form::close() !!}
                                        </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@if($role_id=='0011'||$role_id=='0010')

<?php
$sql=DB::select('select cs.course_id,co.name ,cs.section  from course_ta cs
                  left join courses co on cs.course_id=co.id
                  where cs.student_id=? and cs.semester=? and cs.year=?
                  ',array($student_id,Session::get('semester'),Session::get('year')));

$counr=count($sql);

?>
<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Course Assistant</div>

                    <div class="panel-body">

     <div class="table-responsive">
    <table class="table">
        <tr>
            <th>No</th><th>Course No</th><th>Title</th><th>Section</th>
        </tr>
        <?php
            for($i=0;$i<$counr;$i++){
            ?>
        <tr>
            <td>{{ $i+1 }}</td><td>{{ $sql[$i]->course_id }}</td><td>{{ $sql[$i]->name }}</td><td>{{ $sql[$i]->section }}</td>

        </tr>
       <?php } ?>
    </table>
</div>
</div>
</div>
</div>
</div>
</div>
@endif
@endsection