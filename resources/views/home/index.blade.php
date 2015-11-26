@extends('app')

@section('content')

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">

                    <div class="panel-body">
                        @if (\Auth::user()->isAdmin())
                        {!! Html::link('course_section/auto', 'Import course section from registration office',array('onclick'=>"return confirm('Are you sure you want to add all course section from registration?')")) !!} </br>
                        {!! Html::link('students/autoimport', 'Import student information from registration office',array('onclick'=>"return confirm('Are you sure you want to update all students?')")) !!}</br>
                        {!! Html::link('course_section/create', 'Add a section') !!} </br>
                        {!! Html::link('course_section/selectcreate', 'Add mutiple section') !!}
                        @endif

                        <div class="table-responsive">
                            <table class="table" id="example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Course No</th>
                                        <th>Title</th>
                                        <th>Section</th>
                                        <th>Enroll</th>
                                        @if(Auth::user()->isAdmin())
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Course No</th>
                                        <th>Title</th>
                                        <th>Section</th>
                                        <th>Enroll</th>
                                        @if(Auth::user()->isAdmin())
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        @endif
                                    </tr>
                                </tfoot>

                                <tbody>
                                @foreach($result as $key)
                                    <tr>
                                        <td>{{$key->course_id}}</td>
                                        <td>{!! link_to_action('HomeController@preview',$key->course_name,array('course'=>$key->course_id,'sec'=>$key->section))!!}</td>
                                        <td>{!! link_to_action('HomeController@preview',$key->section,array('course'=>$key->course_id,'sec'=>$key->section))!!}</td>
                                        <td>{{$key->enroll_count}}</td>
                                        @if(Auth::user()->isAdmin())
                                            <td>{!! link_to_action('Course_SectionController@edit','Edit',array('course'=>$key->course_id,'sec'=>$key->section))!!}</td>
                                            <td>
                                                <a onclick="return confirm('Are you sure you want to delete student from this section?')">{!! link_to_action('Course_SectionController@delete','Delete',array('id'=>$key->id,'course'=>$key->course_id,'sec'=>$key->section),array('onclick'=>"return confirm('Are you sure you want to delete student from this section?')"))!!}</a>
                                            </td>
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


    @if(Auth::user()->isStudentandTa())
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">Course Section Study</div>

                        <div class="panel-body">

                            <div class="table-responsive">
                                <table class="table" id="example1" cellspacing="0" width="100%">

                                    <thead>
                                    <tr>
                                        <th>Course No</th>
                                        <th>Title</th>
                                        <th>Section</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Course No</th>
                                        <th>Title</th>
                                        <th>Section</th>
                                    </tr>
                                    </tfoot>

                                    <tbody>
                                    @foreach($assist as $key)
                                        <tr>
                                            <td>{{$key->course_id}}</td>
                                            <td>{!! link_to_action('HomeController@preview1',$key->course_name,array('course'=>$key->course_id,'sec'=>$key->section))!!}</td>
                                            <td>{!! link_to_action('HomeController@preview1',$key->section,array('course'=>$key->course_id,'sec'=>$key->section))!!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endif
@endsection

@section('script')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').dataTable({
                "columnDefs": [
                    {"sClass": "a-right",},
                    {"width": "12%", "targets": 0},
                    {"width": "35%", "targets": 1}
                ],
                "order": [[ 0, 'asc' ], [ 2, 'asc' ]]
            });
        });
        $(document).ready(function () {
            $('#example1').dataTable({
                "columnDefs": [
                    {"sClass": "a-right",},
                    {"width": "10 %", "targets": 0},
                    {"width": "35%", "targets": 1}
                ]
            });
        });
    </script>

@endsection
