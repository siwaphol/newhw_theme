@extends('app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Course</div>
                    <div class="panel-body">
                        {!! Form::open(['url'=>'course','method'=>'post']) !!}
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>เกิดข้อผิดพลาด</strong><br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group">
                                {!! Form::label('course_id','Course No')!!}
                                {!! Form::text('course_id',null,['class'=>'form-control','maxlength'=>6, 'required'])!!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('course_name','Title')!!}
                                {!! Form::text('course_name',null,['class'=>'form-control','required'])!!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Add',['class'=>'btn btn-primary form-control'])!!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection