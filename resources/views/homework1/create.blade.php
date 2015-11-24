@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Create a new homework</div>

                    <div class="panel-body">
                        {{--<h3 align="center">Create a new homework</h3>--}}
                        <hr/>

                        {!! Form::open(['url' => 'homework/create/save']) !!}
                        
                        {{--<div class="form-group">--}}
                        {{--{!! Form::label('id', 'Id: ') !!}--}}
                        {{--{!! Form::text('id', null, ['class' => 'form-control']) !!}--}}
                    {{--</div>--}}

                    <div class="form-group">
                        {!! Form::label('course_id', 'Course: ') !!}
                        {!! Form::text('course_id', $course['course'], ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('section', 'Section: ') !!}
                        {!! Form::text('section', $course['sec'], ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('name', 'Name: ') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('type_id', 'File Type: ') !!}
                        {{--{!! Form::text('type_id', null, ['class' => 'form-control']) !!}--}}

                        <select id="type_id'" name="type_id" onChange = "ListSection(this.value)" class="form-control">
                            <option selected value="file type"></option>
                        <?php



                                    $sql=DB::select('SELECT * from  homework_types');


                                    $count=count($sql);

                                    $i=0;
                                      for($i=0;$i<$count;$i++){
                                    ?>
                                    <option value={{$sql[$i]->id}}>{{$sql[$i]->id.' '.$sql[$i]->extension}}</option>
                                    <?php
                                    }
                                    ?>
                        </select>
                    </div><div class="form-group">
                        {!! Form::label('detail', 'Detail: ') !!}
                        {!! Form::text('detail', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('sub_folder', 'Sub Folder: ') !!}
                        {!! Form::text('sub_folder', null, array('placeholder'=>'example .lab01','class' => 'form-control')) !!}
                    </div>
                    {{--<div class="form-group">--}}
                        {{--{!! Form::label('assign_date', 'Assign Date: ') !!}--}}
                        {{--{!! Form::text('assign_date', null, ['class' => 'form-control']) !!}--}}
                    {{--</div>--}}
                    <div class="form-group">
                        {!! Form::label('due_date', 'Due Date: ') !!}
                        <input type="date" id="due_date" name="due_date" class="form-control">
                    </div><div class="form-group" >
                        {!! Form::label('accept_date', 'Accept Date: ') !!}
                        <input type="date" id="accept_date" name="accept_date" class="form-control">
                    </div>

                        <div class="form-group">
                            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
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