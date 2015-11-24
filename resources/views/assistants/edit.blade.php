@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <h1>Edit assistant</h1>
                        <hr/>
                         @foreach($assistant as $key)
                        {!! Form::open(['url' => 'assistants/update']) !!}
                        <input type="hidden" name="id" value="{{$key->id}}">
                        <div class="form-group">
                        {!! Form::label('course_id', 'รหัสกระบวนวิชา: ') !!}
                        {!! Form::text('course_id',$key->course_id, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('section', 'ตอน: ') !!}
                        {!! Form::text('section', $key->section, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('student_id', 'นักศึกษาช่วยสอน ') !!}
                        {!! Form::text('student_id',$key->student_id, ['class' => 'form-control']) !!}
                    </div>
                        
                        <div class="form-group">
                            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
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