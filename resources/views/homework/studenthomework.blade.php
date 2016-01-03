@extends('app')

@section('css')
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('/css/dropzone/basic.css') }}"/>
  <link rel="stylesheet" href="{{ asset('/css/dropzone/dropzone.css') }}"/>
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css"/>
@endsection

@section('content')
    <div class="container well">
        <table id="users-table" class="table table-condensed">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th><button type="button" class="btn btn-default">Upload</button></th>
                    <th><button type="button" class="btn btn-default">Upload</button></th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/dropzone/dropzone.js') }}"></script>

    <script type="text/javascript">
    $(document).ready(function() {

        $('#users-table').DataTable( {
            "scrollX": true,
            processing: true,
            serverSide: true,
            ajax: '{{ url("coursedata/204111") }}',
            columns: [
                        {data: 'name', name: 'name'},
                        {data: 'status', name: 'status'}
                    ],
            "createdRow": function ( row, data, index ) {
                if ( data['status'] == 'Waiting') {
                    $('td', row).eq(1).addClass('highlight');
                }
            }
        } );

    } );
    </script>
@endsection
