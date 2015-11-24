@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Semester Year</div>

                    <div class="panel-body">

                        {!! Form::open(['url' => 'semesteryear/create/save']) !!}
                        
                      <div class="form-group">
                        {!! Form::label('semester', 'Semester: ') !!}
                        <select class="form-control" name="semester">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>

                         </select>
                    </div><div class="form-group">

                        {!! Form::label('year', 'Year: ') !!}
                        <select class="form-control" name="year">
                          <option value="{{date("Y")+543-5}}">{{date("Y")+543-5}}</option>
                          <option value="{{date("Y")+543-4}}">{{date("Y")+543-4}}</option>
                          <option value="{{date("Y")+543-3}}">{{date("Y")+543-3}}</option>
                          <option value="{{date("Y")+543-2}}">{{date("Y")+543-2}}</option>
                        <option value="{{date("Y")+543-1}}">{{date("Y")+543-1}}</option>
                        <option value="{{date("Y")+543}}" selected>{{date("Y")+543}}</option>
                        <option value="{{date("Y")+543+1}}">{{date("Y")+543+1}}</option>
                          <option value="{{date("Y")+543+2}}">{{date("Y")+543+2}}</option>
                          <option value="{{date("Y")+543+3}}">{{date("Y")+543+3}}</option>
                            <option value="{{date("Y")+543+4}}">{{date("Y")+543+4}}</option>
                          <option value="{{date("Y")+543+5}}">{{date("Y")+543+5}}</option>
                        </select>
                    </div>

                        <div class="form-group">
                            {!! Form::submit('Add', ['class' => 'btn btn-primary form-control']) !!}
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