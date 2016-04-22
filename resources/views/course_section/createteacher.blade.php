@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Assign Lecturer</div>

                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <h4 align="center"> {{$course->id}} || {{$course->name}}</h4>

                        {!! Form::open(['url'=>'/course_section/createteacher/save'],true) !!}
                        <input type="hidden" name="courseid" value="{{$course->id}}">
                        @foreach($sections as $section)
                            <div class="form-group">
                                {!! Form::label('Section') !!}
                                {!! Form::text('sectionid[]', $section, ['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Lecturer') !!}
                                {!! Form::select('teacherid[]',$teachers,null,['class'=>'select-search']) !!}
                            </div>
                        @endforeach
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

@section('script')
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script>
        $(function () {
            $('.select-search').select2();
        });
    </script>
@endsection

