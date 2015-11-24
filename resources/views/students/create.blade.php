@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Student</div>
                    @foreach($course as  $item)
                    <div class="panel-body">

                        <hr/>

                        {!! Form::open(['url' => 'students/create/save']) !!}
                         <div class="form-group">
                            {!! Form::label('course_id', 'Course No: ') !!}
                            {!! Form::text('course_id', $item->course_id, ['class' => 'form-control','disabled' => 'disabled']) !!}
                        <div class="form-group">
                            {!! Form::label('section', 'Section: ') !!}
                            {!! Form::text('section', $item->section, ['class' => 'form-control','disabled' => 'disabled'])!!}
                        </div>
                        <div class="form-group">
                        {!! Form::label('student_id', 'Student ID: ') !!}
                        {!! Form::text('student_id', null, ['class' => 'form-control']) !!}
                    {{--<div class="form-group">--}}
                        {{--{!! Form::label('status', 'สถานะ: ') !!}--}}
                        {{--{!! Form::radio('status', 'drop') !!} drop--}}
                        {{--{!! Form::radio('status', 'no',true) !!} no--}}
                        {{--{!! Form::text('status', null, ['class' => 'form-control'])!!}--}}
                    {{--</div>--}}
                    <input type="hidden" name="course_id" value="{{$item->course_id}}">
                    <input type="hidden" name="status" value="">
                     <input type="hidden" name="section" value="{{$item->section}}">
                        <div class="form-group">
                            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control'])!!}
                        </div>
                        {!! Form::close() !!}
                        @endforeach
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