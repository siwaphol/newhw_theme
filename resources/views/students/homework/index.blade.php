@extends('app')

@section('css')

@endsection

@section('content')

    <div>
        <h3 align="center">{{$course_no}} || {{$courseWithTeaAssist->name}} || {{$section}} </h3>
    </div>

    <h4 align="center"> LECTURER </h4>
    @foreach($courseWithTeaAssist->teachers as $teacher)
        <h5 align="center">{{$teacher->firstname_en.' '.$teacher->lastname_en}} </h5>
    @endforeach

    <div class="content">
        @include('flash::message')
        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title">Homework</h6>

            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer" style="overflow: scroll;">
                <div class="datatable-scroll-lg">
                    <table class="table tasks-list table-lg dataTable no-footer" id="DataTables_Table_0" role="grid"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting">Homework Name</th>
                            <th class="sorting" >Assign Date Time</th>
                            <th class="sorting" >Due Date Time</th>
                            <th class="sorting" >Accept Date Time</th>
                            <th class="sorting" >Submitted Date Time</th>
                            <th class="sorting">Status</th>
                            <th class="sorting">File</th>
                            {{--<th>Upload</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        <?php $odd=true; ?>
                        @foreach($sent as $aHomework)
                        <tr role="row" class="{{$odd?'odd':'even'}}">
                            <?php $odd=!$odd; ?>
                            <td>
                                <div class="text-semibold">{{$aHomework->name}} ({{$aHomework->extension}})
                                </div>
                                <div class="text-muted">Homework description here.</div>
                            </td>
                            <td>
                                <div class="input-group input-group-transparent">
                                    <div class="input-group-addon"><i class="icon-calendar2 position-left"></i></div>
                                    <input type="text" class="form-control datepicker hasDatepicker"
                                           value="{{$aHomework->assign_date}}" id="dp1463318786677">
                                </div>
                            </td>
                            <td>
                                <div class="input-group input-group-transparent">
                                    <div class="input-group-addon"><i class="icon-calendar2 position-left"></i></div>
                                    <input type="text" class="form-control datepicker hasDatepicker"
                                           value="{{$aHomework->due_date}}" id="dp1463318786677">
                                </div>
                            </td>
                            <td>
                                <div class="input-group input-group-transparent">
                                    <div class="input-group-addon"><i class="icon-calendar2 position-left"></i></div>
                                    <input type="text" class="form-control datepicker hasDatepicker"
                                           value="{{$aHomework->accept_date}}" id="dp1463318786677">
                                </div>
                            </td>
                            <td>
                                <div class="input-group input-group-transparent">
                                    <div class="input-group-addon"><i class="icon-calendar2 position-left"></i></div>
                                    <input type="text" class="form-control datepicker hasDatepicker"
                                           value="{{$aHomework->submitted_at}}" id="dp1463318786677">
                                </div>
                            </td>
                            <td>
                                @if(!is_null($aHomework->status))
                                    <p>{{$aHomework->status_text}}</p>
                                @else
                                    <p>Waiting</p>
                                @endif
                            </td>
                            <td>
                                {!! Form::open(['url'=>'homework/upload', 'method'=>'post', 'files'=>true]) !!}
                                <div style="float:left;">
                                    <input type="hidden" name="course_id" value="{{$course_no}}">
                                    <input type="hidden" name="section" value="{{$section}}">
                                    <input type="hidden" name="homework_id" value="{{$aHomework->id}}">
                                    <input type="hidden" name="student_id" value="{{auth()->user()->id}}">
                                    <input type="hidden" name="semester" value="{{Session::get('semester')}}">
                                    <input type="hidden" name="year" value="{{Session::get('year')}}">
                                    <input type="hidden" value="{{$aHomework->name}}" name="name">
                                    <input type="hidden" value="{{$aHomework->extension}}" name="extension">
                                    {!! Form::file('test-'.$aHomework->id,["data-expected-name"=>$aHomework->expected_name]) !!}
                                </div>
                                <div style="float: right;margin-top: -30px;">
                                    <button  class="btn btn-default" type="submit">Upload</button>
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /task manager table -->
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        $(function() {
            $("input:file").change(function (){
                var fileName = $(this).val();
                var expectedName = $(this).attr("data-expected-name").split(",");
                if(expectedName.indexOf(fileName)>-1){
                    console.log("should submit");
                    return;
                }
                console.log("should alert wrong file name");
//                $(this).parent().trigger('submit');
            });

            $(".submit-form").submit(function (e) {
                var self = this;
                console.log('submiting',self);
                e.preventDefault();

                if($(self).find("input[name='test']").val()){
                    self.submit();
                }else{
                    alert('error no file upload');
                }

                return false;
            });
        });
    </script>
@endsection