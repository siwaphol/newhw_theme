@extends('app')
@section('header_content')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection
@section('content')

<?php
$student=DB::select('select re.student_id as studentid,stu.firstname_th as firstname_th,stu.lastname_th as lastname_th,re.status as status
                      from course_student  re
                      left join users stu on re.student_id=stu.id
                      where re.course_id=? and  re.section=? and re.semester=? and re.year=?
                      order by re.student_id
                      ',array($course['co'],$course['sec'],Session::get('semester'),Session::get('year')));
$count=count($student);
 $coid=DB::select('select * from course_section c where c.course_id=? and c.section=? and c.semester=? and c.year=?',array($course['co'],$course['sec'],Session::get('semester'),Session::get('year')));
?>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">ข้อมูลนักศึกษา</div>
                    
                    <div class="panel-body">
                        <h3 align="center">กระบวนวิชา {{$course['co']}}  ตอน {{$course['sec']}} </h3>

                        <h4><a href="{{ url('/students/create/'.$coid[0]->id) }}">เพิ่มนักศึกษา</a></h4>

                         {!! Form::open(['url' => 'students/export']) !!}

                          <input type="hidden" name="course" id="course" value='{{$course['co']}}'>
                          <input type="hidden" name="sec" id="sec" value='{{$course['sec']}}'>

                          <button type="submit" class="btn btn-link">export csv</button>
                           {!! Form::close() !!}
                        <div class="table-responsive">
                            <table class="table" id="example" cellspacing="0" width="100%" >
                                 <thead>
                                   <tr>
                                      <th>รหัสนักศึกษา</th><th>ชื่อ-นามสกุล</th><th>สถานะ</th><th>delete</th>
                                  </tr>
                                   </thead>
                                   <tfoot>
                                   <tr>
                                      <th>รหัสนักศึกษา</th><th>ชื่อ-นามสกุล</th><th>สถานะ</th><th>delete</th>
                                  </tr>
                                   </tfoot>
                                   <tbody>
                                {{-- */$x=0;/* --}}
                                <?php
                                $item=$student;
                                    for($x=0;$x<$count;$x++){
                                ?>

                                    <tr>

                                        <td><a href="{{ url('/students/show', $item[$x]->studentid) }}">{{ $item[$x]->studentid }}</a></td>
                                        <td><a href="{{ url('/students/show', $item[$x]->studentid) }}">{{ $item[$x]->firstname_th." ".$item[$x]->lastname_th }}</a></td>
                                        <td>{{ $item[$x]->status}}</td>
                                        <!--
                                        <td><a href="{{ url('/students/edit/'.$item[$x]->studentid) }}">Edit</a> </td>
                                        -->
                                        <td>
                                               <?php
                                               $data=array('id'=>$item[$x]->studentid,'co'=>$course['co'],'sec'=>$course['sec']);
                                               ?>
                                            {!! Form::open(['url' => 'students/delete']) !!}

                                            <input type="hidden" name="course" id="course" value='{{$course['co']}}'>
                                            <input type="hidden" name="sec" id="sec" value='{{$course['sec']}}'>
                                            <input type="hidden" name="id" id="id" value='{{$item[$x]->studentid}}'>
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                            {!! Form::close() !!}
                                            </td>
                                    </tr>
                                <?php } ?>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>

  <script type="text/javascript">

$(document).ready(function() {
    $('#example').dataTable( {
        "order": [[ 3, "desc" ]],
        "scrollX": true
    } );
} );

    </script>
@endsection