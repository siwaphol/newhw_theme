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

        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title">Homework</h6>

            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                <div class="datatable-scroll-lg">
                    <table class="table tasks-list table-lg dataTable no-footer" id="DataTables_Table_0" role="grid"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 40%;" aria-label="Task Description: activate to sort column ascending">
                                Homework Name
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 10%;" aria-label="Priority: activate to sort column ascending">Assign Date Time
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 15%;" aria-label="Latest update: activate to sort column ascending">Due Date Time
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 15%;" aria-label="Latest update: activate to sort column ascending">Accept Date Time
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 15%;" aria-label="Status: activate to sort column ascending">Status
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 15%;" aria-label="Assigned users: activate to sort column ascending">
                                Upload
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="active border-double">
                            <td colspan="8" class="text-semibold">Today</td>
                        </tr>
                        <?php $odd=true;?>
                        @foreach($sent as $aHomework)
                        <tr role="row" class="{{$odd?'odd':'even'}}">
                            <?php $odd=!$odd?>
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
                                @if(!is_null($aHomework->status))
                                    <p>{{$aHomework->status_text}}</p>
                                @else
                                    <p>Waiting</p>
                                @endif
                            </td>
                            <td>
                                {!! Form::file('test') !!}
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

@endsection