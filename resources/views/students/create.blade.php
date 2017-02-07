@extends('app')

@section('content')
    <div class="content">
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Student</div>
                    <div class="panel-body">
                        <hr/>
                        {!! Form::open(['url' => 'students/create/save']) !!}
                        <div class="form-group">
                            {!! Form::label('course_id', 'Course No: ') !!}
                            @if(is_null($id))
                                {!! Form::select('course_id', $course, null, ['class'=>'select2']) !!}
                            @else
                                {!! Form::text('course_id', $id, ['class' => 'form-control', $readonly]) !!}
                            @endif
                            <div class="form-group">
                                {!! Form::label('section', 'Section: ') !!}
                                @if($sections->count() <=0)
                                    {!! Form::text('section',null, ['class' => 'form-control'])!!}
                                @else
                                    {!! Form::select('section', $sections,null, ['class' => 'form-control'])!!}
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label('student_id', 'Student ID: ') !!}
                                {!! Form::text('student_id', null, ['class' => 'form-control']) !!}
                                <input type="hidden" name="status" value="">
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control'])!!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.select2').select2();
    </script>
@endsection