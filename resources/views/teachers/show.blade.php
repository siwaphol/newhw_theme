@extends('app')

@section('content')
 <script type="text/javascript">

 $(document).ready(function() {
     $('#example').dataTable( {
         "order": [[ 3, "desc" ]]
     } );
 } );

     </script>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Lecturer</div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>ID</th><th>username</th><th>Name</th><th>Email</th>
                                </tr>
                                @foreach($teacher as $item)
                                <tr><?php
                                $teacherid=$item->id;
                                ?>
                                    <td>{{ $item->id }}</td><td>{{ $item->username }}</td><td>{{ $item->firstname_th." ".$item->lastname_th }}</td><td>{{ $item->email }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$sql=DB::select('select cs.course_id,co.name ,cs.section  from course_section cs
                  left join courses co on cs.course_id=co.id
                  where cs.teacher_id=? and cs.semester=? and cs.year=?
                  ',array($teacherid,Session::get('semester'),Session::get('year')));

$counr=count($sql);

?>
<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Course</div>

                    <div class="panel-body">

     <div class="table-responsive">
    <table class="table">
        <tr>
            <th>No</th><th>Course No</th><th>Title</th><th>Section</th>
        </tr>
        <?php
            for($i=0;$i<$counr;$i++){
            ?>
        <tr>
            <td>{{ $i+1 }}</td><td>{{ $sql[$i]->course_id }}</td><td>{{ $sql[$i]->name }}</td><td>{{ $sql[$i]->section }}</td>
        </tr>
       <?php } ?>
    </table>
</div>
</div>
</div>
</div>
</div>
</div>




@endsection