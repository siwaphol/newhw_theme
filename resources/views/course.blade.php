@extends('app')
@section('css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.css">
@endsection
@section('content')

    <?php
        $i = 1;
    ?>
    <div class="content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @include('flash::message')
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <div class="panel-title">
                            Course List
                        </div>
                        <div class="heading-elements">
                            <div class="btn-group heading-btn">
                                <button type="button" class="btn btn-default btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-menu6"></i> Course<span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{url('course/create')}}">Add course</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table" id="example" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Course No</th>
                                    <th>Title</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Course No</th>
                                    <th>Title</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>

                                <tbody>
                                @foreach($model as $key)
                                    <tr>

                                        <td>{{$key->id}}</td>
                                        <td>{{$key->name}}</td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-link">{!! Html::link('edit/'.$key->id, 'Edit') !!}</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-link"
                                                    onclick="return confirm('Are you sure you want to delete?')">{!! Html::link('delete/'.$key->id, 'Delete') !!}</button>
                                        </td>
                                        <?php
                                        $course=$key->name;
                                        ?>
                                    </tr>
                                    <?php $i++;?>
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
    <script src="//cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#example').dataTable({
                "order": [[0, "asc"]],
                "sDom": 'T<"clear">lfrtip',
                "oTableTools": {
                    "sSwfPath": "//cdn.datatables.net/tabletools/2.2.4/swf/copy_csv_xls_pdf.swf",
                    "aButtons": [
                        {
                            "sExtends": "xls",
                            "sTitle": "Report course",
                            "sFileName": "<?php echo "Course" ?> - *.xls"
                        }
                    ]
                }
            });
        });
    </script>
@endsection