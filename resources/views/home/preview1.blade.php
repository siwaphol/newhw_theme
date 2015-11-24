
@extends('app')
@section('content')

<script type="javascript">
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
$('#myTabs a[href="#profile"]').tab('show') // Select tab by name
$('#myTabs a:first').tab('show') // Select first tab
$('#myTabs a:last').tab('show') // Select last tab
$('#myTabs li:eq(2) a').tab('show')
</script>
<div >

 <h3 align="center">กระบวนวิชา {{$course['co']}}  ตอน {{$course['sec']}} </h3>
  <!-- Nav tabs -->

  <ul class="nav nav-pills nav-justified" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">รายชื่อนักศึกษา</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">นักศึกษาช่วยสอน</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">อาจารย์ผู้สอน</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
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
                                {{--<div class="panel-heading" align="center">ข้อมูลนักศึกษา</div>--}}

                                <div class="panel-body">
                                    <h3 align="center">กระบวนวิชา {{$course['co']}}  ตอน {{$course['sec']}} </h3>

                                    <h4><a href="{{ url('/students/create/'.$coid[0]->id) }}">เพิ่มนักศึกษา</a></h4>

                                     {!! Form::open(['url' => 'students/export']) !!}

                                      <input type="hidden" name="course" id="course" value='{{$course['co']}}'>
                                      <input type="hidden" name="sec" id="sec" value='{{$course['sec']}}'>

                                      <button type="submit" class="btn btn-link">export csv</button>
                                       {!! Form::close() !!}
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th>No</th><th>รหัสนักศึกษา</th><th>ชื่อ-นามสกุล</th><th>สถานะ</th><th>delete</th>
                                            </tr>
                                            {{-- */$x=0;/* --}}
                                            <?php
                                            $item=$student;
                                                for($x=0;$x<$count;$x++){
                                            ?>

                                                <tr>
                                                    <td>{{ $x+1 }}</td>
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
                                                        <button type="submit" class="btn btn-link">Delete</button>
                                                        {!! Form::close() !!}
                                                        </td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
    <?php
    $assistants=DB::select('select  ta.username as username
                            ,ass.id as id
                            ,ass.student_id as taid
                            ,ta.firstname_th as firstname
                            ,ta.lastname_th as lastname
                            from course_ta ass
                            left join users ta on ass.student_id=ta.id and ta.role_id=0010
                          where ass.course_id=? and  section=?',array($course['co'],$course['sec']));
    $count=count($assistants);
    $item=$assistants;
    ?>


        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">มอบหมายงานนักศึกษาช่วยสอน</div>

                        <div class="panel-body">
                            {{--<h3 align="center" >กระบวนวิชา {{$course['co']}} ตอน {{$course['sec']}}</h3>--}}
                            <h4><a>{!! link_to_action('AssistantsController@create','เพิ่ม',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</a></h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>No</th><th>Name</th><th>Actions</th>
                                    </tr>
                                    {{-- */$x=0;/* --}}
                                    <?php
                                    for($x=0;$x<$count;$x++){
                                    ?>

                                        <tr>
                                            <td>{{ $x+1 }}</td><td><a href="{{ url('/assistants/show', $item[$x]->username) }}">{{ $item[$x]->firstname." ".$item[$x]->lastname }}</a></td>
                                            <td><a>{!! link_to_action('AssistantsController@edit','Edit',array('username'=>$item[$x]->username,'course'=>$course['co'],'sec'=>$course['sec']))!!}</a>
     /                                              <a>{!! link_to_action('AssistantsController@destroy','Delete',array('id'=>$item[$x]->taid,'course'=>$course['co'],'sec'=>$course['sec']))!!}</a></td>

                                        </tr>
                                        <?php  } ?>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div role="tabpanel" class="tab-pane" id="messages">

     <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">อาจารย์</div>

                        <div class="panel-body">

                            <h4><a href="{{ url('/teachers/create') }}">เพิ่มอาจารย์</a></h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>No</th><th>ชื่อนามสกุล</th><th>edit</th><th>delete</th>
                                    </tr>
                                    {{-- */$x=0;/* --}}
                                    @foreach($teachers as $item)
                                        {{-- */$x++;/* --}}
                                        <tr>
                                            <td>{{ $x }}</td>
                                            <td><a href="{{ url('/teachers/show', $item->teacher_id) }}">{{ $item->firstname." ".$item->lastname }}</a></td>
                                            <td><a href="{{ url('/teachers/'.$item->teacher_id.'/edit') }}">Edit</a></td>
                                            <td> {!! Form::open(['method'=>'post','action'=>array('TeachersController@destroy',$item->teacher_id)]) !!}<button type="submit" class="btn btn-link">Delete</button>{!! Form::close() !!}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="settings">444</div>
  </div>

</div>


@endsection