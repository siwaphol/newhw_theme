@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/dropzone/dropzone.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/libs/datatables/tabletools-2.2.4/css/dataTables.tableTools.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/libs/font-awesome-4.4.0/css/font-awesome.min.css') }}"/>
@endsection

@section('content')
    <div>
        <h3 align="center">{{$course_no}} || {{$courseWithTeaAssist->name}} || {{$section}} </h3>
    </div>
    <h4 align="center"> LECTURER </h4>
    @foreach($courseWithTeaAssist->teachers as $teacher)
        <h5 align="center">{{$teacher->firstname_en.' '.$teacher->lastname_en}} </h5>
    @endforeach

    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">Teaching Assistant</div>
                        <div class="panel-body">
                            {!! link_to_action('AssistantsController@create','Add Teaching Assistant',array('course'=>$course_no,'sec'=>$section),array('role'=>'button','class'=>'btn btn-default'))!!}
                            <div class="table-responsive">
                                <table class="table" id="example" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Student ID
                                        <th>Name</th>
                                        <th>Delete</th>

                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Student ID
                                        <th>Name</th>
                                        <th>Delete</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($courseWithTeaAssist->assistants as $assistant)
                                        <tr>
                                            <td>{{ $assistant->id }}</td>
                                            <td>{{ $assistant->firstname_en.' '.$assistant->lastname_en }}</td>
                                            <td>
                                                {!! Form::open(['url' => 'assistants/delete']) !!}
                                                <input type="hidden" name="course" id="course"
                                                       value='{{$course_no}}'>
                                                <input type="hidden" name="sec" id="sec" value='{{$section}}'>
                                                <input type="hidden" name="id" id="id" value='{{$assistant->id}}'>
                                                <button type="submit" class="btn btn-link"
                                                        onclick="return confirm('Are you sure you want to delete student from this section?')">
                                                    Delete
                                                </button>
                                                {!! Form::close() !!}
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
                                        <li>{!! link_to_action('StudentsController@insert','From reg.cmu.ac.th',array('ddlCourse'=>$course_no,'ddlSection'=>$section))!!}</li>
                                        <li>{!! link_to_action('StudentsController@selectexcel','From Excel File',array('ddlCourse'=>$course_no,'ddlSection'=>$section))!!}</li>
                                        <li><a href="{{ url('/students/create/'.$course_no) }}">Manual Insert ...</a></li>
                                    </ul>
                                    {!! link_to_action('StudentsController@export','Export Student List',array('course'=>$course_no,'sec'=>$section),array('role'=>'button','class'=>'btn btn-default'))!!}
                                    {!! link_to_action('CourseHomeworkController@homeworkCreate','Manage Homework',array('course'=>$course_no),array('role'=>'button','class'=>'btn btn-default') )!!}
                                    <button type="button" class="btn btn btn-default " data-toggle="modal" data-target="#editsend">Edit Homework Status</button>
                                @endif
                                <a href="#" type="button">Export zip (in progress...)</a>
                            </div>
                        @endif

                        <h4 align="center">Students enrollment </h4>
                        <div class="table-responsive">
                            <table class="table" id="example1" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    @if($homework->count())
                                        @foreach($homework as $aHomework)
                                            <?php
                                            $pattern = '/(_?\{)(.*)(\}_?)/i';
                                            $replacement = '';
                                            $name = preg_replace($pattern, $replacement, $aHomework->name);
                                            ?>

                                            <th>
                                                <p align="center">{{$name}}<br/>
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
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    @if($homework->count())
                                        @foreach($homework as $aHomework)
                                                <th>
                                                    <a href="#get-homework-zip/{{$aHomework->id}}" type="button">Export to zip file(In progress...)</a>
                                                </th>
                                        @endforeach
                                    @endif
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($sent as $student)
                                    <tr>
                                        <td>{!! link_to_action('StudentsController@show',$student->id,array('id'=>$student->id,'course'=>$course_no,'sec'=>$section))!!}</td>
                                        <td>{!! link_to_action('StudentsController@show',$student->firstname_th." ".$student->lastname_th,array('id'=>$student->id,'course'=>$course_no,'sec'=>$section))!!}</td>
                                        <td>{{ $student->status}}</td>
                                        @foreach($homework as $aHomework)
                                            @if(!is_null($student) )
                                                <?php $hwStatus = $student->status; ?>
                                                <td>
                                                    <p align="center">
                                                        @if($hwStatus==='1')
                                                            {{"OK"}}
                                                        @elseif($hwStatus==='2')
                                                            {{"LATE"}}
                                                        @elseif($hwStatus==='3')
                                                            {{"!!!"}}
                                                        @endif
                                                    </p>
                                                </td>
                                            @else
                                                <td><p align='center'>-</p></td>
                                            @endif
                                            {{--<td><p align="center"></p></td>--}}
                                        @endforeach
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

    {{--TODO-nong แก้ตรงนี้อีกที--}}
    {{--@include('home.partials.edit_send_status')--}}

@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/js/dropzone/dropzone.js') }}"></script>
    {{--<script src="{{ asset('/libs/datatables/tabletools-2.2.4/js/dataTables.tableTools.js') }}"></script>--}}

    <script type="text/javascript">

        var templatename = $('.button-selected').attr('data-template-name');
        var typeid = $('.button-selected').attr('data-type-id');
        var homework_id = '';
        var due_date = '';
        var accept_date = '';
        var baseUrl = "{{ url('/') }}";
        var token = "{{ Session::getToken() }}";
        var student_id = "{{\Auth::user()->id}}";
        var _course_id = '{{$course_no}}';
        var _section = '{{$section}}';
        var _uploadURL = 'uploadFiles';
        var _sFileName = '{{$course_no}}' + '-' + '{{$section}}' + '-*.xls';
        var _isStudent = {{(\Auth::user()->isStudent()?'true':'false')}};
        var _sSwfPath = '{{asset('/libs/datatables/tabletools-2.2.4/swf/copy_csv_xls_pdf.swf')}}';
        var table;

        $(function () {

            console.log(_sFileName);
            //Declaration
            function initTable(){
                if(!_isStudent){
                    table = $('#example1').dataTable({
                        "scrollX": true,
//                        "sDom": 'T<"clear">lfrtip',
//                        "columnDefs": [
//                            {"sClass": "a-right"},
//                            {"width": "4%", "targets": 0},
//                            {"width": "25%", "targets": 1},
//                            {"width": "2%", "targets": 2}
//                        ]
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

//            $('#example').dataTable({
//                "order": [[3, "desc"]],
//                "scrollX": true
//            });

            initTable();
            //test
            $('a.toggle-vis').on('click', function (e) {
                e.preventDefault();

                // Get the column API object
                var column = table.column($(this).attr('data-column'));

                // Toggle the visibility
                column.visible(!column.visible());
            });
            //end test
        });

    </script>
@endsection