@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Multiple Sections</div>

                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url'=>'course_section/createteacher/']) !!}
                        <div class="form-group">
                            {!! Form::label('courseid','Course')!!}
                            {!! Form::select('courseid',$courses,null,["class"=>"form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('sectionid','Amount of sections to be created')!!}
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


