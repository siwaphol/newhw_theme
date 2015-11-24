@extends('app')
@section('content')

<?php
$sql=DB::select('select * from courses');
$count=count($sql);
$i=0;
$key=$sql;
?>


<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Section</div>

                    <div class="panel-body">
{!! Form::open(['url'=>'course_section/create/save']) !!}
<div class="form-group">

{!! Form::label('courseid','Course')!!}
<select name="courseid" class="form-control">
<?php for($i=0;$i<$count;$i++){?>
  <option value={{$key[$i]->id}}>{{$key[$i]->id."   ".$key[$i]->name}}</option>
  <?php }?>

</select>

</div>
<div class="form-group">
{!! Form::label('sectionid','Section')!!}
<select class="form-control" name="sectionid">
  <option value="001">001</option>
  <option value="002">002</option>
  <option value="003">003</option>
  <option value="004">004</option>
  <option value="005">005</option>
  <option value="006">006</option>
 </select>
</div>
<div class="form-group">
{!! Form::label('teacherid','Lecturer')!!}
<select name="teacherid" class="form-control">
<?php
$sql=DB::select('select * from users where role_id=0100 order by username');
$count=count($sql);
$key=$sql;
for($i=0;$i<$count;$i++){?>
  <option value={{$key[$i]->id}}>{{$key[$i]->firstname_en." ".$key[$i]->lastname_en}}</option>
  <?php }?>

</select>
</div>

<div class="form-group">
{!! Form::submit('Add',['class'=>'btn btn-primary form-control'])!!}
</div>
<div id='username_availability_result'></div>
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

  @endsection


