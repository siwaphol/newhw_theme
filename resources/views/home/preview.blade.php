@extends('app')

@section('header_content')


    {{--<link rel="stylesheet" href="{{ asset('/css/dropzone/basic.css') }}"/>--}}
    <link rel="stylesheet" href="{{ asset('/css/dropzone/dropzone.css') }}"/>
    {{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"--}}
    {{--xmlns="http://www.w3.org/1999/html">--}}
    {{--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.css">--}}
    <link rel="stylesheet" href="{{ asset('/libs/datatables/tabletools-2.2.4/css/dataTables.tableTools.css') }}"/>
    {{--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/libs/font-awesome-4.4.0/css/font-awesome.min.css') }}"/>
    {{--<link rel="stylesheet" type="text/css" href=" //cdn.datatables.net/fixedcolumns/3.0.3/css/dataTables.fixedColumns.css">--}}
    {{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"--}}
    {{--xmlns="http://www.w3.org/1999/html">--}}

@endsection
@section('content')

    <?php  $i = 1;
    $coid = DB::select('select * from course_section c where c.course_id=? and c.section=? and c.semester=? and c.year=?', array($course['co'], $course['sec'], Session::get('semester'), Session::get('year')));

    $c = DB::select('select * from courses where id=?', array($course['co']));
    ?>

    <div>

        <h3 align="center">{{$course['co']}} || {{$c[0]->name}} || {{$course['sec']}} </h3>
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
                        <div class="panel-heading" align="center">Teaching Assistant</div>

                        <div class="panel-body">
                            {{--<h1>semesteryears</h1>--}}
                            {{--<button type="button" class="btn btn-default">{!! link_to_action('AssistantsController@create','Add Teaching Assistant',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</button>--}}
                            {!! link_to_action('AssistantsController@create','Add Teaching Assistant',array('course'=>$course['co'],'sec'=>$course['sec']),array('role'=>'button','class'=>'btn btn-default'))!!}

                            <div class="table-responsive">
                                <table class="table" id="example" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Student ID
                                        <th>Name</th>
                                        <th>Delete</th>

                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Student ID
                                        <th>Name</th>
                                        <th>Delete</th>
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

                                                <input type="hidden" name="course" id="course"
                                                       value='{{$course['co']}}'>
                                                <input type="hidden" name="sec" id="sec" value='{{$course['sec']}}'>
                                                <input type="hidden" name="id" id="id" value='{{$item->ta_id}}'>
                                                <button type="submit" class="btn btn-link"
                                                        onclick="return confirm('Are you sure you want to delete student from this section?')">
                                                    Delete
                                                </button>

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

    @if(Auth::user()->isTeacher()||Auth::user()->isAdmin()||Auth::user()->isTa())
        <?php
        $student = DB::select('select re.student_id as studentid,stu.firstname_th as firstname_th,stu.lastname_th as lastname_th,re.status as status
                                               from course_student  re
                                               left join users stu on re.student_id=stu.id
                                               where re.course_id=? and  re.section=? and re.semester=? and re.year=?
                                               order by re.student_id
                                               ', array($course['co'], $course['sec'], Session::get('semester'), Session::get('year')));
        $count = count($student);

        ?>
    @endif
    @if(Auth::user()->isStudent())
        <?php
        $student = DB::select('select re.student_id as studentid,stu.firstname_th as firstname_th,stu.lastname_th as lastname_th,re.status as status
                                              from course_student  re
                                              left join users stu on re.student_id=stu.id
                                              where re.course_id=? and  re.section=? and re.semester=? and re.year=? and re.student_id=?
                                              order by re.student_id
                                              ', array($course['co'], $course['sec'], Session::get('semester'), Session::get('year'), Auth::user()->id));
        $count = count($student);

        ?>

    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher()||Auth::user()->isStudentandTa()||Auth::user()->isTa())
                            <div class="dropdown">
                                @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Add Student<span class="caret"></span></button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li>{!! link_to_action('StudentsController@insert','From reg.cmu.ac.th',array('ddlCourse'=>$course['co'],'ddlSection'=>$course['sec']))!!}</li>
                                    <li>{!! link_to_action('StudentsController@selectexcel','From Excel File',array('ddlCourse'=>$course['co'],'ddlSection'=>$course['sec']))!!}</li>
                                    <li><a href="{{ url('/students/create/'.$coid[0]->id) }}">Custom ...</a></li>
                                </ul>
                                {!! link_to_action('StudentsController@export','Export Student List',array('course'=>$course['co'],'sec'=>$course['sec']),array('role'=>'button','class'=>'btn btn-default'))!!}
                                {!! link_to_action('CourseHomeworkController@homeworkCreate','Manage Homework',array('course'=>$course['co']),array('role'=>'button','class'=>'btn btn-default') )!!}
                                <button type="button" class="btn btn btn-default " data-toggle="modal" data-target="#editsend">Edit Homework Status</button>
                                @endif
                                    {{--{!! link_to_action('Homework1Controller@exportzip','Download All Homework ',array('course'=>$course['co'],'sec'=>$course['sec'],'homeworkname'=>'','path'=>'','type'=>'0'), array('role'=>'button','class'=>'btn btn-default'))!!}--}}
                                    <a href="#" type="button">Export zip (in progress...)</a>
                            </div>
                        @endif

                        <h4 align="center">Students enrollment </h4>

                        <div class="table-responsive">
                            <div>
                                {{--Hide column: <a class="toggle-vis" data-column="1">Name</a> - <a class="toggle-vis" data-column="2">Status</a>--}}
                            </div>
                            <table class="table" id="example1" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    @if(!Auth::user()->isStudent())
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                    @endif
                                    @if(count($homework)>0)
                                        @foreach($homework as $aHomework)
                                            <?php
                                            $pattern = '/(_?\{)(.*)(\}_?)/i';
                                            $replacement = '';
                                            $name = preg_replace($pattern, $replacement, $aHomework->name);
                                            ?>

                                            <th>
                                                <p align="center">{{$name}}<br/>
                                                    {{--<span class="label label-warning">{{date("d", strtotime($aHomework->due_date)).$month[date("m", strtotime($aHomework->due_date))]}}</span><br/>--}}
                                                    {{--<span class="label label-danger">{{date("d", strtotime($aHomework->accept_date)).$month[date("m", strtotime($aHomework->accept_date))]}}</span>--}}
                                                    <span class="label label-warning">{{$aHomework->s_due_date}}</span><br/>
                                                    <span class="label label-danger">{{$aHomework->s_accept_date}}</span>
                                                </p>
                                            </th>
                                        @endforeach
                                    @endif

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    @if(!Auth::user()->isStudent())
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                    @endif
                                    @if(count($homework)>0)
                                        @foreach($homework as $aHomework)
                                            @if(Auth::user()->isStudent())

                                                <th>
                                                    {{--<button type="button" data-path="{{$aHomework->path}}"--}}
                                                            {{--data-fullpath="temp" data-template-name="{{$aHomework->name}}"--}}
                                                            {{--data-type-id="{{$aHomework->type_id}}"--}}
                                                            {{--data-homework-id="{{$aHomework->id}}"--}}
                                                            {{--data-duedate="{{$aHomework->due_date}}"--}}
                                                            {{--data-acceptdate="{{$aHomework->accept_date}}"--}}
                                                            {{--class="btn btn-default student-button"><i--}}
                                                                {{--class="fa fa-upload"></i></button>--}}
                                                    <button type="button"
                                                            data-homework-id="{{$aHomework->id}}"
                                                            data-accept-filename="{{str_replace('{id}',\Auth::user()->id,$aHomework->name)}}"
                                                            data-accept-filetype="{{$aHomework->extension}}"
                                                            class="btn btn-default student-button"><i class="fa fa-upload"></i></button>
                                                </th>

                                            @endif
                                            @if(Auth::user()->isTeacher()||Auth::user()->isAdmin()||Auth::user()->isStudentandTa()||Auth::user()->isTa())
                                                <th>
                                                    {{--<p align="center">{!! link_to_action('Homework1Controller@exportzip','',array('course'=>$course['co'],'sec'=>$course['sec'],'homeworkname'=>$aHomework->name,'path'=>$aHomework->path,'type'=>'1'),array('class'=>'glyphicon glyphicon-download-alt'))!!}</p>--}}
                                                    <a href="#" type="button">Export to zip file(In progress...)</a>
                                                </th>

                                            @endif

                                        @endforeach
                                    @endif


                                </tr>
                                </tfoot>
                                {{-- */$x=0;/* --}}
                                <tbody>
                                @foreach($sent as $item)

                                    <tr>
                                        @if(Auth::user()->isAdmin()||Auth::user()->isTeacher()||Auth::user()->isTa()||Auth::user()->isStudentandTa())

                                            {{--<td><a href="{{ url('/students/show', $item->studentid) }}">{{ $item->studentid }}</a></td>--}}
                                            <td>{!! link_to_action('StudentsController@show',$item->studentid,array('id'=>$item->studentid,'course'=>$course['co'],'sec'=>$course['sec']))!!}</td>
                                            {{--<td><a href="{{ url('/students/show', $item->studentid) }}">{{ $item->firstname." ".$item->lastname }}</a></td>--}}
                                            <td>{!! link_to_action('StudentsController@show',$item->firstname." ".$item->lastname,array('id'=>$item->studentid,'course'=>$course['co'],'sec'=>$course['sec']))!!}</td>
                                            <td>{{ $item->status}}</td>
                                            @endif

                                                    <!--
                                                    <td><a href="{{ url('/students/edit/'.$item->studentid) }}">Edit</a> </td>
                                                    -->
                                            @if(count($homework)>0)
                                                @foreach($homework as $key2)

                                                    <?php
                                                    $sql = DB::select('select * from homework_student where homework_id = ? and student_id=?
                                                                       and course_id=? and section=?', array($key2->id, $item->studentid, $course['co'], $course['sec']));
                                                    $hw = count($sql);

                                                    if ($hw > 0) {
                                                        if ($sql[0]->status == 1) {
                                                            echo "<td ><p align='center'>OK</p></td>";
                                                        } elseif ($sql[0]->status == 2) {
                                                            echo "<td><p align='center'>LATE</p></td>";
                                                        } elseif ($sql[0]->status == 3) {
                                                            echo "<td><p align='center'>!!!</p></td>";
                                                        } else {

                                                            echo "<td ><p align='center'>-</p></td>";
                                                        }

                                                    } else {
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


    {{--<button type="button" class="btn " data-toggle="modal" data-target="#myModal"> {{\Session::get('semester')}}/{{Session::get('year')}}เปลี่ยน</button>--}}

    <!-- Modal -->
    <div id="editsend" class="modal fade" role="dialog">

        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Edit Status Homework </h4>
                </div>
                <div class="modal-body">
                    <div class="portlet" align="right">
                        <div class="portlet-body form" align="center">
                            <form action="homework/editstatus" method="post" name="frmhw" id="frmhw"
                                  onsubmit="return onSubmit()" class="form-horizontal" align="center">
                                <div class="form-body">
                                    <div class="form-group" align="center">
                                        <div class="col-md-4 col-md-offset-4" align="center">
                                            {!! Form::label('hw', 'Homework') !!}
                                            <select id="hw" name="hw" class="form-control">
                                                <option selected value="">Select Homework</option>
                                                <?php
                                                $sql = array();

                                                $sql = DB::select('SELECT * from homework where course_id=? and section=?
                                                                  and semester=? and year=?
                                                                order by name ',
                                                        array($course['co'], $course['sec'], Session::get('semester'), Session::get('year')));

                                                $count = count($sql);

                                                $i = 0;
                                                for($i = 0;$i < $count;$i++){
                                                ?>
                                                <option value={{$sql[$i]->id}}>{{$sql[$i]->name}}</option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="course" value="{{$course['co']}}">
                                    <input type="hidden" name="sec" value="{{$course['sec']}}">

                                    <div class="form-group" align="center">
                                        <div class="col-md-4 col-md-offset-4" align="center">
                                            {!! Form::label('stu', 'Student') !!}
                                            <select id="stu" name="stu" class="form-control">
                                                <option selected value="">Select Student</option>
                                                <?php
                                                $sql = array();

                                                $sql = DB::select('SELECT * from course_student
                                                                  where course_id=? and section=?
                                                                  and semester=? and year=?
                                                                order by student_id ',
                                                        array($course['co'], $course['sec'], Session::get('semester'), Session::get('year')));

                                                $count = count($sql);

                                                $i = 0;
                                                for($i = 0;$i < $count;$i++){
                                                ?>
                                                <option value={{$sql[$i]->student_id}}>{{$sql[$i]->student_id}}</option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" align="center">
                                        <div class="col-md-4 col-md-offset-4" align="center">
                                            {!! Form::label('status', 'Status') !!}
                                            <select id="status" name="status" class="form-control">
                                                <option selected value="">Select Status</option>
                                                <option value=1>OK</option>
                                                <option value=2>LATE</option>
                                                <option value=3>!!!</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group" align="center">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                        <div class="col-md-4 col-md-offset-4">
                                            <input type="submit" name="ok" value="Edit" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                {{--</div>--}}
            </div>

        </div>
    </div>
@endsection
@section('footer')
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>--}}
    <script type="text/javascript" src="{{ asset('/js/dropzone/dropzone.js') }}"></script>

    {{--<script src="//cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.js"></script>--}}
    <script src="{{ asset('/libs/datatables/tabletools-2.2.4/js/dataTables.tableTools.js') }}"></script>
    {{--<script src="//cdn.datatables.net/fixedcolumns/3.0.3/js/dataTables.fixedColumns.js"></script>--}}

    <script type="text/javascript">

        var templatename = $('.button-selected').attr('data-template-name');
        var typeid = $('.button-selected').attr('data-type-id');
        var homework_id = '';
        var due_date = '';
        var accept_date = '';
        var baseUrl = "{{ url('/') }}";
        var token = "{{ Session::getToken() }}";
        var student_id = "{{\Auth::user()->id}}";
        var homework_id = '';
        var _course_id = '{{$course['co']}}';
        var _section = '{{$course['sec']}}';
        var _uploadURL = 'uploadFiles';
        var _sFileName = '{{$course['co']}}' + '-' + '{{$course['sec']}}' + '-*.xls';
        var _isStudent = {{\Auth::user()->isStudent()}};
        var _sSwfPath = '{{asset('/libs/datatables/tabletools-2.2.4/swf/copy_csv_xls_pdf.swf')}}';

        $(document).ready(function () {

            console.log(_sFileName);
            //Declaration
            var table;

            function initTable(){
                if(!_isStudent){
                    table = $('#example1').dataTable({
                        "scrollX": true,
                        "sDom": 'T<"clear">lfrtip',
                        "oTableTools": {
                            "sSwfPath": _sSwfPath,
                            "aButtons": [
                                {
                                    "sExtends": "xls",
                                    "sButtonText": "Export homework report ",
                                    "sToolTip": "Export report send with excel",
                                    "sMessage": "Generated by DataTables",
                                    "sTitle": "Report Sending ",
                                    "sFileName": _sFileName
                                }
                            ]
                        },
                        "columnDefs": [
                            {"sClass": "a-right"},
                            {"width": "4%", "targets": 0},
                            {"width": "25%", "targets": 1},
                            {"width": "2%", "targets": 2}
                        ]
                    });
                }else{
                    table = $('#example1').dataTable({
                        "scrollX": true
                    });
                }
            }

            function onSubmit() {
                var msgErr = ""
                if ($("#hw").val() == "") {
                    msgErr += "Please select homework\n"
                }
                if ($("#stu").val() == "") {
                    msgErr += "Please select student\n"
                }
                if ($("status").val() == "") {
                    msgErr += "Please select status\n"
                }
                if (msgErr != "") {
                    alert(msgErr)
                    return false
                } else {
                    return true
                }
            }
            //End Declaration

            $('#example').dataTable({
                "order": [[3, "desc"]],
                "scrollX": true
            });

            initTable();

            //var table = $('#example1').dataTable({
            //    "scrollX": true,
            //    @if(!\Auth::user()->isStudent())
            //    "sDom": 'T<"clear">lfrtip',
            //    "oTableTools": {
            //        "sSwfPath": "//cdn.datatables.net/tabletools/2.2.4/swf/copy_csv_xls_pdf.swf",
            //        "aButtons": [
            //            {
            //                "sExtends": "xls",
            //                "sButtonText": "Export homework report ",
            //                "sToolTip": "Export report send with excel",
            //                "sMessage": "Generated by DataTables",
            //                "sTitle": "Report Sending ",
            //                "sFileName": _sFileName
            //            }
            //        ]
            //    },
            //    "columnDefs": [
            //        {"sClass": "a-right"},
            //        {"width": "4%", "targets": 0},
            //        {"width": "25%", "targets": 1},
            //        {"width": "2%", "targets": 2}
//            { "bSortable": false, "aTargets": [ 0 ] }
            //    ]
            //    @endif
            //});
            //test
            $('a.toggle-vis').on('click', function (e) {
                e.preventDefault();

                // Get the column API object
                var column = table.column($(this).attr('data-column'));

                // Toggle the visibility
                column.visible(!column.visible());
            });
            //end test

            //when upload button is clicked in preview page
            $(".student-button").on('click', function () {
                $('button').removeClass('student-button-selected');
                $(this).toggleClass('student-button-selected');

                $('#upload-modal .modal-title').html('Upload File <p class="text-primary">' + $('.student-button-selected').attr('data-accept-filename') + '(' + $('.student-button-selected').attr('data-accept-filetype') + ')</p>');
                homework_id = $('.student-button-selected').attr('data-homework-id');
                $('#upload-modal').modal('toggle');
            });
        });

    </script>

    @include('partials.dropzone')
@endsection