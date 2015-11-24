
@extends('app')
@section('content')
<?php

//echo var_dump($model);
$i=1;
?>
<?php

?>

<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">กระบวนวิชา ตอน</div>

                    <div class="panel-body">
{!! Html::link('course_section/create', 'เพิ่มตอนทีละตอน') !!} </br>
{!! Html::link('course_section/selectcreate', 'เพิ่มตอนทั้งกระบวนวิชา') !!}
<div class="table-responsive">
    <table class="table table-bordered"  >
        <thead>
        <thead>
            <tr>

                <th>No</th>
                <th>รหัสวิชา</th>
                <th>ชื่อกระบวนวิชา</th>
                <th>ตอน</th>
                <th>อาจารย์</th>
                <th>Edit</th>
                <th>Delete</th>


            </tr>
        </thead>

        @foreach($result as $key)
        <tbody>
            <tr>
                <td>{{$i}}</td>
                <td>{{$key->courseid}}</td>
                <td>{{$key->coursename}}</td>
                <td>{{$key->sectionid}}</td>
                 <td>{{$key->firstname}}  {{$key->lastname}}</td>
                <td>{!! link_to_action('Course_SectionController@edit','Edit',array('course'=>$key->courseid,'sec'=>$key->sectionid))!!}</td>
                 <td>{!! link_to_action('Course_SectionController@delete','Delete',array('id'=>$key->id,'course'=>$key->courseid,'sec'=>$key->sectionid))!!}</td>


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