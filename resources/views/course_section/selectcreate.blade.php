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
{!! Form::open(['url'=>'course_section/createteacher/']) !!}
<div class="form-group">

{!! Form::label('courseid','Course')!!}
<select name="courseid" class="form-control">
<?php for($i=0;$i<$count;$i++){?>
  <option value={{$key[$i]->id}}>{{$key[$i]->id."   ".$key[$i]->name}}</option>
  <?php }?>

</select>

</div>
<div class="form-group">
{!! Form::label('sectionid','All Section')!!}
<select class="form-control" name="sectionid">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
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


