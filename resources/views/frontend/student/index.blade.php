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

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <h4 align="center">Students enrollment </h4>
                        <div class="table-responsive">
                            <table class="table" id="example1" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    @if(!Auth::user()->isStudent())
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                    @endif
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
                                    @if(!Auth::user()->isStudent())
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                    @endif
                                    @if($homework->count())
                                        @foreach($homework as $aHomework)
                                            @if(Auth::user()->isStudent())
                                                <th>
                                                    <p align="center">
                                                        <button type="button"
                                                                data-homework-id="{{$aHomework->id}}"
                                                                data-accept-filename="{{str_replace('{id}',\Auth::user()->id,$aHomework->name)}}"
                                                                data-accept-filetype="{{$aHomework->extension}}"
                                                                class="btn btn-default student-button"><i class="fa fa-upload"></i></button>
                                                    </p>
                                                </th>
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                                </tfoot>

                                <tbody>

                                @if(!Auth::user()->isStudent())
                                    @foreach($sent->students as $student)
                                        <tr>
                                            <td>{!! link_to_action('StudentsController@show',$student->id,array('id'=>$student->id,'course'=>$course_no,'sec'=>$section))!!}</td>
                                            <td>{!! link_to_action('StudentsController@show',$student->firstname_en." ".$student->lastname_en,array('id'=>$student->id,'course'=>$course_no,'sec'=>$section))!!}</td>
                                            <td>{{ $student->pivot->status}}</td>
                                            @foreach($homework as $aHomework)
                                                {{-- หาใน $student->submitted_homework ว่า pivot->status เป็นเท่าไหร่--}}
                                                @if(!is_null($student) && !empty($student->submittedHomework->find($aHomework->id)))
                                                    <?php $hwStatus = $student->submittedHomework->find($aHomework->id)->pivot->status; ?>
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
                                                <td><p align="center"></p></td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    {{--Student Role--}}
                                @else
                                    <tr>
                                        @foreach($homework as $aHomework)
                                            {{-- หาใน $student->submitted_homework ว่า pivot->status เป็นเท่าไหร่--}}
                                            @if(!is_null($sent) && !empty($sent->submittedHomework->find($aHomework->id)))
                                                <?php $hwStatus = $sent->submittedHomework->find($aHomework->id)->pivot->status; ?>
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
                                        @endforeach
                                    </tr>
                                @endif

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
        var _course_id = '{{$course_no}}';
        var _section = '{{$section}}';
        var _uploadURL = 'uploadFiles';
        var _sFileName = '{{$course_no}}' + '-' + '{{$section}}' + '-*.xls';
        var _isStudent = {{\Auth::user()->isStudent()}};
        var _sSwfPath = '{{asset('/libs/datatables/tabletools-2.2.4/swf/copy_csv_xls_pdf.swf')}}';
        var table;

        $(function () {

            console.log(_sFileName);
            //Declaration
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
                $('#upload-modal').modal('show');
            });
        });

    </script>

    @include('partials.dropzone')
@endsection