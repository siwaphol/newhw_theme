@extends('app')

@section('content')
 <script type="text/javascript">

$(document).ready(function() {
    $('#example').dataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );

    </script>
<?php
$assistants=DB::select('select  ta.username as username
                        ,ass.id as id
                        ,ass.student_id as taid
                        ,ta.firstname_th as firstname
                        ,ta.lastname_th as lastname
                        from course_ta ass
                        left join users ta on ass.student_id=ta.id and ta.role_id=0010
                      where ass.course_id=? and  section=?',array($course['co'],$course['sec']));
$count=count($assistants);
$item=$assistants;
?>


    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">มอบหมายงานนักศึกษาช่วยสอน</div>
                    
                    <div class="panel-body">
                        <h3 align="center" >กระบวนวิชา {{$course['co']}} ตอน {{$course['sec']}}</h3>
                        <h4><a>{!! link_to_action('AssistantsController@create','เพิ่ม',array('course'=>$course['co'],'sec'=>$course['sec']))!!}</a></h4>
                        <div class="table-responsive">
                            <table class="table" id="example" cellspacing="0" width="100%" >
                                <thead>
                                <tr>
                                    <th>No</th><th>Name</th><th>edit</th><th>delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No</th><th>Name</th><th>edit</th><th>delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                {{-- */$x=0;/* --}}
                                <?php
                                for($x=0;$x<$count;$x++){
                                ?>

                                    <tr>
                                        <td>{{ $x+1 }}</td><td><a href="{{ url('/assistants/show', $item[$x]->username) }}">{{ $item[$x]->firstname." ".$item[$x]->lastname }}</a></td>
                                        <td><button type="button" class="btn btn-default"><a>{!! link_to_action('AssistantsController@edit','Edit',array('username'=>$item[$x]->username,'course'=>$course['co'],'sec'=>$course['sec']))!!}</a>
                                        </button></td>
                                        <td>
                                          <button type="button" class="btn btn-danger btn-ok" onclick="return confirm('Are you sure you want to delete?')"><a>{!! link_to_action('AssistantsController@destroy','Delete',array('id'=>$item[$x]->taid,'course'=>$course['co'],'sec'=>$course['sec']))!!}</a></button></td>

                                    </tr>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection