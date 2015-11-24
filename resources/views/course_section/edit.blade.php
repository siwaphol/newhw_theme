<?php
/**
 * Created by PhpStorm.
 * User: boonchuay
 * Date: 19/6/2558
 * Time: 10:53
 */
 ?>
@extends('app')
@section('content')
<?php


?>

<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Editตอน</div>

                    <div class="panel-body">
@foreach($result as $key)
  {!!Form::open(['url'=>'course_section/update']) !!}
  <input type="hidden" name="id" value="{{$key->id}}">
  <input type="hidden" name="courseid" value="{{$key->courseid}}">

  <div class="form-group">
  {!! Form::label('course','รหัส')!!}
  {!! Form::text('course',$key->courseid,['class'=>'form-control','disabled' => 'disabled'])!!}
  </div>

  <div class="form-group">
  {!! Form::label('courseName','ชื่อกระบวนวิชา')!!}
  {!! Form::text('courseName',$key->coursename,['class'=>'form-control','disabled' => 'disabled'])!!}
  </div>
  <div class="form-group">
  {!! Form::label('sectionid','ตอน')!!}
  {!! Form::text('sectionid',$key->sectionid,['class'=>'form-control'])!!}
  </div>
  <div class="form-group">
  {!! Form::label('teacherid','อาจารย์')!!}
  <select name="teacherid" class="form-control">
  <option value={{$key->teacherid}}>{{$key->firstname." ".$key->lastname}}</option>
  <?php
  $sql=DB::select('select * from users where role_id=0100 order by id');
  $count=count($sql);
  $item=$sql;
  for($i=0;$i<$count;$i++){?>
    <option value={{$item[$i]->id}}>{{$item[$i]->firstname_th." ".$item[$i]->lastname_th}}</option>
    <?php }?>

  </select>
  </div>

  <div class="form-group">
  {!! Form::submit('ปรับปรุง',['class'=>'btn btn-primary form-control'])!!}
  </div>

  {!! Form::close() !!}
   @if ($errors->any())
                              <ul class="alert alert-danger">
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          @endif
  </div>
  </div>
  </div>
  </div>
  </div>

@endforeach


  @endsection