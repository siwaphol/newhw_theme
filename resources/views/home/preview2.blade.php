
@extends('app')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"
      xmlns="http://www.w3.org/1999/html">
@endsection
@section('content')

<?php  $i=1;
              $coid=DB::select('select * from course_section c where c.course_id=? and c.section=? and c.semester=? and c.year=?',array($course['co'],$course['sec'],Session::get('semester'),Session::get('year')));?>

<div >
 <h3 align="center">กระบวนวิชา {{$course['co']}}  ตอน {{$course['sec']}} </h3>
  <!-- Nav tabs -->
</div>
<h4 align="center"> อาจารย์ผู้สอน </h4>
@foreach($teachers as $item)
<h5 align="center">{{$item->firstname.' '.$item->lastname}} </h5>
@endforeach
<h4 align="center"> นักศึกษาช่วยสอน</h4>
@foreach($ta as $item)
<h5 align="center">{{$item->firstname.' '.$item->lastname.'   '.$item->ta_id}} </h5>
@endforeach
<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">นักศึกษาช่วยสอน</div>

                    <div class="panel-body">
                        {{--<h1>semesteryears</h1>--}}
                        <button type="button" class="btn btn-default">{!! link_to_action('AssistantsController@create','เพิ่มนักศึกษาช่วยสอน',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>
                        <div class="table-responsive">
                            <table class="table" id="example" cellspacing="0" width="100%" >
                                <thead>
                                <tr>
                                    <th>No</th><th>รหัส</th><th>ชื่อ</th><th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No</th><th>รหัส</th><th>ชื่อ</th><th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                {{-- */$x=0;/* --}}
                                @foreach($ta as $item)
                                    {{-- */$x++;/* --}}
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td><a href="{{ url('/semesteryear/show', $item->ta_id) }}">{{ $item->ta_id }}</a></td>
                                        <td><a href="{{ url('/semesteryear/show', $item->ta_id) }}">{{ $item->firstname.' '.$item->lastname }}</a></td>

                                        <td> {!! Form::open(['method'=>'delete','action'=>['SemesteryearController@destroy',$item->ta_id]]) !!}<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</button>{!! Form::close() !!}</td>

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
<div class="col-md-10 col-md-offset-2">
@if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
{{--<div class="dropdown">--}}
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
   <a>เพิ่มนักศึกษา</a>
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><button type="button" class="btn btn-default">{!! link_to_action('StudentsController@insert','เพิ่มรายชื่อนักศึกษาจากสำนักทะเบียน',array('ddlCourse'=>$course['co'],'ddlSection'=>$course['sec']))!!}</button>
    </li>
    <li><button type="button" class="btn btn-default">{!! link_to_action('StudentsController@selectexcel','เพิ่มรายชื่อนักศึกษาจากไฟล์ Excel',array('ddlCourse'=>$course['co'],'ddlSection'=>$course['sec']))!!}</button>
    </li>
    <li><a href="{{ url('/students/create/'.$coid[0]->id) }}"class="btn btn-default">เพิ่มนักศึกษารายบุคคล</a></li>

  </ul>
{{--</div>--}}
{{--<button type="button" class="btn btn-default">{!! link_to_action('StudentsController@insert','เพิ่มรายชื่อนักศึกษาจากสำนักทะเบียน',array('ddlCourse'=>$course['co'],'ddlSection'=>$course['sec']))!!}</button>--}}
{{--<button type="button" class="btn btn-default">{!! link_to_action('StudentsController@selectexcel','เพิ่มรายชื่อนักศึกษาจากไฟล์ Excel',array('ddlCourse'=>$course['co'],'ddlSection'=>$course['sec']))!!}</button>--}}
<button type="button" class="btn btn-default">{!! link_to_action('AssistantsController@create','เพิ่มนักศึกษาช่วยสอน',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>
<button type="button" class="btn btn-default">{!! link_to_action('StudentsController@export','Export CSV',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>
<button type="button" class="btn btn-default">{!! link_to_action('AssistantsController@create','จัดการการบ้าน',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>
<button type="button" class="btn btn-default">{!! link_to_action('CourseHomeworkController@result','ผลการส่งการบ้าน',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>

@endif
</div>


<?php
            $student=DB::select('select re.student_id as studentid,stu.firstname_th as firstname_th,stu.lastname_th as lastname_th,re.status as status
                                  from course_student  re
                                  left join users stu on re.student_id=stu.id
                                  where re.course_id=? and  re.section=? and re.semester=? and re.year=?
                                  order by re.student_id
                                  ',array($course['co'],$course['sec'],Session::get('semester'),Session::get('year')));
            $count=count($student);

            ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                {{--<div class="panel-heading" align="center">ข้อมูลนักศึกษา</div>--}}

                                <div class="panel-body">
                                    {{--<h3 align="center">กระบวนวิชา {{$course['co']}}  ตอน {{$course['sec']}} </h3>--}}
                                     <h4 align="center">รายชื่อนักศึกาษา </h4>

                                    {{--<h4><a href="{{ url('/students/create/'.$coid[0]->id) }}">เพิ่มนักศึกษา</a></h4>--}}

                                     {{--{!! Form::open(['url' => 'students/export']) !!}--}}

                                      {{--<input type="hidden" name="course" id="course" value='{{$course['co']}}'>--}}
                                      {{--<input type="hidden" name="sec" id="sec" value='{{$course['sec']}}'>--}}

                                      {{--<button type="submit" class="btn btn-link">export csv</button>--}}
                                       {{--{!! Form::close() !!}--}}
                                    <div class="table-responsive">
                                        <table class="table" id="example1" cellspacing="0" width="100%" >
                                           <thead>
                                            <tr>
                                                <th>รหัสนักศึกษา</th><th>ชื่อ-นามสกุล</th><th>สถานะ</th>
                                                @foreach($homework as $key1)
                                                   <th>{{$key1->name}}</th>

                                                @endforeach
                                                <th>delete</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>รหัสนักศึกษา</th><th>ชื่อ-นามสกุล</th><th>สถานะ</th>
                                                @foreach($homework as $key1)
                                                   <th>{{$key1->name}}</th>

                                                @endforeach
                                             <th>delete</th>

                                            </tr>
                                            </tfoot>
                                            {{-- */$x=0;/* --}}
                                            <tbody>
                                            @foreach($sent as $item)

                                                <tr>

                                                    {{--<td><a href="{{ url('/students/show', $item->studentid) }}">{{ $item->studentid }}</a></td>--}}
                                                    <td>{!! link_to_action('StudentsController@show',$item->studentid,array('id'=>$item->studentid,'course'=>$course['co'],'sec'=>$course['sec']))!!}</td>
                                                    {{--<td><a href="{{ url('/students/show', $item->studentid) }}">{{ $item->firstname." ".$item->lastname }}</a></td>--}}
                                                     <td>{!! link_to_action('StudentsController@show',$item->firstname." ".$item->lastname,array('id'=>$item->studentid,'course'=>$course['co'],'sec'=>$course['sec']))!!}</td>
                                                    <td>{{ $item->status}}</td>
                                                    <!--
                                                    <td><a href="{{ url('/students/edit/'.$item->studentid) }}">Edit</a> </td>
                                                    -->

                                                      @foreach($homework as $key2)
                                                       <?php
                                                        $sql=DB::select('select * from homework_student where homework_id = ? and student_id=?
                                                                          and course_id=? and section=?
                                                                          ',array($key2->id,$item->studentid,$course['co'],$course['sec']));
                                                        $hw=count($sql);

                                                        if($hw>0){
                                                           if($sql[0]->status==1){
                                                           echo "<td>ok</td>";
                                                           }elseif($sql[0]->status==2){
                                                              echo "<td>late</td>";
                                                              }elseif($sql[0]->status==3){
                                                              echo "<td>!!!</td>";
                                                              }else{

                                                                 echo "<td>No</td>";
                                                                }

                                                                }else{
                                                                echo "<td>No</td>";
                                                                }
                                                        ?>

                                                        @endforeach
                                                 <td>
                                                       <?php
                                                       $data=array('id'=>$item->studentid,'co'=>$course['co'],'sec'=>$course['sec']);
                                                       ?>
                                                    {!! Form::open(['url' => 'students/delete']) !!}

                                                    <input type="hidden" name="course" id="course" value='{{$course['co']}}'>
                                                    <input type="hidden" name="sec" id="sec" value='{{$course['sec']}}'>
                                                    <input type="hidden" name="id" id="id" value='{{$item->studentid}}'>
                                                    <button type="submit" class="btn btn-danger btn-ok" onclick="return confirm('Are you sure you want to delete student from this section?')">Delete</button>

                                                    {!! Form::close() !!}

                                                     {{--<td>{!! link_to_action('StudentsController@destroy','Delete',array('id'=>$item[$x]->studentid,'course'=>$course['co'],'sec'=>$course['sec']),onclick="return confirm('Are you sure you want to delete?')")!!}</td>--}}

                                                    </td>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>

  <script type="text/javascript">

$(document).ready(function() {
    $('#example').dataTable( {
        "order": [[ 3, "desc" ]],
        "scrollX": true
    } );
} );
$(document).ready(function() {
    $('#example1').dataTable( {
        "order": [[ 3, "desc" ]],
        "scrollX": true
    } );
} );


    </script>

@endsection