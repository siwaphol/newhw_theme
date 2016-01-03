
@extends('app')

@section('css')
{{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"--}}
      {{--xmlns="http://www.w3.org/1999/html">--}}
 <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.css">

@endsection
@section('content')

<?php  $i=1;
              $coid=DB::select('select * from course_section c where c.course_id=? and c.section=? and c.semester=? and c.year=?',array($course['co'],$course['sec'],Session::get('semester'),Session::get('year')));

              $c=DB::select('select * from courses where id=?',array($course['co']));
              ?>

<div >

 <h3 align="center">Course {{$course['co']}}  {{$c[0]->name}} Section {{$course['sec']}} </h3>
  <!-- Nav tabs -->
</div>

<h4 align="center"> LECTURER </h4>
@foreach($teachers as $item)
<h5 align="center">{{$item->firstname.' '.$item->lastname}} </h5>
@endforeach
{{--<h4 align="center"> นักศึกษาช่วยสอน</h4>--}}
{{--@foreach($ta as $item)--}}
{{--<h5 align="center">{{$item->firstname.' '.$item->lastname.'   '.$item->ta_id}} </h5>--}}
{{--@endforeach--}}
@if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Teacher Assistant</div>

                    <div class="panel-body">
                        {{--<h1>semesteryears</h1>--}}
                        <button type="button" class="btn btn-default">{!! link_to_action('AssistantsController@create','เพิ่มนักศึกษาช่วยสอน',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>
                        <div class="table-responsive">
                            <table class="table" id="example" cellspacing="0" width="100%" >
                                <thead>
                                <tr>
                                    <th>No</th><th>Student ID/th><th>Name</th><th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No</th><th>Student ID/th><th>Name</th><th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                {{-- */$x=0;/* --}}
                                @foreach($ta as $item)
                                    {{-- */$x++;/* --}}
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td>{{ $item->ta_id }}</td>
                                        <td>{{ $item->firstname.' '.$item->lastname }}</td>
                                        {{--<td>{!! link_to_action('StudentsController@show',$item->ta_id,array('id'=>$item->ta_id,'course'=>$course['co'],'sec'=>$course['sec']))!!}</td>--}}

                                         {{--<td>{!! link_to_action('StudentsController@show',$item->firstname." ".$item->lastname,array('id'=>$item->ta_id,'course'=>$course['co'],'sec'=>$course['sec']))!!}</td>--}}


                                        <td>

                                         {!! Form::open(['url' => 'assistants/delete']) !!}

                                        <input type="hidden" name="course" id="course" value='{{$course['co']}}'>
                                        <input type="hidden" name="sec" id="sec" value='{{$course['sec']}}'>
                                        <input type="hidden" name="id" id="id" value='{{$item->ta_id}}'>
                                        <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure you want to delete student from this section?')">Delete</button>

                                        {!! Form::close() !!}

                                        </td>

                                        {{--<td> {!! Form::open(['method'=>'delete','action'=>['AssistantsController@destroy',$item->id]]) !!}<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</button>{!! Form::close() !!}</td>--}}

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
 @endif
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
{{--<button type="button" class="btn btn-default">{!! link_to_action('AssistantsController@create','เพิ่มนักศึกษาช่วยสอน',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>--}}
<button type="button" class="btn btn-default">{!! link_to_action('StudentsController@export','Export Excel',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>
<button type="button" class="btn btn-default">{!! link_to_action('AssistantsController@create','จัดการการบ้าน',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>
{{--<button type="button" class="btn btn-default">{!! link_to_action('CourseHomeworkController@result','ผลการส่งการบ้าน',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>--}}

@endif
</div>



               @if(Auth::user()->isTeacher()||Auth::user()->isAdmin())
               <?php
                         $student=DB::select('select re.student_id as studentid,stu.firstname_th as firstname_th,stu.lastname_th as lastname_th,re.status as status
                                               from course_student  re
                                               left join users stu on re.student_id=stu.id
                                               where re.course_id=? and  re.section=? and re.semester=? and re.year=?
                                               order by re.student_id
                                               ',array($course['co'],$course['sec'],Session::get('semester'),Session::get('year')));
                         $count=count($student);

                         ?>
                         @endif
                @if(Auth::user()->isStudent())
                <?php
                        $student=DB::select('select re.student_id as studentid,stu.firstname_th as firstname_th,stu.lastname_th as lastname_th,re.status as status
                                              from course_student  re
                                              left join users stu on re.student_id=stu.id
                                              where re.course_id=? and  re.section=? and re.semester=? and re.year=? and re.student_id=?
                                              order by re.student_id
                                              ',array($course['co'],$course['sec'],Session::get('semester'),Session::get('year'),Auth::user()->id));
                        $count=count($student);

                        ?>

                @endif

<?php

$month=array('01'=>'Jan',
             '02'=>'Feb',
             '03'=>'Mar',
             '04'=>'Apr',
             '05'=>'May',
             '06'=>'June',
             '07'=>'July',
             '08'=>'Aug',
             '09'=>'Sept',
             '10'=>'Oct',
             '11'=>'Nov',
             '12'=>'Dec'

);

?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                {{--<div class="panel-heading" align="center">ข้อมูลนักศึกษา</div>--}}

                                <div class="panel-body">
                                    {{--<h3 align="center">กระบวนวิชา {{$course['co']}}  ตอน {{$course['sec']}} </h3>--}}
                                     {{--<h4 align="center">รายชื่อนักศึกษา </h4>--}}

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
                                                {{--<th>Student ID</th><th>Name</th><th>Status</th>--}}
                                                @if(count($homework)>0)
                                                @foreach($homework as $key1)

                                                <?php
                                               $name= explode('{',$key1->name);
                                                ?>
                                                   <th>{{$key1->name}}<br/><span class="label label-warning"  >{{date("d", strtotime($key1->due_date)).$month[date("m", strtotime($key1->due_date))]}}</span><br/><span class="label label-danger">{{date("d", strtotime($key1->accept_date)).$month[date("m", strtotime($key1->accept_date))]}}</span></th>

                                                @endforeach
                                                @endif

                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                {{--<th>Student ID</th><th>Name</th><th>Status</th>--}}
                                                  @if(count($homework)>0)
                                                @foreach($homework as $key1)
                                                {{--@if(Auth::user()->isStudent())--}}
                                                    <th ><button type="button" data-path="{{$key1->path}}" data-fullpath="temp" data-template-name="{{$key1->name}}" data-type-id="{{$key1->type_id}}" data-homework-id="{{$key1->id}}" data-duedate="{{$key1->due_date}}" data-acceptdate="{{$key1->accept_date}}" class="btn btn-default student-button"><i class="fa fa-upload"></i></button></th>

                                                   {{--@endif--}}
                                                 {{--@if(Auth::user()->isTeacher()||Auth::user()->isAdmin()||Auth::user()->isStudentandTa())--}}
                                                  {{--<th><button type="button" class="btn btn-default">{!! link_to_action('AssistantsController@create','download',array('course'=>$course['co'],'sec'=>$course['sec'],'homeworkname'=>$key1->name))!!}</button></th>--}}

                                                 {{--@endif--}}

                                                @endforeach
                                                @endif


                                            </tr>
                                            </tfoot>
                                            {{-- */$x=0;/* --}}
                                            <tbody>
                                            @foreach($sent as $item)

                                                <tr>
                                                @if(Auth::user()->isAdmin()||Auth::user()->isTeacher())

                                                    {{--<td><a href="{{ url('/students/show', $item->studentid) }}">{{ $item->studentid }}</a></td>--}}
                                                    <td>{!! link_to_action('StudentsController@show',$item->studentid,array('id'=>$item->studentid,'course'=>$course['co'],'sec'=>$course['sec']))!!}</td>
                                                    {{--<td><a href="{{ url('/students/show', $item->studentid) }}">{{ $item->firstname." ".$item->lastname }}</a></td>--}}
                                                     <td>{!! link_to_action('StudentsController@show',$item->firstname." ".$item->lastname,array('id'=>$item->studentid,'course'=>$course['co'],'sec'=>$course['sec']))!!}</td>
                                                    <td>{{ $item->status}}</td>
                                                    @endif
                                                  @if(Auth::user()->isStudent()||Auth::user()->isStudentandTa())

                                                     {{--<td><a href="{{ url('/students/show', $item->studentid) }}">{{ $item->studentid }}</a></td>--}}
                                                     {{--<td>{{$item->studentid}}</td>--}}
                                                     {{--<td><a href="{{ url('/students/show', $item->studentid) }}">{{ $item->firstname." ".$item->lastname }}</a></td>--}}
                                                      {{--<td>{{$item->firstname." ".$item->lastname}}</td>--}}
                                                     {{--<td>{{ $item->status}}</td>--}}
                                                     @endif
                                                    <!--
                                                    <td><a href="{{ url('/students/edit/'.$item->studentid) }}">Edit</a> </td>
                                                    -->
                                                      @if(count($homework)>0)
                                                      @foreach($homework as $key2)

                                                       <?php
                                                        $sql=DB::select('select * from homework_student where homework_id = ? and student_id=?
                                                                          and course_id=? and section=?
                                                                          ',array($key2->id,$item->studentid,$course['co'],$course['sec']));
                                                        $hw=count($sql);

                                                        if($hw>0){
                                                           if($sql[0]->status==1){
                                                           echo "<td ><p align='center'>OK</p></td>";
                                                           }elseif($sql[0]->status==2){
                                                              echo "<td><p align='center'>lATE</p></td>";
                                                              }elseif($sql[0]->status==3){
                                                              echo "<td><p align='center'>!!!</p></td>";
                                                              }else{

                                                                 echo "<td ><p align='center'>-</p></td>";
                                                                }

                                                                }else{
                                                                echo "<td><p align='center'>-</p></td>";
                                                                }
                                                        ?>

                                                        @endforeach
                                                        @endif

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
<script type="text/javascript" src="{{ asset('/js/dropzone/dropzone.js') }}"></script>

<script src="//cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.js"></script>
{{--<script src="//cdn.datatables.net/fixedcolumns/3.0.3/js/dataTables.fixedColumns.js"></script>--}}

  <script type="text/javascript">

    var dzfullpath = $('.button-selected').attr('data-fullpath');
    var templatename = $('.button-selected').attr('data-template-name');
    var typeid = $('.button-selected').attr('data-type-id');
    var homework_id = '';
    var due_date = '';
    var accept_date = '';

$(document).ready(function() {
    $('#example').dataTable( {
        "order": [[ 3, "desc" ]],
        "scrollX": true
    } );
} );
//$(document).ready(function() {
//    $('#example1').dataTable( {
//        "order": [[ 0, "desc" ]],
//        "scrollX": true
//    } );
//} );
$(document).ready( function () {

    var table=$('#example1').dataTable( {
        "scrollX": true,
        @if(!\Auth::user()->isStudent())
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
        "sSwfPath": "//cdn.datatables.net/tabletools/2.2.4/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
                {
                    "sExtends": "xls",
                    "sButtonText": "Export report send homework with excel",
                    "sToolTip": "Export report send with excel",
                     "sMessage": "Generated by DataTables",
                    "sTitle": "Report Sending ",
                    "sFileName": "<?php echo $course['co']."-".$course['sec'] ?> - *.xls"
                }

            ]

        },

        "columnDefs": [
            {"sClass": "a-right",},
            { "width": "4%", "targets": 0 },
            { "width": "25%", "targets": 1 },
            { "width": "2%", "targets": 2 },
            { "bSortable": false, "aTargets": [ 0 ] }
          ]
@endif
    } );
     new $.fn.dataTable.FixedColumns( table, {
            leftColumns: 1

        } );
} );

$(".student-button").on('click',  function(){

    var path = $(this).attr("data-path");
    var fullpath = '{{\Session::get('semester')}}' + '_' + '{{\Session::get('year')}}' + '/'
    + '{{$course['co']}}' + '/' + '{{$course['sec']}}' + '/' + path.replace('./','');

    $(this).attr('data-fullpath', fullpath);
    $('button').removeClass('button-selected');
    $(this).toggleClass('button-selected');
    dzfullpath = $('.button-selected').attr('data-fullpath');
    templatename = $('.button-selected').attr('data-template-name');
    typeid = $('.button-selected').attr('data-type-id');
    homework_id =  $('.button-selected').attr('data-homework-id');
    due_date = $('.button-selected').attr('data-duedate');
    accept_date = $('.button-selected').attr('data-acceptdate');
    $('#upload-modal').modal('toggle');
});

    </script>
@include('partials.dropzone')
@endsection