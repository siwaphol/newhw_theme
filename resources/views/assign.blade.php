
@extends('app')
@section('content')

<?php

echo $course;
echo $section;
$result=DB::select('select * from register where courseid=? and sectionid=?',array($course,$section));
echo var_dump($result);


echo Form::open();
echo Form::text('name');
echo Form::password('pass');
echo Form::checkbox('check1','1');
echo Form::close();
?>
@endsection