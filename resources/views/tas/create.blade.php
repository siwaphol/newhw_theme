@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">เพิ่มนักศึกษาช่วยสอน</div>

                    <div class="panel-body">

                        <hr/>

                        {!! Form::open(['url' => 'ta/create/save']) !!}
                        
                        <div class="form-group">
                        {!! Form::label('id', 'Id: ') !!}
                        {!! Form::text('id', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('taName', 'Taname: ') !!}
                        {!! Form::text('taName', null, ['class' => 'form-control']) !!}
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