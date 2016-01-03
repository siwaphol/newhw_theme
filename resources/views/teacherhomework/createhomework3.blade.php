@extends('app')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-multiselect/bootstrap-multiselect.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/material-design-iconic-font.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/file-and-folder.css') }}"/>
@endsection

@section('content')
    <input type="text" class="hidden visited">
    <div class="container well">
        <h3 align="center">Create Homework {{$course_id}}</h3>

        <div class="row" style="margin-bottom: 15px;padding-right: 19px;">
            <div class="pull-left">
                <a href="#" class="toggle-vis" data-column="9">999999</a>
                <a class="toggle-vis" data-column="1">Type</a>
                <a href="#" class="toggle-vis-all">Show All</a>
            </div>
            <div class="pull-right">
                <button type="button" class="btn btn-default" id="file_add_btn">
                    <span class="extraicon-file-add"></span>
                </button>
            </div>
        </div>

        {{--<table id="users-table" class="table table-condensed">--}}
            {{--<thead>--}}
            {{--<tr>--}}
                {{--<th rowspan="2">Name</th>--}}
                {{--<th rowspan="2">Type</th>--}}
                {{--<th colspan="{{count($section_list)}}">Due Date</th>--}}
                {{--<th colspan="{{count($section_list)}}">Accept Until</th>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--@foreach($section_list as $aSection)--}}
                    {{--<th>{{$aSection->section}}</th>--}}
                {{--@endforeach--}}
                {{--@foreach($section_list as $aSection)--}}
                    {{--<th>{{$aSection->section}}</th>--}}
                {{--@endforeach--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
                {{--@foreach($homeworks as $aHomework)--}}
                {{--<tr>--}}
                    {{--<td>{{$aHomework->name}}</td>--}}
                {{--</tr>--}}
                {{--@endforeach--}}
            {{--</tbody>--}}

        {{--</table>--}}

        {{--test--}}
        <table id="users-table" class="table table-condensed">
            <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Section</th>
                <th>Due Date</th>
                <th>Accept Until</th>
            </tr>
            </thead>
            <tbody>
            @foreach($homeworks as $aHomework)
                <tr>
                    <td><a>{{$aHomework->name}}</a></td>
                    <td>{{$aHomework->extension}}</td>
                    <td>{{$aHomework->section}}</td>
                    <td>{{$aHomework->due_date}}</td>
                    <td>{{$aHomework->accept_date}}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/moment-with-locales.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap/transition.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap/collapse.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery-bootstrap-modal-steps.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    {{--<script type="text/javascript" src="{{ asset('/js/validator.min.js') }}"></script>--}}

    <!-- Add File Modal -->
    @include('partials.file_add_wizard_dialog')
            <!-- Add Folder Modal -->
    @include('partials.folder_add_dialog')

    {{--datetimepicker--}}
    <script type="text/javascript">
        $(function () {

            if(document.cookie.indexOf('mycookie')==-1) {
                // cookie doesn't exist, create it now
                document.cookie = 'mycookie=1';
            }
            else {
                // not first visit, so alert
                alert('You refreshed!');
                init_file_add_modal();
            }

            function init_file_add_modal(){
                $('#homeworkname').val('');
                $('#homework-ext-label').html('no extension selected');
                $('#filetype-list').val($("#filetype-list option:first").val());
                $('#extension').val('000');
                $('#filedetail').val('');
                $('#section-list').multiselect('deselectAll', false);
                $('#section-list').multiselect('updateButtonText');
                $('#section-panel').remove();
            }

            var opt = "";

//            test
            //prevent user from click outside and close modal
            $.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';

//            end test
            $("#file_add_btn").on('click', function () {
                opt = 'add';
                $('#addFileModal').modal('toggle');
            });

//            $("#folder_add_btn").on('click', function () {
//                opt = 'add';
//                $('#addFolderModal').modal('toggle');
//            });
        });

        $(document).ready(function () {

            var hw_table = $('#users-table').DataTable({
                "scrollX": true
//                processing: true,
//                serverSide: true,
//                "dom" : 'l<"#section_filter">ftipr',
//                ajax: '{{ url("coursehomeworkdata") }}{{'/'.$course_id}}',
//                columns: [
//                    {data: 'name', name: 'name'},
//                    {data: 'type_id', name: 'type_id'},
//                        @foreach($section_list as $aSection)
//                    {
  //                      data: 'due_date' + '{{$aSection->section}}', name: 'due_date' + '{{$aSection->section}}'
    //                },
      //                  @endforeach
        //                @foreach($section_list as $aSection)
          //          {
            //            data: 'accept_until' + '{{$aSection->section}}', name: 'accept_until' + '{{$aSection->section}}'
              //      },
                //        @endforeach
                //]
            });

            var myArray = new Object();
            var precede_columns = 2;
            var i = 0;
            var all_section = {{count($section_list)}};
            @foreach($section_list as $aSection)
                myArray['{{$aSection->section}}'] = ''+(precede_columns+i) + ',' + (precede_columns+all_section+i);
                i = i + 1;
            @endforeach

            $('#section_filter').html('' +
                    '<label style="margin-left: 5px;"> | Section Filter: ' +
                    '<select id="section_select">' +
                    @foreach($section_list as $aSection)
                        '<option value="'+ myArray['{{$aSection->section}}'] + '">{{$aSection->section}}</option>'+
                    @endforeach
                    '<option value="All">All</option>' +
                    '</select>' +
                    '</label>');

//            //test
//            $('a.toggle-vis-all').on('click', function (e) {
//                e.preventDefault();
//                hw_table.columns().visible(true);
//            });
//            $('a.toggle-vis').on( 'click', function (e) {
//                e.preventDefault();
//
//                // Get the column API object
//                var column = hw_table.column( $(this).attr('data-column') );
//
//                // Toggle the visibility
//                column.visible( ! column.visible() );
//            } );
            //end test
//            $('#section_select').change(function () {
//                if($(this).val() === "All"){
//                    var columns = hw_table.columns('2,3,4,5,6,7,8,9,10,11,12,13,14,15');
//                    columns.visible(true);
//                }else{
//                    var column = hw_table.columns('2,9');
//                    column.visible(! column.visible());
//                }
//            });

        });
    </script>
@endsection