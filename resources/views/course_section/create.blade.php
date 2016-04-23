@extends('app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Section</div>

                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        {!! Form::open(['url'=>'course_section/create/save']) !!}
                        <div class="form-group">

                            {!! Form::label('courseid','Course')!!}
                            {!! Form::select('courseid',$courses,null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('sectionid','Section')!!}
                            {!! Form::select('sectionid', $sections,null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('teacherid','Lecturer')!!}
                            {!! Form::select('teacherid',$teachers,null,['class'=>'select-search']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Add',['class'=>'btn btn-primary form-control'])!!}
                        </div>
                        <div id='username_availability_result'></div>
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


