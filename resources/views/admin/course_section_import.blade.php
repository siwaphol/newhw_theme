@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Course Details Import Result</h1>
        </div>
        <div class="row clearfix">

            <div class="table-responsive">
                <table class="table" id="course_import_overview" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Course No</th>
                        <th>Title</th>
                        <th>Section</th>
                        <th>Teacher Name</th>
                        <th>Success</th>
                        <th>Detail</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th colspan="6" style="text-align:right" id="total_footer">Total: </th>
                    </tr>
                    </tfoot>

                    <tbody>
                        @for($i = 0; $i < $count_overview; $i++)
                        <tr>
                            <td>{{$overview['course_id'][$i]}}</td>
                            <td>{{$overview['course_name'][$i]}}</td>
                            <td>{{$overview['section'][$i]}}</td>
                            <td>{{$overview['teacher_name'][$i]}}</td>
                            @if($overview['success'][$i]==0)
                                <td><span class="label label-success">Added</span></td>
                            @elseif($overview['success'][$i]==1)
                                <td><span class="label label-warning">Duplicate</span></td>
                            @elseif($overview['success'][$i]==2)
                                <td><span class="label label-danger">Fail</span></td>
                            @endif
                            <td>{{$overview['detail'][$i]}}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script_tag')
    <script>
        $(document).ready(function() {
            $('#myTabs a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            });

            var cimport_table = $('#course_import_overview').DataTable( {
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Update footer
                    $('#total_footer').html('Total : '+ {{$count_summary[0]}} +' Added '+ {{$count_summary[1]}} +' Duplicate '+ {{$count_summary[2]}} +' Fail.');

                },
                "dom" : 'l<"#mycustombutton.dataTables_filter">ftipr'

            } );

            $('#mycustombutton').html('' +
                    '<label style="margin-left: 5px;"> Success Filter: ' +
                        '<select id="success_select">' +
                            '<option value="All">All</option>' +
                            '<option value="Added">Added</option>' +
                            '<option value="Duplicate">Duplicate</option>' +
                            '<option value="Fail">Fail</option>' +
                        '</select>' +
                    '</label>');

            $('#success_select').change(function () {
                if($(this).val() === "All"){
                    cimport_table.search('').draw();
                }else{
                    cimport_table.search($(this).val()).draw();
                }
            });

            $('#test_filter').click(function () {
                cimport_table.search('Added').draw();
            });
        } );
    </script>
@endsection