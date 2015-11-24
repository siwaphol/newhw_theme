@extends('app')
@section('content')

<?php
$sql1=DB::select('select * from courses where id=?',array($course['co']));
$count1=$course['sec'];
$i=0;
$sql=DB::select('select * from users where role_id=0100 order by username');
$count=count($sql);
$key=$sql
?>


<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Assign Lecturer</div>

                    <div class="panel-body">
                    <h4 align="center"> {{$sql1[0]->id}} || {{$sql1[0]->name}}</h4>

{!! Form::open(['url'=>'/course_section/createteacher/save'],true) !!}

<?php for($l=1;$l<=$count1;$l++){ ?>
<input type="hidden" name="courseid" value="{{$course['co']}}">
<div class="form-group">
{!! Form::label('sectionid[]','Section '.$l)!!}
{!! Form::text('sectionid[]','00'.$l,['class'=>'form-control'])!!}
</div>
<div class="form-group">
{!! Form::label('teacherid[]','Lecturer')!!}
<select name="teacherid[]" class="form-control">
<?php
for($i=0;$i<$count;$i++){?>
  <option value={{$key[$i]->id}}>{{$key[$i]->firstname_en." ".$key[$i]->lastname_en}}</option>
  <?php }?>

</select>
</div>
<?php }?>
<div class="form-group">
{!! Form::submit('Add',['class'=>'btn btn-primary form-control'])!!}
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

  @endsection


